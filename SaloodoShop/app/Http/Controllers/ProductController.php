<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    protected $productsModel;

    public function __construct(Product $products)
    {
        $this->productsModel = $products;
    }
    /**
     * Get a product's details
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request)
    {
        $productId = $request->id;
        $product = $this->productsModel->getProductDetails($productId);
        if(!$product) {
            return response()->json(['error' => 'product not found'], 404);
        }
        return response()->json($product);
    }

    public function getAll(Request $request)
    {
        $products = $this->productsModel->getAll();
        return response()->json(['products' => $products]);
    }
    
}
