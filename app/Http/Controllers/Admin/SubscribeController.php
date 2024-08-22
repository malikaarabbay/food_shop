<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubscriberDataTable;
use App\Http\Controllers\Controller;
use App\Mail\Subscribe;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Mail;

class SubscribeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SubscriberDataTable $dataTable
     * @return View|JsonResponse
     */
    function index(SubscriberDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.subscribe.index');
    }

    /**
     * Send a mail to subscribers
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    function sendEmail(Request $request) : RedirectResponse
    {
        $request->validate([
            'subject' => ['required', 'max:255'],
            'message' => ['required']
        ]);

        $subscribers = Subscriber::pluck('email')->toArray();

        Mail::to($subscribers)->send(new Subscribe($request->subject, $request->message));

        toastr()->success('News letter sent successfully!');

        return redirect()->back();
    }
}
