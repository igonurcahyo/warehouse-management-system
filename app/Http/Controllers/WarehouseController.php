<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WarehouseController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->can('view warehouses'), 403);

        $warehouses = Warehouse::latest()->paginate(20);

        return view('warehouse.index', compact('warehouses'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()->can('manage warehouses'), 403);

        return view('warehouse.create');
    }

    public function store(StoreWarehouseRequest $request): RedirectResponse
    {
        Warehouse::create($request->validated());

        return redirect()->route('warehouses.index')->with('status', 'warehouse-created');
    }

    public function edit(Request $request, Warehouse $warehouse): View
    {
        abort_unless($request->user()->can('manage warehouses'), 403);

        return view('warehouse.edit', compact('warehouse'));
    }

    public function update(UpdateWarehouseRequest $request, Warehouse $warehouse): RedirectResponse
    {
        $warehouse->update($request->validated());

        return redirect()->route('warehouses.index')->with('status', 'warehouse-updated');
    }

    public function destroy(Request $request, Warehouse $warehouse): RedirectResponse
    {
        abort_unless($request->user()->can('manage warehouses'), 403);

        $warehouse->delete();

        return redirect()->route('warehouses.index')->with('status', 'warehouse-deleted');
    }
}
