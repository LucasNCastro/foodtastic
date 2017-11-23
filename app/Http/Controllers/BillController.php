<?php

namespace App\Http\Controllers;

use PDF;
Use Validator;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BillController extends Controller
{
    public function generate(Request $request)
    {
        $cartDetails = array();
        if($request->session()->has('cart'))
        {
            foreach($request->session()->get('cart') as $item) 
            {
                $product = Product::find($item['product_id']);
                $product->image_path = Storage::url($product->image_path);
                $cartDetails[]['product'] = $product;
                $cartDetails[]['quantity'] = $item['quantity'];
            }
        }
        
        $pdf = PDF::loadView('bill\bill_template', ['cart' => $cartDetails]);
        Storage::put('pp.pdf', $pdf->output());
        //return View('bill\bill_template', ['cart' => $cartDetails]);
        return $pdf->download('bill.pdf');
    }
}