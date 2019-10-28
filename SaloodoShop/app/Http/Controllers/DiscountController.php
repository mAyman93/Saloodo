<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discount;

class DiscountController extends Controller
{
    protected $discountsModel;

    public function __construct(Discount $discounts)
    {
        $this->discountsModel = $discounts;
    }

    public function getAll(Request $request)
    {
        return Discount::getAll();
    }

    public function getByProject(Request $request)
    {
        $projectId = $request->projectId;
        return Discount::getByProject($projectId);
    }

    public function create(Request $request)
    {
        if(!$request->has('product_id') || !$request->has('type') 
        || !$request->has('amount') || !$request->has('expiry_date')) {
            return response()->json(['error' => 'missing parameters'], 400);
        }
        return $this->discountsModel->create($request->post());
    }
}
