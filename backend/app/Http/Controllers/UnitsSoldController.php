<?php

namespace App\Http\Controllers;

use App\Models\SaleController;
use Illuminate\Http\Request;
use App\Models\Product;

class UnitsSoldController extends Controller
{
    public function index()
    {
        $unitsSold = Product::select('products.id', 'products.title as product')
            ->selectRaw('SUM(offer_product.product_quantity * sales.offer_quantity) as quantity')
            ->join('offer_product', 'products.id', '=', 'offer_product.product_id')
            ->join('offers', 'offer_product.offer_id', '=', 'offers.id')
            ->join('sales', 'offers.id', '=', 'sales.offer_id')
            ->groupBy('products.id', 'products.title')
            ->orderByDesc('quantity')
            ->get();

        return response()->json($unitsSold);
    }
}
