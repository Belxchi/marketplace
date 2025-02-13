<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
class SaleController extends Controller
{

    public function index()
    {
        $sales = Sale::with('offer')->get();
        return response()->json($sales);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'offer_id' => 'required|exists:offers,id',
            'offer_quantity' => 'required|integer|min:max:9999',
            'sale_date' => 'required|date|before_or_equal:today',
        ]);

        $sale = Sale::create($request->all());
        return response()->json($sale);
    }

    public function show(string $id)
    {
        $sale = Sale::with('offer')->findOrFail($id);
        return response()->json($sale);
    }

    public function update(Request $request, string $id)
    {
        $sale = Sale::findOrFail($id);
        $sale->update($request->all());
        return response()->json($sale);
    }

    public function destroy(string $id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();
        return response()->json(['message' => 'Venda excluída com sucesso.']);
    }
}
