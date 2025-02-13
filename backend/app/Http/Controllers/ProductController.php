<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $product = Product::create($request->only('title'));

        return response()->json(['message' => 'Produto criado com sucesso!', 'product' => $product], 201);

    }

    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->only('title'));

        return response()->json(['message' => 'Produto atualizado com sucesso!', 'product' => $product]);
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->offers()->exists()) {
            return response()->json(['message' => 'Produto já pertence a uma oferta.'], 400);
        }

        $product->delete();

        return response()->json(['message' => 'Produto excluído com sucesso.']);
    }
}
