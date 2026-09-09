<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->can('view categories'), 403);

        $categories = Category::latest()->paginate(20);

        return view('category.index', compact('categories'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()->can('manage categories'), 403);

        return view('category.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return redirect()->route('categories.index')->with('status', 'category-created');
    }

    public function edit(Request $request, Category $category): View
    {
        abort_unless($request->user()->can('manage categories'), 403);

        return view('category.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()->route('categories.index')->with('status', 'category-updated');
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        abort_unless($request->user()->can('manage categories'), 403);

        $category->delete();

        return redirect()->route('categories.index')->with('status', 'category-deleted');
    }
}
