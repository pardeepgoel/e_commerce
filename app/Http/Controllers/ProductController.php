<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    
    public function list(Request $request)
    {
        $keyword = $request->keyword;
        $limit = $request->limit;
        
        $status = 'success';
        if ($keyword) {
            $products = Product::where('name', 'LIKE', '%' . $keyword . '%')->paginate($limit);
        } else {
            $products = Product::paginate($limit);
        }
        
        return response()->json(compact('status', 'products'), 200);
    }
    public function details($id)
    {
        $status = 'success';
        $product = Product::find($id);
        return response()->json(compact('status', 'product'), 200);
        
    }
}
