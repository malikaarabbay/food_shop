<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductRatingDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductRating;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ProductRatingDataTable $dataTable
     * @return View|JsonResponse
     */
    function index(ProductRatingDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.product.review.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    function updateStatus(Request $request) : Response
    {
        $review = ProductRating::findOrFail($request->id);
        $review->status = $request->status;
        $review->save();

        return response(['status' => 'success', 'message' => 'updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return Response
     */
    function destroy(string $id) : Response
    {
        try {
            ProductRating::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
