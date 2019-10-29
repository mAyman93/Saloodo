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
        $product = $this->productsModel->get($productId);
        if(!$product) {
            return response()->json(['error' => 'product not found'], 404);
        }
        $product->calculateFinalPrice();
        return response()->json($product);
    }

    /**
     * Get all products
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getAll(Request $request)
    {
        $products = $this->productsModel->getAll();
        foreach($products as $product) {
            $product->calculateFinalPrice();
        }
        return response()->json(['products' => $products]);
    }

    /**
     * Create new product
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        if(!$request->has('name') || !$request->has('price') 
        || !$request->has('quantity')) {
            return response()->json(['error' => 'missing parameters'], 400);
        }
        $newProductId = $this->productsModel->create($request->post());
        return response()->json(['product_id' => $newProductId]);
    }
    
}
