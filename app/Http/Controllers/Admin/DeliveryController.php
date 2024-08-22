<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DeliveryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryCreateRequest;
use App\Models\Delivery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param DeliveryDataTable $dataTable
     * @return View|JsonResponse
     */
    public function index(DeliveryDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.delivery.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() : View
    {
        return view('admin.delivery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DeliveryCreateRequest  $request
     * @return RedirectResponse
     */
    public function store(DeliveryCreateRequest $request) : RedirectResponse
    {
        Delivery::create($request->all());

        toastr()->success('Create Successfully');

        return to_route('admin.delivery.index');
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
        $delivery = Delivery::findOrFail($id);

        return view('admin.delivery.edit', compact('delivery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DeliveryCreateRequest  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(DeliveryCreateRequest $request, $id) : RedirectResponse
    {
        $delivery = Delivery::findOrFail($id);
        $delivery->update($request->all());

        toastr()->success('Update Successfully');

        return to_route('admin.delivery.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        try{
            Delivery::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully']);
        }catch(\Exception $e){
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
