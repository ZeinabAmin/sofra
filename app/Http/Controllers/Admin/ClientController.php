<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = Client::where(function ($query) use($request){
            if ($request->input('keyword')) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%'.$request->keyword.'%');
                    $query->orWhere('phone', 'like', '%'.$request->keyword.'%');
                    $query->orWhere('email', 'like', '%'.$request->keyword.'%');
                    $query->orWhereHas('region',function($query) use($request){
                        $query->where('name','like','%'.$request->input('region_id').'%');
                    });
                });
            }
        })->paginate(10);

return view('clients.index', compact('records'));
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

        $record = Client::findOrFail($id);
        if($record->orders()->count()  ){
       flash()->error("cant delete , this client has orders");
          return back();
        }
       $record->delete();
       flash()->success("Deleted");
        return back();

    }

    public function activate($id)
    {


        $client = Client::findOrFail($id);
        $client->update(['is_active' => 1]);
        flash()->success('activate');
        return back();
    }




    public function deactivate($id)
    {
        $client = Client::findOrFail($id);
        $client->update(['is_active' => 0]);
        flash()->success('deactivate');
        return back();
    }



}


