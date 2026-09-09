<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->can('view inventory'), 403);

        $inventories = Inventory::with(['product.category', 'warehouse'])
            ->latest()
            ->paginate(20);

        return view('inventory.index', compact('inventories'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()->can('manage inventory'), 403);

        $products = Product::orderBy('name')->get();
        $warehouses = Warehouse::orderBy('name')->get();

        return view('inventory.create', compact('products', 'warehouses'));
    }

    public function store(StoreInventoryRequest $request): RedirectResponse
    {
        Inventory::create($request->validated());

        return redirect()->route('inventory.index')->with('status', 'inventory-created');
    }

    public function edit(Request $request, Inventory $inventory): View
    {
        abort_unless($request->user()->can('manage inventory'), 403);

        $products = Product::orderBy('name')->get();
        $warehouses = Warehouse::orderBy('name')->get();

        return view('inventory.edit', compact('inventory', 'products', 'warehouses'));
    }

    public function update(UpdateInventoryRequest $request, Inventory $inventory): RedirectResponse
    {
        $inventory->update($request->validated());

        return redirect()->route('inventory.index')->with('status', 'inventory-updated');
    }

    public function destroy(Request $request, Inventory $inventory): RedirectResponse
    {
        abort_unless($request->user()->can('manage inventory'), 403);

        $inventory->delete();

        return redirect()->route('inventory.index')->with('status', 'inventory-deleted');
    }
}
