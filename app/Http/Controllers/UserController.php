<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use Auth;
use App\Utils\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return View('User/Index', ['users' => $users]);
    }

    public function details(User $user)
    {
        return __METHOD__;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $jsonResponse = new JsonResponse();
        if($request->input('id'))
        {
            $databaseUser = User::find($request->input('id'));

            if($databaseUser)
            {
                $databaseUser->fullname = trim($request->input('fullname'));
                $databaseUser->email = trim($request->input('email'));
                $databaseUser->address =trim($request->input('address'));
                try{
                    if($databaseUser->save())
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $jsonResponse = new JsonResponse();
        $jsonResponse->isSucceeded = false;
        if($request->input('id'))
        {
            $databaseUser = User::find($request->input('id'));

            if($databaseUser)
            {
                if((Auth::user()->isAdmin() && $databaseUser->isCustomer()) || 
                    (Auth::user()->isAdmin() && Auth::user()->id == $databaseUser->id) ||
                    (Auth::user()->isCustomer() && Auth::user()->id == $databaseUser->id))
                {
                    try{
                        User::destroy($databaseUser->id);
                        $jsonResponse->messages[] = "User has been deleted";
                        if(Auth::user()->id == $databaseUser->id) 
                        {
                            Auth::logout();
                        }
                        $jsonResponse->isSucceeded = true;
                    }catch(\Exception $e){
                        $jsonResponse->messages[] = "Something went wrong while deleting the account"; 
                    }
                }
                else
                {
                    $jsonResponse->messages[] = "You don't have right to delete this account";
                }
            }
            else
            {
                $jsonResponse->messages[] = "Incorrect demand";
            }
            
        }
        else
        {
            $jsonResponse->messages[] = "Incorrect demand";
        }
        return json_encode($jsonResponse);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function block(Request $request)
    {
        $jsonResponse = new JsonResponse();
        $jsonResponse->isSucceeded = false;
        if($request->input('id'))
        {
            $databaseUser = User::find($request->input('id'));

            if($databaseUser)
            {
                if((Auth::user()->isAdmin() && $databaseUser->isCustomer()))
                {
                    try{
                        $databaseUser->blocked = true;
                        $databaseUser->save();
                        $jsonResponse->messages[] = "User has been blocked";
                        $jsonResponse->isSucceeded = true;
                    }catch(\Exception $e){
                        $jsonResponse->messages[] = "Something went wrong while blocking the account"; 
                    }
                }
                else
                {
                    $jsonResponse->messages[] = "You don't have right to block this account";
                }
            }
            else
            {
                $jsonResponse->messages[] = "Incorrect demand";
            }
            
        }
        else
        {
            $jsonResponse->messages[] = "Incorrect demand";
        }
        return json_encode($jsonResponse);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function unblock(Request $request)
    {
        $jsonResponse = new JsonResponse();
        $jsonResponse->isSucceeded = false;
        if($request->input('id'))
        {
            $databaseUser = User::find($request->input('id'));

            if($databaseUser)
            {
                if((Auth::user()->isAdmin() && $databaseUser->isCustomer()))
                {
                    try{
                        $databaseUser->blocked = false;
                        $databaseUser->save();
                        $jsonResponse->messages[] = "User has been unblocked";
                        $jsonResponse->isSucceeded = true;
                    }catch(\Exception $e){
                        $jsonResponse->messages[] = "Something went wrong while unblocking the account"; 
                    }
                }
                else
                {
                    $jsonResponse->messages[] = "You don't have right to unblock this account";
                }
            }
            else
            {
                $jsonResponse->messages[] = "Incorrect demand";
            }
            
        }
        else
        {
            $jsonResponse->messages[] = "Incorrect demand";
        }
        return json_encode($jsonResponse);
    }

    public function makeAdmin(Request $request)
    {
        $jsonResponse = new JsonResponse();
        $jsonResponse->isSucceeded = false;
        if($request->input('id'))
        {
            $databaseUser = User::find($request->input('id'));

            if($databaseUser)
            {
                try{
                    $adminRole = Role::where(['name' => 'admin'])->first();
                    if($adminRole)
                    {
                        $databaseUser->blocked = false;
                        $databaseUser->role_id = $adminRole->id;
                        $databaseUser->save();
                        $jsonResponse->messages[] = "User is now administrator";
                        $jsonResponse->isSucceeded = true;
                    }
                    else
                    {
                        $jsonResponse->messages[] = "Admin role not found. Please consult the service maintenance of the the platform";
                    }
                    
                }catch(\Exception $e){
                    $jsonResponse->messages[] = "Something went wrong while changing account's status"; 
                }
            }
            else
            {
                $jsonResponse->messages[] = "Incorrect demand";
            }
            
        }
        else
        {
            $jsonResponse->messages[] = "Incorrect demand";
        }
        return json_encode($jsonResponse);
    }

    public function removeAdmin(Request $request)
    {
        $jsonResponse = new JsonResponse();
        $jsonResponse->isSucceeded = false;
        if($request->input('id'))
        {
            $databaseUser = User::find($request->input('id'));

            if($databaseUser)
            {
                try{
                    $customerRole = Role::where(['name' => 'customer'])->first();

                    if($customerRole)
                    {
                        $databaseUser->role_id = $customerRole->id;
                        $databaseUser->save();
                        $jsonResponse->messages[] = "User is again a customer";
                        $jsonResponse->isSucceeded = true;
                    }
                    else
                    {
                        $jsonResponse->messages[] = "Customer role not found. Please consult the service maintenance of the the platform";
                    }
                    
                }catch(\Exception $e){
                    $jsonResponse->messages[] = "Something went wrong while changing account's status"; 
                }
            }
            else
            {
                $jsonResponse->messages[] = "Incorrect demand";
            }
            
        }
        else
        {
            $jsonResponse->messages[] = "Incorrect demand";
        }
        return json_encode($jsonResponse);
    }
}
