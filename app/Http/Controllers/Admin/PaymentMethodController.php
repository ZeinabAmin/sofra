<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = PaymentMethod::paginate(10);
        return view('payment-methods.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment-methods.create');
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
            'name' => 'required|unique:payment_methods'
        ];
        $messages = [
            'name.required' => 'Name is required',
            'name.unique' => 'Name must be unique',


        ];
        $this->validate($request, $rules, $messages);

       PaymentMethod::create($request->all());

        flash()->success("success");
        return redirect(route('payment-methods.index'));
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
        $model = PaymentMethod::findOrFail($id);
        return view('payment-methods.edit', compact('model'));
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
        $rules = [
            'name' => 'required|unique:payment_methods'
        ];
        $messages = [
            'name.required' => 'Name is required',
            'name.unique' => 'Name must be unique',


        ];
        $this->validate($request, $rules, $messages);

        $record = PaymentMethod::findOrFail($id);
        $record->update($request->all());
        flash()->success("Edited");
         return redirect(route('payment-methods.index', $record->id));
      

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $record = PaymentMethod::findOrFail($id);

        if ($record->orders()->count()) {
            flash()->error("cant delete,this paymentMethod has orders");
            return back();
        }
        $record->delete();
        flash()->success("Deleted");
        return back();
    }
}
