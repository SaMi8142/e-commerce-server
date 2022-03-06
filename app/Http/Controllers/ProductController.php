<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        
        if (env('ADMIN') != $user->email){
            $res = ['message' => 'Unauthorized'];
            return response($res, 403);
        }
        $request->validate([
            'productName' => 'required|unique:products,productName',
            'image' => 'required',
            'price' => 'required'
        ]);

        return Product::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $foundProduct = Product::find($id);
        $status = 200;
        if(!$foundProduct){
            $status = 404;
        }    
        
        $res = ['product' => $foundProduct];
        return response($res, $status);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        
        if (env('ADMIN') != $user->email){
            $res = ['message' => 'Unauthorized'];
            return response($res, 403);
        }

        $foundProduct = Product::find($id);
        $status = 404;
        if($foundProduct){
            $foundProduct->update($request->all());
            $status = 201;
        }

        $res = ['product' => $foundProduct];
        return response($res, $status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();
        
        if (env('ADMIN') != $user->email){
            $res = ['message' => 'Unauthorized'];
            return response($res, 403);
        }
        return Product::destroy($id);
    }
}
