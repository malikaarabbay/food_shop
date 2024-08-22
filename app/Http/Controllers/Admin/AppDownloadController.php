<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AppDownloadCreateRequest;
use App\Models\AppDownload;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppDownloadController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index() : View
    {
        $appSection = AppDownload::first();

        return view('admin.app_download.index', compact('appSection'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AppDownloadCreateRequest $request
     * @return RedirectResponse
     */
    function store(AppDownloadCreateRequest $request): RedirectResponse
    {
        $imagePath = $this->uploadImage($request, 'image', $request->old_image);
        $backgroundPath = $this->uploadImage($request, 'background', $request->old_background);

        AppDownload::updateOrCreate(
            ['id' => 1],
            [
                'image' => !empty($imagePath) ?  $imagePath : $request->old_image,
                'background' => !empty($backgroundPath) ?  $backgroundPath : $request->old_background,
                'title' => $request->title,
                'short_description' => $request->short_description,
                'play_store_link' => $request->play_store_link,
                'apple_store_link' => $request->apple_store_link
            ]
        );

        toastr()->success('Updated Successfully!');

        return to_route('admin.app-download.index');
    }
}
