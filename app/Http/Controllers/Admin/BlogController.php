<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BlogCommentDataTable;
use App\DataTables\BlogDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogCreateRequest;
use App\Http\Requests\Admin\BlogUpdateRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Category;
use App\Traits\FileUploadTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Str;

class BlogController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @param BlogDataTable $dataTable
     * @return View|JsonResponse
     */
    public function index(BlogDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() : View
    {
        $categories = BlogCategory::active()->get();

        return view('admin.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BlogCreateRequest  $request
     * @return RedirectResponse
     */
    public function store(BlogCreateRequest $request) : RedirectResponse
    {
        $imagePath = $this->uploadImage($request, 'image');

        Blog::create(array_merge($request->all(),
        [
            'user_id' => auth()->user()->id,
            'image' => $imagePath,
            'slug' => Str::slug($request->title),
        ]));

        toastr()->success('Created Successfully');

        return to_route('admin.blog.index');
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
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::active()->get();

        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BlogUpdateRequest  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(BlogUpdateRequest $request, $id) : RedirectResponse
    {
        $imagePath = $this->uploadImage($request, 'image', $request->old_image);

        $blog = Blog::findOrFail($id);
        $blog->update(array_merge($request->all(),
        [
            'user_id' => auth()->user()->id,
            'image' => !empty($imagePath) ? $imagePath : $request->old_image,
            'slug' => Str::slug($request->title),
        ]));

        toastr()->success('Created Successfully');

        return to_route('admin.blog.index');
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
            $blog = Blog::findOrFail($id);
            $this->removeImage($blog->image);
            $blog->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param BlogCommentDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    function blogComment(BlogCommentDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.blog.blog_comment.index');
    }

    /**
     * Update a status comment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function commentStatusUpdate(string $id) : RedirectResponse
    {
        $comment = BlogComment::find($id);
        $comment->status = !$comment->status;
        $comment->save();

        toastr()->success('Updated Successfully');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function commentDestroy(string $id) : Response
    {
        try {
            BlogComment::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
