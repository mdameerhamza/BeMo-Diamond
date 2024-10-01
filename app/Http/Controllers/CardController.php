<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexing(Request $request)
    {
        // dd($request->all());
        $item = explode('-',$request->item);
        $from = explode('-',$request->from);
        $to = explode('-',$request->to);
        Card::where('id',$item[1])->update([
            'column_id' => $to[1]
        ]);
        foreach ($request->indexing as $key => $value) {
            $v = explode('-',$value);
            $card = Card::where('id',$v[1])->update([
                'index' => $key
            ]);
        }
        return response()->json(['success'=> 'SUCCESS']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        Card:: updateOrCreate(['id' => $request->id],[
            'title' => $request->title,
            'description' => $request->description,
            'column_id' => $request->column_id,
        ]);
        return response()->json(['success'=> 'card added successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $card = Card::where('id',$id)->first();
        return response()->json(['card'=>$card]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Card::find($id)->delete();
        return response()->json(['success'=>'success']);
    }
    
}
