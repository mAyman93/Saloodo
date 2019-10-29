<?php

namespace App\Http\Controllers;
use App\Bundle;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    protected $bundlesModel;

    public function __construct(Bundle $bundles)
    {
        $this->bundlesModel = $bundles;
    }

    public function getAll(Request $request)
    {
        $bundles = $this->bundlesModel->getAll();
        return response()->json(['bundles' => $bundles]);
    }

    public function create(Request $request)
    {
        if(!$request->has('products') || !$request->has('name') || !$request->has('price') 
        || !$request->has('quantity')) {
            return response()->json(['error' => 'missing parameters'], 400);
        }
        $bundleId = $this->bundlesModel->create($request->post());
        if(!$bundleId) {
            return response()->json(['error' => 'error'], 400);
        }
        return response()->json(['bundleId' => $bundleId]);
    }
}
