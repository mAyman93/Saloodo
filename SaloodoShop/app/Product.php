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

    public function getAllProductsDetails()
    {
        return Product::select([
            'name', 'description', 'price', 'image_url', 'quantity', 'amount', 'type'])
            ->leftJoin('discounts', 'products.id', '=', 'discounts.product_id')
            ->get();
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

}
