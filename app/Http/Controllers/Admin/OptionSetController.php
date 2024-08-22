<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\OptionSet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;

class OptionSetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $option_id
     * @return View
     */
    public function index(int $option_id) : View
    {
        $optionSets = OptionSet::where('option_id', $option_id)->get();
        $option = Option::findOrFail($option_id);

        return view('admin.product.option.option_set.index', compact('option_id', 'optionSets', 'option'));
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
            'title' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'option_id' => ['required', 'integer']
        ]);

        OptionSet::create($request->all());

        toastr()->success('Created Successfully');

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
        try{
            OptionSet::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        }catch(\Exception $e){
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
