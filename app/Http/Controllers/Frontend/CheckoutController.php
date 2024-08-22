<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    function index() : View
    {
        $addresses = Address::byAuthUser()->get();
        $deliveryAreas = Delivery::active()->get();

        return view('frontend.pages.checkout', compact('addresses', 'deliveryAreas'));
    }

    /**
     * Calculate delivery charge
     *
     * @param  string  $id
     * @return Response
     */
    function CalculateDeliveryCharge(string $id)
    {
        try {
            $address = Address::findOrFail($id);
            $deliveryFee = $address->delivery?->delivery_fee;
            $grandTotal = grandCartTotal($deliveryFee);
            return response(['delivery_fee' => $deliveryFee, 'grand_total' => $grandTotal]);
        }catch(\Exception $e) {
            logger($e);
            return response(['message' => 'Something Went Wrong!'], 422);
        }
    }

    /**
     * Set delivery area and redirect to payment page
     *
     * @param  Request  $request
     * @return Response
     */
    function checkoutRedirect(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer']
        ]);

        $address = Address::with('delivery')->findOrFail($request->id);

        $selectedAddress = $address->address.', Aria: '. $address->delivery?->area_name;

        session()->put('address', $selectedAddress);
        session()->put('delivery_fee', $address->delivery->delivery_fee);
        session()->put('address_id', $address->id);

        return response(['redirect_url' => route('payment.index')]);
    }
}
