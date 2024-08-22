<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\FeedbackDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FeedbackCreateRequest;
use App\Http\Requests\Admin\FeedbackUpdateRequest;
use App\Models\Feedback;
use App\Models\SectionTitle;
use App\Traits\FileUploadTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;

class FeedbackController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @param FeedbackDataTable $dataTable
     * @return View|JsonResponse
     */
    public function index(FeedbackDataTable $dataTable) : View|JsonResponse
    {
        $keys = ['feedback_top_title', 'feedback_main_title', 'feedback_sub_title'];
        $titles = SectionTitle::whereIn('key', $keys)->pluck('value','key');

        return $dataTable->render('admin.feedback.index', compact('titles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() : View
    {
        return view('admin.feedback.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FeedbackCreateRequest  $request
     * @return RedirectResponse
     */
    public function store(FeedbackCreateRequest $request) : RedirectResponse
    {
        $imagePath = $this->uploadImage($request, 'image');

        Feedback::create(array_merge($request->all(), ['image' => $imagePath]));

        toastr()->success('Created Successfully!');

        return to_route('admin.feedbacks.index');
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
        $feedback = Feedback::findOrFail($id);

        return view('admin.feedback.edit', compact('feedback'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FeedbackUpdateRequest  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(FeedbackUpdateRequest $request, $id) : RedirectResponse
    {
        $imagePath = $this->uploadImage($request, 'image', $request->old_image);

        $feedback = Feedback::findOrFail($id);
        $feedback->update(array_merge($request->all(), ['image' => !empty($imagePath) ? $imagePath : $request->old_image]));

        toastr()->success('Created Successfully!');

        return to_route('admin.feedbacks.index');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function updateTitle(Request $request)
    {
        $validatedData = $request->validate([
            'feedback_top_title' => ['max:100'],
            'feedback_main_title' => ['max:200'],
            'feedback_sub_title' => ['max:500']
        ]);
        foreach ($validatedData as $key => $value) {
            SectionTitle::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        toastr()->success('Updated Successfully!');

        return redirect()->back();
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
            $feedback = Feedback::findOrFail($id);
            $this->removeImage($feedback->image);
            $feedback->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
