<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DailyOfferDataTable;
use App\Http\Controllers\Controller;
use App\Models\DailyOffer;
use App\Models\Product;
use App\Models\SectionTitle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class DailyOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param DailyOfferDataTable $dataTable
     * @return View|JsonResponse
     */
    public function index(DailyOfferDataTable $dataTable) : View|JsonResponse
    {
        $keys = ['daily_offer_top_title', 'daily_offer_main_title', 'daily_offer_sub_title'];
        $titles = SectionTitle::whereIn('key', $keys)->pluck('value','key');

        return $dataTable->render('admin.daily_offer.index', compact('titles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() : View
    {
        return view('admin.daily_offer.create');
    }

    /**
     *  Search product for select input.
     *
     * @param  Request  $request
     * @return Response
     */
    public function searchProduct(Request $request): Response
    {
        $product = Product::select('id', 'title', 'image')->where('title', 'LIKE', '%' . $request->search . '%')->get();

        return response($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'integer'],
            'status' => ['required', 'boolean']
        ]);

        DailyOffer::create($request->all());

        toastr()->success('Created Successfully');

        return to_route('admin.daily-offer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit($id) : View
    {
        $dailyOffer = DailyOffer::with('product')->findOrFail($id);

        return view('admin.daily_offer.index', compact('dailyOffer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id) : RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'integer'],
            'status' => ['required', 'boolean']
        ]);

        $offer = DailyOffer::findOrFail($id);
        $offer->update($request->all());

        toastr()->success('Updated Successfully');

        return to_route('admin.daily-offer.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function updateTitle(Request $request)
    {
        $validatedData = $request->validate([
            'daily_offer_top_title' => ['max:100'],
            'daily_offer_main_title' => ['max:200'],
            'daily_offer_sub_title' => ['max:500']
        ]);

        foreach ($validatedData as $key => $value) {
            SectionTitle::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        toastr()->success('Updated Successfully!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            DailyOffer::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
