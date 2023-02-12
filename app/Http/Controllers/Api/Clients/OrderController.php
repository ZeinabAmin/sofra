<?php

namespace App\Http\Controllers\Api\Clients;

use App\Models\Meal;
use App\Models\Client;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class OrderController extends Controller
{
    public function newOrder(Request $request)

    {


        // 'items'             => 'required|array',
        // 'items.*'           => 'required|exists:items,id',
        // 'quantities'        => 'required|array',
        // 'notes'             => 'required|array',
        // 'address'           => 'required',


        //  dd(env('FIREBASE_API_ACCESS_KEY'));

        // 'restaurant_id', 'status', 'price', 'delivery_cost', 'total_price', 'commission', 'client_id', 'notes'

        $validator = validator()->make($request->all(), [

            'restaurant_id' => 'required|exists:restaurants,id',
            'meals.*.meal_id' => 'required|exists:meals,id',
            'meals.*.quantity' => 'required',
            'payment_method_id' => 'required|exists:payment_methods,id',
            //    'address' => 'required',

        ]);

        if ($validator->fails()) {
            $data = $validator->errors();
            return responseJson('0', $validator->errors()->first(), $data);
        }


        $restaurant = Restaurant::find($request->restaurant_id);


        //restaurant closed
        if ($restaurant->status == 'close') {
            return responseJson('0', '  عذرا المطعم غير متاح الوقت الحالي');
        }

        //client
        // set defaults
        $order = $request->user()->orders()->create([

            'restaurant_id' => $request->restaurant_id,
            'notes' => $request->notes,
            'status' => 'pending',
            'address' => $request->address,
            'payment_method_id' => $request->payment_method_id,
        ]);


        $cost = 0;
        $delivery_cost = $restaurant->delivery_cost;



        //meals
        foreach ($request->meals as $i) {
            //['meal_id'=>1,  'quantity'=>1,  'special_order'=>'no tomato']
            $meal = Meal::find($i['meal_id']);
            $readyMeal = [

                $i['meal_id'] => [

                    'quantity' => $i['quantity'],
                    'price' => $meal->price,
                    'special_order' => (isset($i['special_order'])) ? $i['special_order'] : '',

                ]

            ];

            $order->meals()->attach($readyMeal);

            $cost += ($meal->price * $i['quantity']);
        }


        //minimum_charge

        if ($cost >= $restaurant->minimum_charge) {

            $commission = settings()->commission * $cost / 100;

            $total = $cost + $delivery_cost;

            $net =  $total - $commission;

            $update = $order->update([

                'price' => $cost,
                'delivery_cost' => $delivery_cost,
                'total' => $total,
                'commission' => $commission,
                'net' => $net
            ]);

            //$request->user()->cart()->detach();

            /* notification */

            $restaurant->notifications()->create([

                'title' => 'لديك طلب جديد',
                'title_en' => 'You Have New Order ',
                'content' => '  لديك طلب جديد من العميل ' . $request->user()->name,
                'content_en' => 'You Have New Order By Client' . $request->user()->name,
                'order_id' => $order->id,

            ]);

            $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();




            //    $title =  ' لديك طلب جديد من العميل ';
            //    $body =  ' لديك طلب جديد من العميل ';
            //    $data =[

            //        'user_type' => 'restaurant',
            //        'action' => 'new-order',
            //        'order_id' => $order->id

            //    ];



            //    $send = notifyByFirebase($title,$body,$tokens,$data);

            // dd($send);


            /* notification */

            $data = [
                'order' => $order->fresh()->load('meals'),
            ];

            return responseJson('1', ' تم الطلب بنجاح', $data);
        } else {
            $order->meals()->delete();
            $order->delete();
            return responseJson('0', 'هذا الطلب يجب ان لا يكون اقل من' . $restaurant->minimum_charge . 'ريال');
        }
    }























    //  if ($request->has('items')) {
    //     $counter = 0;
    //     foreach ($request->items as $itemId) {
    //         $item = Item::find($itemId);
    //         $order->items()->attach([
    //         $itemId => [
    //             'quantity' => $request->quantities[$counter],
    //             'price'    => $item->price,
    //             'note'     => $request->notes[$counter],
    //         ]
    //        ]);
    //         $cost += ($item->price * $request->quantities[$counter]);
    //         $counter++;
    //     }
    // }






    //Notificatios

    // $notification = $restaurant->notifications()->create([
    //         'title' =>'لديك طلب جديد',
    //         'content' =>$request->user()->name .  'لديك طلب جديد من العميل ',
    //         'action' =>  'new-order',
    //         'order_id' => $order->id,
    // ]);
    // $tokens = $restaurant->tokens()->where('token', '!=' ,'')->pluck('token')->toArray();
    // //info("tokens result: " . json_encode($tokens));
    // if(count($tokens))
    // {
    //     public_path();
    //     $title = $notification->title;
    //     $content = $notification->content;
    //     $data =[
    //         'order_id' => $order->id,
    //         'user_type' => 'restaurant',
    //     ];
    //     $send = notifyByFirebase($title , $content , $tokens,$data);
    //     info("firebase result: " . $send);

    // }


    // /* notification */
    // $data = [
    //     'order' => $order->fresh()->load('items','restaurant.region','restaurant.categories','client') // $order->fresh()  ->load (lazy eager loading) ->with('items')
    // ];





















    public function declineOrder(Request $request)

    {
        $order = $request->user()->orders()->findOrFail($request->order_id);

        if ($order->status == 'delivered' || $order->status == 'accepted') {
            $order->Update([
                'status' => 'declined',
            ]);

            $restaurant = $order->restaurant;

            /* notification */


            $restaurant->notifications()->create([
                'title_ar'      => 'تم رفض توصيل طلبك من العميل',
                'title_en'   => 'Your order delivery is declined by client',
                'content_ar'    => 'تم رفض التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
                'content_en' => 'Delivery if order no. ' . $request->order_id . ' is declined by client',
                'order_id'   => $request->order_id,
            ]);



            $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();


            $title = ' تم رفض الطلب من العميل ';
            $body = ' تم رفض الطلب من العميل ';
            $data = [

                'user_type' => 'restaurant',
                'action' => 'declined-order',
                'order_id' => $order->id

            ];

            $send = notifyByFirebase($title, $body, $tokens, $data);

            /* notification */

            return responseJson('1', 'loaded', $order);
        } else {
            return responseJson('0', 'لا يمكنك رفض هذا الطلب');
        }
    }


    /////////////////////////////////////////////////////////////////

    public function acceptOrder(Request $request)

    {

        $order = $request->user()->orders()->findOrFail($request->order_id);

        if ($order->status == 'accepted') {

            $order->Update([
                'status' => 'delivered',
            ]);

            $restaurant = $order->restaurant;

            /* notification */
            $restaurant->notifications()->create([

                'title_ar'      => 'تم تأكيد توصيل طلبك من العميل',
                'title_en'   => 'Your order is delivered to client',
                'content_ar'    => 'تم تأكيد التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
                'content_en' => 'Order no. ' . $request->order_id . ' is delivered to client',
                'order_id'   => $request->order_id,

            ]);


            $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();


            $title = ' تم استلام الطلب من العميل ';
            $body = ' تم استلام الطلب من العميل ';
            $data = [

                'user_type' => 'restaurant',
                'action' => 'declined-order',
                'order_id' => $order->id

            ];

            $send = notifyByFirebase($title, $body, $tokens, $data);

            /* notification */



            return responseJson('1', 'loaded', $order);
        } else {
            return responseJson('0', 'هذا الطلب لم يتم الموافقه عليه');
        }
    }















    public function rates(Request $request)
    {
        $validation = validator()->make($request->all(), [

            'restaurant_id' => 'required|exists:restaurants,id',
            'comments' => 'required|max:100',
            'reviews' => 'required|in:1,2,3,4,5',

        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $rates = $request->user()->rates()->create($request->all());

        // if ($rates) {
        //     return responseJson(1, 'تم التقييم بنجاح', $rates);
        // } else {
        //     return responseJson(0, 'حدث خطأ ، برجاء المحاولة مرة أخري');
        // }
        return responseJson(1, 'تم التقييم بنجاح', $rates);
    }

  
}
