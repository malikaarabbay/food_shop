<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\WhyChooseUsDataTable;
use App\Http\Controllers\Controller;
use App\Models\SectionTitle;
use App\Models\WhyChooseUs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Http\Requests\Admin\WhyChooseUsCreateRequest;

class WhyChooseUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param WhyChooseUsDataTable $dataTable
     * @return View|JsonResponse
     */
    public function index(WhyChooseUsDataTable $dataTable) : View|JsonResponse
    {
        $keys = ['why_choose_top_title', 'why_choose_main_title', 'why_choose_sub_title'];
        $titles = SectionTitle::whereIn('key', $keys)->pluck('value', 'key');

        return $dataTable->render('admin.why_choose_us.index', compact('titles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() : View
    {
        return view('admin.why_choose_us.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  WhyChooseUsCreateRequest  $request
     * @return RedirectResponse
     */
    public function store(WhyChooseUsCreateRequest $request) : RedirectResponse
    {
        WhyChooseUs::create($request->validated());

        toastr()->success('Created Successfully');

        return to_route('admin.why-choose-us.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return View
     */
    public function edit(string $id) : View
    {
        $whyChooseUs = WhyChooseUs::findOrFail($id);
        return view('admin.why_choose_us.edit', compact('whyChooseUs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  WhyChooseUsCreateRequest  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(WhyChooseUsCreateRequest $request, string $id) : RedirectResponse
    {
        $whyChooseUs = WhyChooseUs::findOrFail($id);
        $whyChooseUs->update($request->validated());

        toastr()->success('Created Successfully');

        return to_route('admin.why-choose-us.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function updateTitle(Request $request) : RedirectResponse
    {
        $request->validate([
            'why_choose_top_title' => ['max:100'],
            'why_choose_main_title' => ['max:200'],
            'why_choose_sub_title' => ['max:500'],
        ]);

        SectionTitle::updateOrCreate(
            ['key' => 'why_choose_top_title'],
            ['value' => $request->why_choose_top_title],
        );

        SectionTitle::updateOrCreate(
            ['key' => 'why_choose_main_title'],
            ['value' => $request->why_choose_main_title],
        );

        SectionTitle::updateOrCreate(
            ['key' => 'why_choose_sub_title'],
            ['value' => $request->why_choose_sub_title],
        );

        toastr()->success('Updated Successfully');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return Response
     */
    public function destroy(string $id)
    {
        try{
            $whyChooseUs = WhyChooseUs::findOrFail($id);
            $whyChooseUs->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully']);
        }catch(\Exception $e){
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
