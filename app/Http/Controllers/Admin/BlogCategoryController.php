<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BlogCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param BlogCategoryDataTable $dataTable
     * @return View|JsonResponse
     */
    public function index(BlogCategoryDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.blog.blog_category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() : View
    {
        return view('admin.blog.blog_category.create');
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
            'title' => ['required', 'max:255', 'unique:blog_categories,title'],
            'status' => ['required', 'boolean']
        ]);

        BlogCategory::create(array_merge($request->all(), ['slug' => Str::slug($request->title)]));

        toastr()->success('Created Successfully!');

        return to_route('admin.blog-category.index');
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
        $category = BlogCategory::findOrFail($id);

        return view('admin.blog.blog_category.edit', compact('category'));
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
            'title' => ['required', 'max:255', 'unique:blog_categories,title,'.$id],
            'status' => ['required', 'boolean']
        ]);

        $category = BlogCategory::findOrFail($id);
        $category->update(array_merge($request->all(), ['slug' => Str::slug($request->title)]));

        toastr()->success('Update Successfully!');

        return to_route('admin.blog-category.index');
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
            BlogCategory::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
