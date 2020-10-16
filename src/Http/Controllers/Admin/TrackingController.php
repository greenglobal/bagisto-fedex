<?php

namespace GGPHP\Shipping\Http\Controllers\Admin;

use Webkul\Admin\Http\Controllers\Controller;

class TrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $_config;

    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');

        $this->_config = request('_config');
    }

    /**
     * Show the view for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($trackingId)
    {
        $trackings = fedExTrackById([$trackingId]);

        return view($this->_config['view'], compact('trackings', 'trackingId'));
    }
}
