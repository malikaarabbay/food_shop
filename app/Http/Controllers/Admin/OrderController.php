<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DeclinedOrderDataTable;
use App\DataTables\DeliveredOrderDataTable;
use App\DataTables\InProcessOrderDataTable;
use App\DataTables\OrderDataTable;
use App\DataTables\PendingOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderPlacedNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param OrderDataTable $dataTable
     * @return View|JsonResponse
     */
    public function index(OrderDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.order.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param PendingOrderDataTable $dataTable
     * @return View|JsonResponse
     */
    function pendingOrderIndex(PendingOrderDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.order.pending_order_index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param InProcessOrderDataTable $dataTable
     * @return View|JsonResponse
     */
    function inProcessOrderIndex(InProcessOrderDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.order.inprocess_order_index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param DeliveredOrderDataTable $dataTable
     * @return View|JsonResponse
     */
    function deliveredOrderIndex(DeliveredOrderDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.order.delivered_order_index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param DeclinedOrderDataTable $dataTable
     * @return View|JsonResponse
     */
    function declinedOrderIndex(DeclinedOrderDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.order.declined_order_index');
    }

    /**
     * Show order by ID.
     *
     * @param int $id
     * @return View
     */
    function show($id) : View
    {
        $order = Order::findOrFail($id);
        OrderPlacedNotification::where('order_id', $order->id)->update(['seen' => 1]);

        return view('admin.order.show', compact('order'));
    }

    /**
     * Get order status by ID.
     *
     * @param string $id
     * @return Response
     */
    function getOrderStatus(string $id) : Response
    {
        $order = Order::select(['order_status', 'payment_status'])->findOrFail($id);

        return response($order);
    }

    /**
     * Update order status by ID.
     *
     * @param Request $request
     * @param string $id
     * @return RedirectResponse|Response
     */
    function orderStatusUpdate(Request $request, string $id) : RedirectResponse|Response
    {
        $request->validate([
            'payment_status' => ['required', 'in:pending,completed'],
            'order_status' => ['required', 'in:pending,in_process,delivered,declined']
        ]);

        $order = Order::findOrFail($id);
        $order->payment_status = $request->payment_status;
        $order->order_status = $request->order_status;
        $order->save();

        if($request->ajax()){
            return response(['message' => 'Order Status Updated!']);
        }else {
            toastr()->success('Status Updated Successfully!');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return Response
     */
    function destroy(string $id) : Response
    {
        try{
            Order::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        }catch(\Exception $e){
            logger($e);
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
