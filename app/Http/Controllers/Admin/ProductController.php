<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCreateRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Str;

class ProductController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @param ProductDataTable $dataTable
     * @return View|JsonResponse
     */
    public function index(ProductDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() : View
    {
        $categories = Category::all();
        $options = Option::all();
        return view('admin.product.create', compact('categories', 'options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductCreateRequest  $request
     * @return RedirectResponse
     */
    public function store(ProductCreateRequest $request)  : RedirectResponse
    {
        /** Handle image upload */
        $imagePath = $this->uploadImage($request, 'image');

        $product = Product::create(array_merge($request->all(),
            [
                'image' => $imagePath,
                'offer_price' => $request->offer_price ?? 0,
                'slug' => generateUniqueSlug('Product', $request->title)
            ]));

        $product->options()->attach($request->options);

        toastr()->success('Created Successfully');

        return to_route('admin.product.index');
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
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $options = Option::all();

        return view('admin.product.edit', compact('product', 'categories', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductUpdateRequest  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(ProductUpdateRequest $request, $id) : RedirectResponse
    {
        $product = Product::findOrFail($id);

        /** Handle image file */
        $imagePath = $this->uploadImage($request, 'image');

        $product->update(array_merge($request->all(),
            [
                'image' => !empty($imagePath) ? $imagePath : $product->image,
                'offer_price' => $request->offer_price ?? 0
            ]));

        $product->options()->sync($request->options);

        toastr()->success('Update Successfully');

        return to_route('admin.product.index');
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
            $product = Product::findOrFail($id);
            $this->removeImage($product->image);
            $product->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        }catch(\Exception $e){
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
