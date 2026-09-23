<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->subYear()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $baseQuery = Document::whereBetween('document_date', [$dateFrom, $dateTo]);

        $totalDocuments = (clone $baseQuery)->count();

        $byCategory = Category::select('categories.name', DB::raw('COUNT(documents.id) as count'))
            ->leftJoin('documents', function($join) use ($dateFrom, $dateTo) {
                $join->on('categories.id', '=', 'documents.category_id')
                     ->whereBetween('documents.document_date', [$dateFrom, $dateTo]);
            })
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('count')
            ->get();

        $byStatus = (clone $baseQuery)
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->map(function ($item) {
                $item->label = Document::STATUSES[$item->status] ?? $item->status;
                $item->color = Document::STATUS_COLORS[$item->status] ?? 'gray';
                return $item;
            });

        $byYearMonth = (clone $baseQuery)
            ->select(
                DB::raw('YEAR(document_date) as year'),
                DB::raw('MONTH(document_date) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return view('reports.index', compact('totalDocuments', 'byCategory', 'byStatus', 'byYearMonth', 'dateFrom', 'dateTo'));
    }
}
