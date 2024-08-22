<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrivacyPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    function index(): View
    {
        $privacyPolicy = PrivacyPolicy::first();

        return view('admin.privacy_policy.index', compact('privacyPolicy'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    function update(Request $request): RedirectResponse
    {
        $request->validate([
            'description' => ['required']
        ]);

        PrivacyPolicy::updateOrCreate(
            ['id' => 1],
            [
                'description' => $request->description
            ]
        );
        toastr()->success('Updated Successfully');

        return redirect()->back();
    }
}
