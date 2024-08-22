<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryCreateRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CategoryDataTable $dataTable
     * @return View|JsonResponse
     */
    public function index(CategoryDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.product.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() : View
    {
        return view('admin.product.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryCreateRequest  $request
     * @return RedirectResponse
     */
    public function store(CategoryCreateRequest $request) : RedirectResponse
    {
        Category::create(array_merge($request->all(), ['slug' => Str::slug($request->title)]));

        toastr()->success('Created Successfully');

        return to_route('admin.category.index');
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
        $category = Category::findOrFail($id);

        return view('admin.product.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryUpdateRequest  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(CategoryUpdateRequest $request, $id) : RedirectResponse
    {
        $category = Category::findOrFail($id);
        $category->update(array_merge($request->all(), ['slug' => Str::slug($request->title)]));

        toastr()->success('Updated Successfully');

        return to_route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(string $id)
    {
        try{
            Category::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully']);
        }catch(\Exception $e){
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
