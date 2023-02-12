<?php

namespace App\Http\Controllers\Api\Clients;

use App\Models\Token;
use App\Models\Client;
use App\Mail\ResetPassword;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
// use GuzzleHttp\Psr7\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name'      => 'required',
            'phone'     => 'required|unique:clients,phone|digits:11',
            'region_id' => 'required|exists:regions,id',
            'email'     => 'required|email|unique:clients,email',
            'password'  => 'required|confirmed|min:6|max:15',

        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }


        $request->merge(['password' => bcrypt($request->password)]);
        $client = Client::create($request->all());
        $client->api_token = Str::random(60);
        $client->save();

        return responseJson(1, 'تم الاضافة بنجاح', [
            'api_token' => $client->api_token,
            'client' => $client

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
        $client = Client::where('email', $request->email)->first();
        if ($client) {
            if (Hash::check($request->password, $client->password)) {
                return responseJson(1, 'تم تسجيل الدخول', [
                    'api_token' => $client->api_token,
                    'client' => $client
                ]);
            } else {
                return responseJson(0, 'بيانات الدخول غير صحيحة');
            }
        } else {
            return responseJson(0, 'بيانات الدخول غير صحيحة');
        }
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

        $user = Client::where('email', $request->email)->first();

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

        $user = Client::where('pin_code', $request->pin_code)->where('pin_code', '!=', 0)->where
        ('email', $request->email)->first();
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




    public function profile(Request $request)
    {
        $validation = validator()->make($request->all(), [

            'password' => 'confirmed',
            'email' => Rule::unique('clients')->ignore($request->user()->id),
            'phone' => Rule::unique('clients')->ignore($request->user()->id),

        ]);

        if ($validation->fails()) {
            $data = $validation->errors;
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $loginUser = $request->user();
        $loginUser->update($request->all());

        if ($request->has('password')) {
            $loginUser->password = bcrypt($request->password);
        }

        $loginUser->save();
        return responseJson(1, 'تم تحديث البيانات', $loginUser);
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


    public function notifications(Request $request)
    {
        $notiOfUser = $request->user()->notifications()->latest()->paginate(20);
        return responseJson(1, 'Loaded...', $notiOfUser);
    }
}




