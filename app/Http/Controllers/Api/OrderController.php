<?php

namespace App\Http\Controllers\Api;

use App\Actions\Orders\StoreOrderAction;
use App\Actions\Orders\UpdateOrderAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Order;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Builder[]|Collection|Response
     */
    public function index()
    {
        return Order::with('product.iva')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderRequest $request
     * @param Order $order
     * @param StoreOrderAction $action
     * @return Model
     */
    public function store(OrderRequest $request, Order $order, StoreOrderAction $action): Model
    {
        return $action->execute($order, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return Builder|Builder[]|Collection|Model|Response
     */
    public function show(Order $order)
    {
        return Order::with('product.iva')->find($order->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrderRequest $request
     * @param Order $order
     * @param UpdateOrderAction $action
     * @return Model
     */
    public function update(OrderRequest $request, Order $order, UpdateOrderAction $action)
    {
        return $action->execute($order, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return array|Response|string
     * @throws Exception
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return __('This order was successfully deleted');
    }
}
