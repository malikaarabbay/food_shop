<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProfilePasswordUpdateRequest;
use App\Http\Requests\Frontend\ProfileUpdateRequest;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    use FileUploadTrait;

    /**
     * Update profile data
     *
     * @param ProfileUpdateRequest $request
     * @return RedirectResponse
     */
    function updateProfile(ProfileUpdateRequest $request) : RedirectResponse
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        toastr()->success('Profile Updated Successfully');

        return redirect()->back();
    }

    /**
     * Update a password
     *
     * @param ProfilePasswordUpdateRequest $request
     * @return RedirectResponse
     */
    function updatePassword(ProfilePasswordUpdateRequest $request) : RedirectResponse
    {
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        toastr()->success('Password Updated Successfully');

        return redirect()->back();
    }

    /**
     * Update a avatar
     *
     * @param Request $request
     * @return Response
     */
    function updateAvatar(Request $request)
    {
        /** handle image file */
        $imagePath = $this->uploadImage($request, 'image');

        $user = Auth::user();
        $user->image = $imagePath;
        $user->save();

        return response(['status' => 'success', 'message' => 'Avatar Updated Successfully']);
    }
}
