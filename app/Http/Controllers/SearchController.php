<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with(['category', 'creator'])
            ->where('status', Document::STATUS_APPROVED);

        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('document_number', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('tags', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $documents = $query->orderBy('document_date', 'desc')->paginate(10)->withQueryString();

        return view('search.index', compact('documents'));
    }
}
