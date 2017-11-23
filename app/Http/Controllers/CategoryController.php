<?php

namespace App\Http\Controllers;

Use Validator;
use App\Category;
use Illuminate\Http\Request;
use App\Utils\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
         $categories = Category::all();
 
         return View('Category/Index', ['categories' => $categories]);
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
                 'name' => 'bail|required|max:255'
             ]);
 
             $errorMessages = $validator->errors();
 
             if($errorMessages->count() == 0)
             {
                 $sameCategoryInDb = Category::where(['name' => $request->name])->first();

                 if(!$sameCategoryInDb)
                 {
                    $category = new Category();
                    $category->name = $request->name;
        
                    try{
                        $category->save();
                        return redirect()
                            ->route('category');
                    }catch(\Exception $e){
                        $errorMessages->add('name', 'Something went wrong while saving it to the database');
                    }
                 }
                 else
                 {
                    $errorMessages->add('name', 'Category name is already taken.');
                 }
                 
             }
             return redirect()
                     ->route('category_create')
                     ->withErrors($errorMessages);
         }
         
         return View('Category/Create');
     }
 
 
     /**
      * Display the specified resource.
      *
      * @param  \App\Category  $category
      * @return \Illuminate\Http\Response
      */
     public function details(Category $category)
     {
         return __METHOD__;
     }
 
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  \App\Category  $category
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request)
     {
         $jsonResponse = new JsonResponse();
 
         if($request->input('id'))
         {
             $databaseCategory = Category::find($request->input('id'));
 
             if($databaseCategory)
             {
                 $databaseCategory->name = $request->input('name');
 
                 try{
                     if($databaseCategory->save())
                     {
                         $jsonResponse->isSucceeded = true;
                         return json_encode($jsonResponse);
                     }
                 }catch(\Exception $e){}
                 
             }
         }
         $jsonResponse->isSucceeded = false;
         return json_encode($jsonResponse);
     }
}
