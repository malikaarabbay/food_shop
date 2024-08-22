<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AddressCreateRequest;
use App\Models\Address;
use App\Models\Chat;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\ProductRating;
use App\Models\Reservation;
use App\Models\Wishlist;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    function index() : View
    {
        $deliveryAreas = Delivery::active()->get();
        $userAddresses = auth()->user()->getAddressesByUser();
        $orders = auth()->user()->getOrdersByUser();
        $totalOrders = auth()->user()->countOrdersByUser();
        $totalCompleteOrders = Order::authUser()->delivered()->count();
        $totalCancelOrders = Order::authUser()->declined()->count();
        $unseenMessages = Chat::where(['sender_id' => Chat::ADMIN, 'receiver_id' => auth()->user()->id, 'seen' => 0])->count();
        $reservations = Reservation::authUser()->get();
        $wishlist = Wishlist::authUser()->latest()->get();
        $reviews = ProductRating::authUser()->get();

        return view('frontend.dashboard.index', compact(
            'deliveryAreas',
            'userAddresses',
            'orders',
            'totalOrders',
            'totalCompleteOrders',
            'totalCancelOrders',
            'unseenMessages',
            'reservations',
            'wishlist',
            'reviews'
        ));
    }

    /**
     * Store a newly created address in storage.
     *
     * @param  AddressCreateRequest  $request
     * @return RedirectResponse
     */
    function createAddress(AddressCreateRequest $request) : RedirectResponse
    {
        Address::create(array_merge($request->all(), ['user_id' => auth()->user()->id]));

        toastr()->success('Created Successfully');

        return redirect()->back();
    }

    /**
     * Update a newly created address in storage.
     *
     * @param  string  $id
     * @param  AddressCreateRequest  $request
     * @return RedirectResponse
     */
    function updateAddress(string $id, AddressCreateRequest $request) : RedirectResponse
    {
        $address = Address::findOrFail($id);
        $address->update(array_merge($request->all(), ['user_id' => auth()->user()->id]));

        toastr()->success('Updated Successfully');

        return to_route('admin.dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return Response
     */
    function destroyAddress(string $id)
    {
        $address = Address::findOrFail($id);
        if($address && $address->user_id === auth()->user()->id){
            $address->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully']);
        }
        return response(['status' => 'error', 'message' => 'something went wrong!']);
    }
}
