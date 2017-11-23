<?php

namespace App\Http\Controllers;

use App\Utils\JsonResponse;
use App\City;
use App\Product;
use App\ProductAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
        
        return View('cart/index', ['cart' => $cartDetails]);
    }

    public function add(Request $request)
    {
        $jsonResponse = new JsonResponse();
        $jsonResponse->isSucceeded = false;

        if($request->input('product_id') && $request->input('quantity') && $request->input('unit_price') && $request->session()->get('selectedCity'))
        {
            $productId = $request->input('product_id');
            $quantity = $request->input('quantity');
            $cart = $request->session()->get('cart');
            if(!$cart)
            {
                $cart = array();
            }
            $productAvailabilty = ProductAvailability::where(['product_id' => $productId, 'city_id' => $request->session()->get('selectedCity')->id])->first();
            if($productAvailabilty)
            {
                $productAlreadyAvailableInTheCart = false;
                foreach($cart as $k => $item)
                {
                    if($item['product_id'] == $productId)
                    {
                        $productAlreadyAvailableInTheCart = true;
                        $item['quantity'] = (int)$item['quantity'];
                        if($productAvailabilty->quantity >= ($item['quantity'] + $quantity))
                        {
                            $cart[$k]['quantity'] += $quantity;
                            $jsonResponse->isSucceeded = true;
                        }
                        else
                        {
                            $jsonResponse->messages[] = "You cant' add more than " . $productAvailabilty->quantity ." for this product";
                        }
                        break;
                    }
                }
                if($productAlreadyAvailableInTheCart && $jsonResponse->isSucceeded = true)
                {
                    $request->session()->put('cart', $cart);
                    $jsonResponse->messages[] = "The number of quantity has been updated in the cart for this product";
                }
                else
                {
                    $cart[] = ['product_id' => $productId, 'quantity' => $quantity];
                    $request->session()->put('cart', $cart);
                    $jsonResponse->isSucceeded = true;
                    $jsonResponse->messages[] = "The product has been successfully added to the cart";
                }

            }
            else
            {
                $jsonResponse->messages[] = "The product that you selected is not in the stock";
            }

        }
        else
        {
            $jsonResponse->messages[] = "The product has not been added to the cart";
        }
        return json_encode($jsonResponse);

    }

    public function updateQuantity(Request $request)
    {
        $jsonResponse = new JsonResponse();
        $jsonResponse->isSucceeded = false;

        if($request->input('product_id') && $request->input('quantity') && $request->session()->get('selectedCity'))
        {
            $productId = $request->input('product_id');
            $quantity = (int)$request->input('quantity');
            $cart = $request->session()->get('cart');
            

            $productAvailabilty = ProductAvailability::where(['product_id' => $productId, 'city_id' => $request->session()->get('selectedCity')->id])->first();
            
            if($quantity < 1)
            {
                $jsonResponse->messages[] = "Quantity must be a number greater than 0";
            }
            else
            {
                if($productAvailabilty)
                {
                    $productAlreadyAvailableInTheCart = false;
                    foreach($cart as $k => $item)
                    {
                        if($item['product_id'] == $productId)
                        {
                            $productAlreadyAvailableInTheCart = true;
                            $item['quantity'] = (int)$item['quantity'];
                            if($productAvailabilty->quantity >= $quantity)
                            {
                                $cart[$k]['quantity'] = $quantity;
                                $jsonResponse->isSucceeded = true;
                            }
                            else
                            {
                                $jsonResponse->messages[] = "You cant' add more than " . $productAvailabilty->quantity ." for this product";
                            }
                            break;
                        }
                    }
                    if($jsonResponse->isSucceeded = true)
                    {
                        $request->session()->put('cart', $cart);
                        $jsonResponse->messages[] = "The number of quantity has been updated in the cart for this product";
                    }
    
                }
                else
                {
                    $jsonResponse->messages[] = "The product that you selected is not in the stock";
                }
            }
            

        }
        else
        {
            $jsonResponse->messages[] = "The product has not been added to the cart";
        }
        return json_encode($jsonResponse);

    }

    public function productRemove(Request $request)
    {
        $jsonResponse = new JsonResponse();
        $jsonResponse->isSucceeded = false;

        if($request->input('product_id') && $request->session()->get('selectedCity'))
        {
            $productId = $request->input('product_id');
            $cart = $request->session()->get('cart');
            
            foreach($cart as $k => $item)
            {
                if($item['product_id'] == $productId)
                {
                    unset($cart[$k]);
                }
            }
            if($jsonResponse->isSucceeded = true)
            {
                $request->session()->put('cart', $cart);
                $jsonResponse->messages[] = "The product has been succesfully removed";
            }
            

        }
        else
        {
            $jsonResponse->messages[] = "The product has not been removed from the cart";
        }
        return json_encode($jsonResponse);

    }
}