<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfilePasswordUpdateRequest;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Traits\FileUploadTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    function index() : View
    {
        return view('admin.profile.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProfileUpdateRequest  $request
     * @return RedirectResponse
     */
    function updateProfile(ProfileUpdateRequest $request) : RedirectResponse
    {
        $user = Auth::user();
        $imagePath = $this->uploadImage($request, 'image');
        $user->image = isset($imagePath) ? $imagePath : $user->image;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        toastr('Updated successfully!', 'success');

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProfilePasswordUpdateRequest  $request
     * @return RedirectResponse
     */
    function updatePassword(ProfilePasswordUpdateRequest $request) : RedirectResponse
    {
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        toastr('Password updated successfully!', 'success');

        return redirect()->back();
    }
}
