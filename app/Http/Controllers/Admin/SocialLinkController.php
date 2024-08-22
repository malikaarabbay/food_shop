<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SocialLinkDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SocialLinkCreateRequest;
use App\Models\SocialLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;

class SocialLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SocialLinkDataTable $dataTable
     * @return View|JsonResponse
     */
    public function index(SocialLinkDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.social_link.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() : View
    {
        return view('admin.social_link.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SocialLinkCreateRequest  $request
     * @return RedirectResponse
     */
    public function store(SocialLinkCreateRequest $request) : RedirectResponse
    {
        SocialLink::create($request->all());

        toastr()->success('Created Successfully');

        return redirect()->route('admin.social-link.index');
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
        $socialLink = SocialLink::findOrFail($id);

        return view('admin.social_link.edit', compact('socialLink'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SocialLinkCreateRequest  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(SocialLinkCreateRequest $request, $id) : RedirectResponse
    {
        $socialLink = SocialLink::findOrFail($id);
        $socialLink->update();

        toastr()->success('Update Successfully');

        return redirect()->route('admin.social-link.index');
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
            SocialLink::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
