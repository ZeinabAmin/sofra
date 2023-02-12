<?php

namespace App\Http\Controllers\Admin;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $records = Region::with('city')->paginate(20);
        return view('regions.index',compact('records'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('regions.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd($request->all());


        $rules = [
            'name' => 'required|unique:regions,name',
            'city_id' => 'required|exists:cities,id'
        ];
            $messages = [
            'name.required' => 'Region name is required',
            'city_id.required' => 'City id is required',
        ];
            $this->validate($request, $rules, $messages);

            $record = Region::create($request->all());

            flash()->success("success");
            return redirect(route('regions.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Region::findOrFail($id);
        return view('regions.edit',compact('record'));
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

        $record = Region::findOrFail($id);
        $record->update($request->all());
        flash()->success("Updated");
        return back();
        return redirect(route('regions.index',$record->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $record = Region::findOrFail($id);
      $record->delete();
      flash()->success("Deleted");
      return back();

    }
}
