<?php

namespace App\Http\Controllers\Api\Restaurants;

use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OfferController extends Controller
{
    public function newOffer(Request $request)
    {
        $validator = validator()->make($request->all(),
            [
                'name' => 'required',
                'description' => 'required|max:100',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                'discount_percentage' => 'required|numeric',
                'time_from' => 'required|date',
                'time_to' =>'required|date',
            ]);

        if ($validator->fails()) {
            $data = $validator->errors();
            return responseJson(0, $validator->errors(), $data);
        }

        $offer = $request->user()->offers()->create($request->all());

        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/images/offers/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $image->move($destinationPath, $name); // uploading file to given path
            $offer->image = '/images/offers/' . $name;
            $offer->save();
        }

        if ($offer) {
            return responseJson(1, 'تم اضافة العرض ', $offer);
        } else {
            return responseJson(0, 'حدث خطأ يرجي المحاولة مرة أخري');
        }

    }

    public function updateOffer(Request $request)
    {
        $validation = validator()->make($request->all(), [
                'name' => 'required',
                'description' => 'required|max:100',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                'discount_percentage' => 'required|numeric',
                'time_from' => 'required|date',
                'time_to' =>'required|date',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }
        $offer = Offer::find($request->offer_id)->get();

        $offer->update($request->all());
        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/offers/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $image->move($destinationPath, $name); // uploading file to given path
            $offer->update(['image' => '/uploads/offers/' . $name]);
        }

        // return responseJson(1,'تم التعديل بنجاح',$offer);

        if ($offer) {
            return responseJson(1, 'تم التعديل بنجاح', $offer);
        } else {
            return responseJson(0, 'حدث خطأ برجاء المحاوله مره أخري');
        }
    }


    public function deleteOffer(Request $request)
    {
        $offer = Offer::find($request->offer_id)->delete();
        return responseJson(1,'تم الحذف بنجاح');
    }


}
