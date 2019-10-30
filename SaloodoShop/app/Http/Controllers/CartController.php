<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Product;
use JWTAuth;

class CartController extends Controller
{
    protected $cart;

    public function viewCart(Request $request)
    {
        $user = $request->user();
        $this->cart = Cart::session($user->id);
        $cartContent = $this->cart->getContent()->toArray();
        $cartTotal = $this->cart->getTotal();
        return response()->json(['cart' => $cartContent, 'total' => $cartTotal]);
    }

    public function addProduct(Request $request)
    {
        $user = $request->user();
        $this->cart = Cart::session($user->id);
        if(!$this->valdiateRequestPayload($request)) {
            return response()->json(['error' => 'invalid inputs'], 400);
        }
        $product = $request->product;
        $productId = $product['id'];
        $productName = $product['name'];
        $productPrice = $product['price'];
        $productQuantity = $product['quantity'];
        if(!$this->validateAndUpdateQuantity($productId, $productQuantity)) {
            return response()->json(['error' => 'out of stock'], 400);
        }
        $item = $this->cart->add($productId, $productName, $productPrice, $productQuantity, array());
        return response(array(
            'success' => true,
            'data' => $item,
            'message' => "item added."
        ),201,[]);
    }

    public function removeProduct(Request $request)
    {
        $user = $request->user();
        $this->cart = Cart::session($user->id);
        if(!$request->has('productId')) {
            return response()->json(['error' => 'invalid inputs'], 400);
        }
        $productId = $request->productId;
        $product = $this->cart->get($producId);
        $this->cart->remove($productId);
        $this->validateAndUpdateQuantity($producId, ($product['quantity'] * -1));
        return response()->json(['success' => 'item removed successfuly'], 200);
    }

    public function changeProductQuantity(Request $request)
    {
        $user = $request->user();
        $this->cart = Cart::session($user->id);
        if(!$request->has('id') || !$request->has('quantity')) {
            return response()->json(['error' => 'invalid inputs'], 400);
        }
        $productId = $request->id;
        $productQuantity = $request->quantity;
        $product = $this->cart->get($producId);
        $quantityDifference = $productQuantity - $product['quantity'];
        if(!$this->validateAndUpdateQuantity($productId, $quantityDifference)) {
            return response()->json(['error' => 'out of stock'], 400);
        }
        $this->cart->update($productId, ['quantity' => $productQuantity]);
        return response()->json(['success' => 'quantity updated successfuly'], 200);
    }

    public function empty(Request $request)
    {
        $this->cart->clear();
        return response()->json(['success' => 'cart cleared'], 200);
    }

    public function valdiateRequestPayload(Request $request)
    {
        if(!$request->has('product')) {
            return false;
        }
        $product = $request->product;
        if(isset($product['id']) && isset($product['name']) 
        && isset($product['price']) && isset($product['quantity'])) {
            return true;
        }
        return false;
    }

    public function validateAndUpdateQuantity($productId, $quantityToIncrementBy)
    {
        return Product::validateAndUpdateQuantity($productId, $quantityToIncrementBy);
    }

    public function checkout(Request $request)
    {
        $this->cart->clear();
        return response()->json(['success' => 'order placed successfuly'], 200);
    }
}
