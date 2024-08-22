<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderCreateRequest;
use App\Http\Requests\Admin\SliderUpdateRequest;
use App\Models\Slider;
use App\Traits\FileUploadTrait;
//use Flasher\Laravel\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;

class SliderController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @param SliderDataTable $dataTable
     * @return View|JsonResponse
     */
    public function index(SliderDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SliderCreateRequest  $request
     * @return RedirectResponse
     */
    public function store(SliderCreateRequest $request) : RedirectResponse
    {
        /** Handle image upload */
        $imagePath = $this->uploadImage($request, 'image');

        Slider::create(array_merge($request->all(), ['image' => $imagePath]));

        toastr()->success('Created Successfully');

        return to_route('admin.slider.index');
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
    public function edit($id) :View
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SliderUpdateRequest  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(SliderUpdateRequest $request, $id) : RedirectResponse
    {
        $slider = Slider::findOrFail($id);

        /** Handle Image Upload */
        $imagePath = $this->uploadImage($request, 'image');
        $slider->update(array_merge($request->all(), ['image' => !empty($imagePath) ? $imagePath : $slider->image]));

        toastr()->success('Updated Successfully');

        return to_route('admin.slider.index');
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
            $slider = Slider::findOrFail($id);
            $this->removeImage($slider->image);
            $slider->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
