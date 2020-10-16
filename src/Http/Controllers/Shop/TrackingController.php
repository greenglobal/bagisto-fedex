<?php

namespace GGPHP\Shipping\Http\Controllers\Shop;

use Webkul\Shop\Http\Controllers\Controller;
use Webkul\Sales\Repositories\OrderRepository;

class TrackingController extends Controller
{
    protected $_config;

    protected $orderRepository;

    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->middleware('customer');

        $this->orderRepository = $orderRepository;

        parent::__construct();
    }

    /**
     * Show the view for the specified resource.
     *
     * @param  int  $orderId
     * @return \Illuminate\View\View
     */
    public function view($orderId)
    {
        $order = $this->orderRepository->findOrFail($orderId);
        $shipments = $order->shipments()->get()->toArray();
        $trackings = $shipments ? fedexTrackById(array_column($shipments, 'track_number')) : [];

        return view($this->_config['view'], compact('trackings', 'order'));
    }
}
