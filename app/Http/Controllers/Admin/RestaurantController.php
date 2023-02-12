<?php

namespace App\Http\Controllers\Admin;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = Restaurant::where(function ($query) use($request){
            if ($request->input('keyword')) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%'.$request->keyword.'%');
                });
            }
        })->paginate(20);

return view('restaurants.index', compact('records'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = Restaurant::findOrFail($id);
  return view('restaurants.show',compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Restaurant::findOrFail($id);
        $record->delete();
        flash()->success("Deleted");
        return back();

    }

    public function activate($id)
    {


        $client = Restaurant::findOrFail($id);
        $client->update(['is_active' => 1]);
        flash()->success('activate');
        return back();
    }




    public function deactivate($id)
    {
        $client = Restaurant::findOrFail($id);
        $client->update(['is_active' => 0]);
        flash()->success('deactivate');
        return back();
    }



}
