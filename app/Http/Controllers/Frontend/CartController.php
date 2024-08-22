<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\OptionSet;
use App\Models\Product;
use Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Show shopping cart page
     *
     * @return View
     */
    function index() : View
    {
        return view('frontend.pages.cart_view');
    }

    /**
     * Add product in to cart
     *
     * @param Request $request
     * @return Response
     */
    function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        if($product->quantity < $request->quantity){
            throw ValidationException::withMessages(['Quantity is not available!']);
        }

        try {
            $options = [
                'product_options' => [],
                'product_info' => [
                    'image' => $product->image,
                    'slug' => $product->slug
                ]
            ];

            if ($request->product_option) {
                $productOptions = OptionSet::whereIn('id', $request->product_option)->get();

                foreach ($productOptions as $option) {
                    $options['product_options'][] = [
                        'id' => $option->id,
                        'name' => $option->title,
                        'price' => $option->price
                    ];
                }
            }

            Cart::add([
                'id' => $product->id,
                'name' => $product->title,
                'qty' => $request->quantity,
                'price' => $product->offer_price > 0 ? $product->offer_price : $product->price,
                'weight' => 0,
                'options' => $options
            ]);

            return response(['status' => 'success', 'message' => 'Product added into cart!'], 200);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => 'Something went wrong!'], 500);
        }
    }

    /**
     * Get cart products via ajax
     */
    function getCartProduct()
    {
        return view('frontend.layouts.ajax-files.sidebar_cart_item')->render();
    }

    /**
     * Remove cart products via ajax
     *
     * @param int $rowId
     * @return Response
     */
    function cartProductRemove($rowId)
    {
        try {
            Cart::remove($rowId);
            return response([
                'status' => 'success',
                'message' => 'Item has been removed!',
                'cart_total' => cartTotal(),
                'grand_cart_total' => grandCartTotal()
            ], 200);
        }catch(\Exception $e){
            return response(['status' => 'error', 'message' => 'Sorry something went wrong!'], 500);
        }
    }

    /**
     * Update quantity products via ajax
     *
     * @param Request $request
     * @return Response
     */
    function cartQtyUpdate(Request $request) : Response
    {
        $cartItem = Cart::get($request->rowId);
        $product = Product::findOrFail($cartItem->id);

        if($product->quantity < $request->qty){
            return response(['status' => 'error', 'message' => 'Quantity is not available!', 'qty' => $cartItem->qty]);
        }

        try{
            $cart = Cart::update($request->rowId, $request->qty);
            return response([
                'status' => 'success',
                'product_total' => productTotal($request->rowId),
                'qty' => $cart->qty,
                'cart_total' => cartTotal(),
                'grand_cart_total' => grandCartTotal()
            ], 200);
        }catch(\Exception $e){
            logger($e);
            return response(['status' => 'error', 'message' => 'Something went wrong please reload the page.'], 500);
        }
    }

    /**
     * Cart destroy
     *
     * @return RedirectResponse
     */
    function cartDestroy() : RedirectResponse
    {
        Cart::destroy();
        session()->forget('coupon');

        return redirect()->back();
    }
}
