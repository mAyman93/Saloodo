<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    public function get($id)
    {
        return Discount::find($id);
    }

    public function getAll()
    {
        return Discount::all();
    }

    public static function getByProject($projectId)
    {
        return Discount::select(['amount', 'type', 'expiry_date'])
            ->where('product_id', $projectId)
            ->first();
    }

    public function create($discountData)
    {
        $discount = Discount::updateOrCreate(
            ['project_id' => $discountData->project_id],
            ['amount' => $discountData->amount, 'type' => $discountData->type,
            'expiry_date' => $discountData->type]
        );
        return $discount->id;
    }
}
