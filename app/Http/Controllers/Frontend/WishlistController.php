<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Auth;

class WishlistController extends Controller
{
    /**
     * Add a product to wishlist
     *
     * @param string $productId
     * @return Response
     */
    function store(string $productId) : Response
    {
        $productAlreadyExist = Wishlist::where(['user_id' => auth()->user()->id, 'product_id' => $productId])->exists();

        if($productAlreadyExist){
            throw ValidationException::withMessages(['Product is already add to wishlist ']);
        }
        if(!Auth::check()){
            throw ValidationException::withMessages(['Please login for add product in wishlist']);
        }

        Wishlist::create([
            'user_id' => auth()->user()->id,
            'product_id' => $productId
        ]);

        return response(['status' => 'success', 'message' => 'Product added to wishlist!']);
    }
}
