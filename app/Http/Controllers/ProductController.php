<?php

namespace App\Http\Controllers;

use App\Product;
use App\City;
use App\Producer;
use App\Category;
use App\ProductAvailability;
use App\Utils\JsonResponse;
use URL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return __METHOD__;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            $validator = Validator::make($request->all(), [
                'name' => 'bail|required|max:255',
                'price' => 'bail|required|numeric',
                'category' => 'bail|required|numeric',
                'producer' => 'bail|required|numeric',
            ]);

            $errorMessages = $validator->errors();
            if($errorMessages->count() == 0)
            {
                $databaseCategory = Category::find($request->input('category'));

                if($databaseCategory)
                {
                    $databaseProducer = Producer::find($request->input('category'));

                    if($databaseProducer)
                    {
                        $product = new Product();
                        $product->name = $request->input('name');
                        $product->price = $request->input('price');
                        $product->category_id = $request->input('category');
                        $product->producer_id = $request->input('producer');
                        $product->description = $request->input('description');
                        if ($request->has('image') && $request->file('image')->isValid()) {
                            $product->image_path = $request->file('image')->storeAs(
                                'public/products-images', $request->input('name') .'.'.$request->image->extension()
                            );
                        }
            
                        try{
                            
                            $product->save();
                            return redirect('Product/'.$product->id.'/Stock/Update/');
                        }catch(\Exception $e){
                            $errorMessages->add('other', 'Something went wrong while saving it to the database');
                        }
                    }
                    else
                    {
                        $errorMessages->add('producer', 'Selected producer doesn\'t exist');
                    }
                }
                else
                {
                    $errorMessages->add('category', 'Selected category doesn\'t exist');
                }
            }
            return redirect()
                    ->route('product_create')
                    ->withErrors($errorMessages);
        }
        else
        {
            return View('Product/create', ['producers' => Producer::all(), 'categories' => Category::all()]);
        }
    }

    public function updateStock(Request $request, $product_id)
    {
        if($request->isMethod('post'))
        {
            $jsonResponse = new JsonResponse();
            $jsonResponse->isSucceeded = false;

            $validator = Validator::make($request->all(), [
                'city_id' => 'bail|required|numeric',
                'product_id' => 'bail|required|numeric',
                'quantity' => 'bail|required|integer'
            ]);

            $errorMessages = $validator->errors();
            if($errorMessages->count() == 0)
            {
                $databaseCity = City::find($request->input('city_id'));
                if($databaseCity)
                {
                    $databaseProduct = Product::find($request->input('product_id'));

                    if($databaseProduct)
                    {
                        $productAvailability = new ProductAvailability();
                        $productAvailability->city_id = $databaseCity->id;
                        $productAvailability->product_id = $databaseProduct->id;
                        $productAvailability->quantity = $request->input('quantity');

                        try{
                            $productAvailability->save();
                            $jsonResponse->isSucceeded = true;
                            $jsonResponse->messages[] = "Quantity has been updated for the selected city";
                        }catch(\Exception $e){
                            dd($e);
                            $jsonResponse->messages[] = "Something went wrong while updating quantity";
                        }
                    }
                    else
                    {
                        $jsonResponse->messages[] = "Product is missing";
                    }
                }
                else
                {
                    $jsonResponse->messages[] = "City is missing";
                }
                
            }
            else
            {
                foreach($errorMessages->getMessages() as $errorMessage)
                {
                    $jsonResponse->messages[] = $errorMessage;
                }
                
            }
            return json_encode($jsonResponse);
        }
        else
        {
            $databaseProduct = Product::find($product_id);

            if($databaseProduct)
            {
                $cities = City::all();
                
                $assocCitiesQuantity = array();

                if($cities->count() > 0)
                {
                    $productAvailabilities =  ProductAvailability::where(['product_id' => $product_id])->get();
                    foreach($cities as $city)
                    {
                        $quantityFound = false;
                        

                        foreach($productAvailabilities as $productAvailability)
                        {
                            
                            if($productAvailability->city_id == $city->id)
                            {
                                $assocCitiesQuantity[$city->id] = ['quantity' => $productAvailability->quantity, 'city' => $city->name];
                                $quantityFound = true;
                                break;
                            }
                        }

                        if(!$quantityFound)
                        {
                            $assocCitiesQuantity[$city->id] = ['quantity' => 0, 'city' => $city->name];
                        }
                    }
                }
                return View('Product/update_stock', ['citiesWithQuantity' => $assocCitiesQuantity, 'product_id' => $product_id]);
            }
            else
            {
                return View('Product/Index');
            }
            
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request, $product_id)
    {
        $product = Product::find($product_id);

        if($product)
        {
            $image_url = Storage::url($product->image_path);
            return View('product\details', ['product' => $product, "image_url" => $image_url]);
        }
        $request->session()->flash('info', 'Product for which you\'re looking for doesn\'t exist');
        return redirect(URL::previous());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         
        
    }
}
