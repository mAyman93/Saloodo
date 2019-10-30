<?php

namespace App;
use App\Product;
use DB;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Product
{
    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(function ($query) {
            $query->join('products', 'products.id', '=', 'bundles.related_product_id');
        });
    }

    public function getAll()
    {
        return Bundle::all();
    }

    public function get($id)
    {
        return Bundle::find($id);
    }

    public function create($bundleData)
    {
        $productsArray = $bundleData['products'];
        unset($bundleData['products']);
        $bundle = new Bundle;
        DB::transaction(function () use ($bundle, $bundleData, $productsArray) {
            $bundleRelatedProductId = Product::create($bundleData);
            $bundle->related_product_id = $bundleRelatedProductId;
            $bundle->products_ids = '{"products":' . json_encode($productsArray) . '}';
            $bundle->save();
        });
        return $bundle->id;
    }
}

