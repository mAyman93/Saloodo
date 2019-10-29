<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Discount;

class Product extends Model
{
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    public function get($id)
    {
        return Product::find($id);
    }

    public function getAll()
    {
        return Product::all();
    }

    public function calculateFinalPrice()
    {
        $priceAfterDiscount = $this->getPriceAfterDiscount();
        if($priceAfterDiscount != $this->price) {
            $this->finalPrice = $priceAfterDiscount;
        }
    }

    public function getPriceAfterDiscount()
    {
        $productId = $this->id;
        $productPrice = $this->price;
        $discount = Discount::getByProject($productId);
        if(!$discount) {
            return $productPrice;
        }
        $discountAmount = $discount->amount;
        $discountType = $discount->type;
        if($discountType == 'percentage') {
            return $productPrice - ($productPrice * ($discountAmount / 100));
        } else if($discountType == 'concrete') {
            return $productPrice - $discountAmount;
        }
    }

    public function create($productData)
    {
        $product = new Product; // Product::create($productData);
        $product->name = $productData['name'];
        $product->description = $productData['description'];
        $product->price = $productData['price'];
        $product->quantity = $productData['quantity'];
        $product->image_url = $productData['image_url'];
        $product->save();
        return $product->id;
    }

    public function scopeBundle($query)
    {
        return $query->join('bundles', 'products.id', '=', 'bundles.related_product_id');
    }

}