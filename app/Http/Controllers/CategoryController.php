<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('documents')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category = Category::create($validated);

        AuditLog::log(
            'category_created',
            "Kategori '{$category->name}' berhasil dibuat.",
            Category::class,
            $category->id,
        );

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $category->update($validated);

        AuditLog::log(
            'category_updated',
            "Kategori '{$category->name}' diperbarui.",
            Category::class,
            $category->id,
        );

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->documents()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki dokumen.');
        }

        AuditLog::log(
            'category_deleted',
            "Kategori '{$category->name}' dihapus.",
            Category::class,
            $category->id,
        );

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
