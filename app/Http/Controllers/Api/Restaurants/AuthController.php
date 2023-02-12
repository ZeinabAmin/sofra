<?php

namespace App\Http\Controllers\Api\Restaurants;

use App\Models\Token;
use Nette\Utils\Image;
use App\Models\Restaurant;
use App\Mail\ResetPassword;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name'            => 'required',
            'email'           => 'required|email|unique:restaurants,email',
            'password'  => 'required|confirmed|min:6|max:15',
            'phone'           => 'required|unique:restaurants,phone|digits:11',
            'delivery_fee'   => 'required|numeric',
            'minimum_order' => 'required|numeric',
            'whatsapp'        => 'required|digits:11',
            'informations'    => 'required',
            'region_id'       => 'required|exists:regions,id',
            'image'           => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }


        $request->merge(['password' => bcrypt($request->password)]);
        $restaurant = Restaurant::create($request->all());
        $restaurant->api_token = Str::random(60);
        $restaurant->save();


        // if ($request->hasFile('image')) {
        //     $image =$request->file('image');
        //     $filename = time() . '.' . $image->getClientOriginalExtension();
        //     Image::make($image)->resize(300, 300)->save( public_path('uploads/images/' . $filename ) );
        //     $restaurant->image = $filename;
        //     $restaurant->save();

        // }

        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/images/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $image->move($destinationPath, $name); // uploading file to given path
            $restaurant->update(['image' => 'uploads/images/' . $name]);
            $restaurant->save();
        }


        return responseJson(1, 'تم التسجيل بنجاح', [

            'api_token' =>  $restaurant->api_token,
            'data'      => $restaurant
        ]);
    }


    public function login(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'email' => 'required',
            'password' => 'required',

        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        //return auth()->guard('api')->validate($request->all());
        $restaurant = Restaurant::where('email', $request->email)->first();
        if ($restaurant) {
            if (Hash::check($request->password, $restaurant->password)) {
                return responseJson(1, 'تم تسجيل الدخول', [
                    'api_token' => $restaurant->api_token,
                    'client' => $restaurant
                ]);
            } else {
                return responseJson(0, 'بيانات الدخول غير صحيحة');
            }
        } else {
            return responseJson(0, 'بيانات الدخول غير صحيحة');
        }
    }






    public function profile(Request $request)
    {
        $validation = validator()->make($request->all(), [

            'password' => 'confirmed|min:6|max:15',
            'email' => Rule::unique('restaurants')->ignore($request->user()->id),
            'phone' => Rule::unique('restaurants')->ignore($request->user()->id),
            'image'   => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors;
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $loginRestaurant = $request->user();
        $loginRestaurant->update($request->all());

        if ($request->has('password')) {
            $loginRestaurant->password = bcrypt($request->password);
        }

        $loginRestaurant->save();

        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/images/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $image->move($destinationPath, $name); // uploading file to given path
            $restaurant->update(['image' => 'uploads/images/' . $name]);
            $restaurant->save();
        }

        return responseJson(1, 'تم تحديث البيانات', $loginRestaurant);
    }




    public function resetPassword(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'email' => 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors;
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $user = Restaurant::where('email', $request->email)->first();

        if ($user) {
            $code = rand(1111, 9999);
            $user->pin_code = $code;
            //$update=$user->update(['pin_code'=>$code]);
            // if ($update) {
            if ($user->save()) {
                //  send email
                Mail::to($user->email)
                    // ->cc($moreUsers)
                    ->bcc("zeinabamin00@gmail.com")
                    ->send(new ResetPassword($code));
                return responseJson(1, 'برجاء فحص بريدك الالكتروني', [
                    'pin_code_for_test' => $code,
                    'mail_fails' => Mail::failures(),
                    'email' => $user->email
                ]);
            } else {
                return responseJson(0, 'حدث خطأ ، حاول مرة أخرى');
            }
        } else {
            return responseJson(0, 'لا يوجد اي حساب مرتبط بهذا البريد الالكتروني');
        }
    }


    public function newPassword(Request $request)
    {
        $validation = validator()->make($request->all(), [

            'pin_code' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $user = Restaurant::where('pin_code', $request->pin_code)->where('pin_code', '!=', 0)->where('email', $request->email)->first();
        if ($user) {

            // $update = $user->update(['password' => bcrypt($request->password), 'pin_code' => null]);
            // if ($update) {
            $user->password = bcrypt($request->password);
            $user->pin_code = null;

            if ($user->save()) {
                return responseJson(1, 'تم تغيير كلمة المرور بنجاح');
            } else {
                return responseJson(0, 'حدث خطأ حاول مرة أخرى');
            }
        } else {
            return responseJson(0, 'هذا الكود غير صالح');
        }
    }


    public function registerToken(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'token' => 'required',
            'platform' => 'required|in:android,ios'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }
        Token::where('token', $request->token)->delete();
        // Token::create([
        //   'token' => '',
        //   'type' => '',
        //   'client_id' =>  $request->user()->id
        // ]);
        $request->user()->tokens()->create($request->all());
        return responseJson(1, 'تم التسجيل بنجاح');
    }


    public function removeToken(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'token' => 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }
        Token::where('token', $request->token)->delete();
        return responseJson(1, 'تم الحذف بنجاح');
    }
}
