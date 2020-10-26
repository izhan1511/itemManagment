<?php

namespace App\Http\Controllers;

use App\items;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $item = items::where('user_id',$request->user()->id)->get();
        if(!$item->isEmpty()){
            return items::where('user_id',$request->user()->id)->update([
                'items' => json_encode($request['item'])
            ]); 
        }elseif(count($request['item'])>0){
            return items::create([
                'user_id'=>$request->user()->id,
                'items' => json_encode($request['item'])
            ]); 
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\items  $items
     * @return \Illuminate\Http\Response
     */
    public function show(request $request)
    {
        return response()->json(items::where('user_id',$request->user()->id)->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\items  $items
     * @return \Illuminate\Http\Response
     */
    public function edit(items $items)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\items  $items
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, items $items)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\items  $items
     * @return \Illuminate\Http\Response
     */
    public function destroy(items $items)
    {
        //
    }
}
