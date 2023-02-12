<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\Meal;
use App\Models\Offer;
use App\Models\Region;
use App\Models\Contact;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function cities(){

        $cities=City::all();
        return responseJson(1,"success",$cities);
    }
    public function regions(Request $request){

    $regions=Region::where(function ($query)use($request){

    if($request->has('city_id')){
        $query->where('city_id',$request->city_id);
    }
    })->paginate(15);
    return responseJson(1,"success",$regions);

    }
         public function settings(){

        $setting = Setting::first();

        return responseJson(1,'success',$setting);

       }


       public function categories()
    {
        $categories = Category::all();
        return responseJson(1,'success',$categories);
    }


       public function paymentMethods()
    {
        $paymentMethods = PaymentMethod::all();
        return responseJson(1 , 'success' , $paymentMethods);
    }

    public function contact(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'message_type' => 'required|in:complaint,suggestion,inquiry',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'content' => 'required'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        Contact::create($request->all());

        return responseJson(1,'تم الارسال بنجاح');
    }

    //////////////////
    public function meal(Request $request)
    {
        $meal = Meal::find($request->meal_id);
        if (!$meal) {
            return responseJson(0, 'no meal found');
        }
        return responseJson('1','success',$meal);
    }

 public function meals(Request $request)
    {
        $meals = Meal::where(function ($query) use ($request) {
            if ($request->has('restaurant_id')) {

                $query->where('restaurant_id', $request->restaurant_id);
            }
        })->paginate(20);

        if (!$meals) {
            return responseJson(0, 'no meals found');
        }
        return responseJson('1','success',$meals);
    }




    ////////////////////////////
public function allOffers()
    {
        $offers= Offer::paginate(20);
        return responseJson(1,'success',$offers);
    }


    public function offer( Request $request)
    {
        $offer = Offer::find($request->offer_id)->with('restaurant');
        if (!$offer) {
            return responseJson(0, 'no offer found');
        }
        return responseJson('1','success',$offer);
    }




    public function offersByRestaurant(Request $request)
    {
        $offers = Offer::where(function($query) use($request){
            if($request->has('restaurant_id'))
            {
                $query->where('restaurant_id',$request->restaurant_id);
            }
        })->paginate(10);

        if (!$offers) {
            return responseJson(0, 'no offers found');
        }
        return responseJson('1','success',$offers);
    }

///////////////////


}
