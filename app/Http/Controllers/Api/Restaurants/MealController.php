<?php

namespace App\Http\Controllers\Api\Restaurants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meal;


class MealController extends Controller
{
    public function newMeal(Request $request)
    {
        $validator = validator()->make(
            $request->all(),
            [
                'name' => 'required',
                'description' => 'required|max:100',
                'image' => 'required|image|mimes:jpeg,png,jpg',
                'processing_time' => 'required',
                'price' => 'required|numeric',
                'offer_price' => 'required|numeric',
            ]
        );


        if ($validator->fails()) {
            $data = $validator->errors();
            return responseJson(0, $validator->errors(), $data);
        }

        $meal = $request->user()->meals()->create($request->all());

        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/meals/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $image->move($destinationPath, $name); // uploading file to given path
            $meal->image = '/uploads/meals/' . $name;
            $meal->save();
        }

        if ($meal) {
            return responseJson(1, 'تم اضافة الوجبة ', $meal);
        } else {
            return responseJson(0, 'حدث خطأ يرجي المحاولة مرة أخري');
        }
    }


    ///////////////////////////



    public function updateMeal(Request $request)
    {
        $validation = validator()->make($request->all(), [

            'name' => 'required',
            'description' => 'required|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'processing_time' => 'required',
            'price' => 'required|numeric',
            'offer_price' => 'required|numeric',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }
        $meal = Meal::find($request->meal_id)->get();
      
        if (!$meal) {
            return responseJson(0, 'لا يمكن الحصول على البيانات');
        }
        $meal->update($request->all());
        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/meals/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $image->move($destinationPath, $name); // uploading file to given path
            $meal->update(['image' => '/uploads/meals/' . $name]);
        }

        // return responseJson(1, 'تم التعديل بنجاح', $meal);

        if ($meal) {
            return responseJson(1, 'تم التعديل بنجاح', $meal);
        } else {
            return responseJson(0, 'حدث خطأ برجاء المحاوله مره أخري');
        }
    }


    ////////////////////////

    public function deletemeal(Request $request)
    {
        $meal = Meal::find($request->meal_id)->delete();
        return responseJson(1,'تم الحذف بنجاح');
    }

}