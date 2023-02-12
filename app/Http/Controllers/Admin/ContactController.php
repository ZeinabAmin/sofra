<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = Contact::where(function ($query) use($request){
            if ($request->input('keyword')) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%'.$request->keyword.'%');
                    $query->orWhere('email', 'like', '%'.$request->keyword.'%');
                    $query->orWhere('message_type', 'like', '%'.$request->keyword.'%');
                    $query->orWhere('content', 'like', '%'.$request->keyword.'%');

                    // $query->orWhereHas('region',function($query) use($request){
                    //     $query->where('name','like','%'.$request->input('region_id').'%');
                    // });
                });
            }
        })->paginate(20);
        return view('contacts.index',compact('records'));
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
        $record = Contact::findOrFail($id);
      $record->delete();
      flash()->success("Deleted");
      return back();
    }
}
