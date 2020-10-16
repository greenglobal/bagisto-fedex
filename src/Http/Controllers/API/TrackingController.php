<?php

namespace GGPHP\Shipping\Http\Controllers\API;

use Webkul\API\Http\Controllers\Shop\Controller;
use Illuminate\Http\Response;

class TrackingController extends Controller
{
    /**
     * Contains current guard
     *
     * @var array
     */
    protected $guard;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    public function __construct()
    {
        $this->guard = 'api';

        $this->_config = request('_config');

        if (isset($this->_config['authorization_required']) && $this->_config['authorization_required']) {
            auth()->setDefaultDriver($this->guard);

            $this->middleware('auth:' . $this->guard);
        }
    }

    /**
     * Returns a tracking info.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        $trackings = fedexTrackById([$id]);

        if (isset($trackings['status']) && !$trackings['status']) {
            return response()->json([
                'errors' => [
                    [
                        'detail' => $trackings['message'] ?? '',
                    ]
                ]
            ], 400);
        }

        foreach ($trackings as $key => $tracking)
            $trackings[$key] = $this->convertObjectToArray($tracking);

        return response()->json([
            'data' => $trackings,
        ]);
    }

    /**
     * This function is used for converting from object to array
     *
     * @param array $array
     * @return array
     */
    public function convertObjectToArray($data)
    {
        foreach ($data as $key => $value) {
            if (is_object($value)) {
                $values = array_values((array) $value)[1] ?? [];
                $data[$key] = $values;

                foreach ($values as $key1 => $value1) {
                    if (is_object($value1))
                        $data[$key][$key1] = array_values((array) $value1)[1] ?? [];
                }
            }

            if (is_array($value))
                $data[$key] = $this->convertObjectToArray($value);
        }

        return $data;
    }
}
