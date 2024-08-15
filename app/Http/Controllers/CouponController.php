<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Coupon::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'available_at' => 'required',
        ]);

        $coupon = new Coupon();
        $coupon->company_name = $request->company_name;
        $coupon->quantity = $request->quantity;

        $codes = [];
        for ($i = 0; $i < $request->quantity; $i++) {
            do {
                $code = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5);
            } while (Coupon::whereRaw("FIND_IN_SET('$code', code)")->exists() || in_array($code, $codes));
            $codes[] = $code;
        }
        $coupon->code = implode(',', $codes);
        
        $coupon->price = $request->price;
        $coupon->available_at = $request->available_at;
        $coupon->used = '';
        $coupon->status = true;
        $coupon->is_percentage = $request->is_percentage ?? 0;
        $coupon->is_unlimited = $request->is_unlimited ?? 0;

        $coupon->save();

        return response()->json($coupon);
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
        $coupon = Coupon::find($id);

        $status = intval($request->status);

        $coupon->update([
            'price' => $request->price,
            'available_at' => $request->available_at,
            'status' => $status,
        ]);

        return $coupon;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Coupon::destroy($id);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Coupon::find($id);
    }


    public function checkCoupon(Request $request) {
        $coupon = Coupon::where('status', true)
            ->whereRaw("FIND_IN_SET('$request->coupon_code', code)")
            ->first();
    
        if (!$coupon) {
            return response()->json(['error' => "Coupon is not valid"]);
        }
    
        if (in_array($request->coupon_code, explode(',', $coupon->used))) {
            return response()->json(['error' => "Coupon code has already been used"]);
        }
    
        $available_at = explode(',', $coupon->available_at);

        // Check if the word that you send is in the availableWords array
        if (!in_array(trim($request->site), $available_at)) {
            return response()->json(['error' => "Coupon Unavailable"]);
        }

        return $coupon;
    }
}
