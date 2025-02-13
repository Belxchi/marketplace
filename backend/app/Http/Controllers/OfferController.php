<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;

class OfferController extends Controller
{

    public function index()
    {
        $products = Offer::all();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.value' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1|max:1000',
        ]);

        $offer = new Offer();
        $offer->title = $request->input('title');
        $offer->save();

        $productsData = [];
        foreach ($request->input('products') as $product) {
            $productsData[$product['value']] = ['product_quantity' => $product['quantity']];
        }

        $offer->products()->attach($productsData);

        return response()->json([
            'message' => 'Oferta criada com sucesso!',
            'offer' => $offer
        ], 201);
    }

    public function show(string $id)
    {
        $offer = Offer::with('products')->findOrFail($id);

        $offerData = [
            'id' => $offer->id,
            'title' => $offer->title,
            'products' => $offer->products->map(function($product) {
                return [
                    'value'    => $product->id,
                    'label'    => $product->title,
                    'quantity' => $product->pivot->product_quantity
                ];
            })->toArray()
        ];

        return response()->json($offerData);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.value' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1|max:1000',
        ]);

        $offer = Offer::findOrFail($id);
        $offer->title = $request->input('title');
        $offer->save();

        $productsData = [];
        foreach ($request->input('products') as $product) {
            $productsData[$product['value']] = ['product_quantity' => $product['quantity']];
        }

        $offer->products()->sync($productsData);

        return response()->json([
            'message' => 'Oferta atualizada com sucesso!',
            'offer' => $offer
        ]);
    }

    public function destroy(string $id)
    {
        $offer = Offer::findOrFail($id);

        if ($offer->sales()->exists()) {
            return response()->json(['message' => 'Oferta já possui vendas.'], 400);
        }

        $offer->delete();

        return response()->json(['message' => 'Oferta excluída com sucesso.']);
    }
}
