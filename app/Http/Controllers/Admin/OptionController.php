<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OptionDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OptionCreateRequest;
use App\Models\Option;
use App\Models\OptionSet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param OptionDataTable $dataTable
     * @return View|JsonResponse
     */
    public function index(OptionDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.product.option.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() : View
    {
        return view('admin.product.option.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OptionCreateRequest  $request
     * @return RedirectResponse
     */
    public function store(OptionCreateRequest $request) : RedirectResponse
    {
        Option::create($request->all());

        toastr()->success('Created Successfully');

        return to_route('admin.option.index');
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
        $option = Option::findOrFail($id);

        return view('admin.product.option.edit', compact('option'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OptionCreateRequest  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(OptionCreateRequest $request, $id) : RedirectResponse
    {
        $option = Option::findOrFail($id);
        $option->update($request->all());

        toastr()->success('Updated Successfully');

        return to_route('admin.option.index');
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
            Option::findOrFail($id)->delete();
            OptionSet::where('option_id', $id)->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully']);
        }catch(\Exception $e){
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
