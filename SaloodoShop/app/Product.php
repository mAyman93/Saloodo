<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function get($id)
    {
        return Product::find($id);
    }

    public function getProductDetails($id)
    {
        return Product::find($id, 
            ['name', 'description', 'price', 'image_url', 'quantity']);
    }

    public function getAll()
    {
        return Product::all();
    }
}
