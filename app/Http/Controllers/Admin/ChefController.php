<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ChefDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChefCreateRequest;
use App\Http\Requests\Admin\ChefUpdateRequest;
use App\Models\Chef;
use App\Models\SectionTitle;
use App\Traits\FileUploadTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;

class ChefController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @param ChefDataTable $dataTable
     * @return View|JsonResponse
     */
    public function index(ChefDataTable $dataTable) : View|JsonResponse
    {
        $keys = ['chef_top_title', 'chef_main_title', 'chef_sub_title'];
        $titles = SectionTitle::whereIn('key', $keys)->pluck('value','key');

        return $dataTable->render('admin.chef.index', compact('titles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() : View
    {
        return view('admin.chef.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ChefCreateRequest  $request
     * @return RedirectResponse
     */
    public function store(ChefCreateRequest $request) : RedirectResponse
    {
        $imagePath = $this->uploadImage($request, 'image');

        Chef::create(array_merge($request->all(), ['image' => $imagePath]));

        toastr()->success('Created Successfully!');

        return to_route('admin.chefs.index');
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
        $chef = Chef::findOrFail($id);

        return view('admin.chef.edit', compact('chef'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ChefUpdateRequest  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(ChefUpdateRequest $request, $id) : RedirectResponse
    {
        $imagePath = $this->uploadImage($request, 'image', $request->old_image);

        $chef = Chef::findOrFail($id);
        $chef->update(array_merge($request->all(), ['image' => !empty($imagePath) ? $imagePath : $request->old_image]));

        toastr()->success('Update Successfully!');

        return to_route('admin.chefs.index');
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
            'chef_top_title' => ['max:100'],
            'chef_main_title' => ['max:200'],
            'chef_sub_title' => ['max:500']
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
        try{
            Chef::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully']);
        }catch(\Exception $e){
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
