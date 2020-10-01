<?php

namespace GGPHP\Shipping;

use Illuminate\Support\Facades\Config;
use Webkul\Checkout\Facades\Cart;
use Webkul\Shipping\Shipping as ShippingWebkul;

/**
 * Class Shipping.
 *
 */
class Shipping extends ShippingWebkul
{
    /**
     * Rates
     *
     * @var array
     */
    protected $rates = [];

    /**
     * Collects rate from available shipping methods
     *
     * @return array
     */
    public function collectRates()
    {
        if (! $cart = Cart::getCart()) {
            return [
                'status' => false,
                'message' => 'No cart information',
            ];
        }

        $this->removeAllShippingRates();

        foreach (Config::get('carriers') as $shippingMethod) {
            $object = new $shippingMethod['class'];
            if ($object->isAvailable() && $rates = $object->calculate()) {
                if ($shippingMethod['code'] == 'fedexrate') {
                    if (! $rates['status'])
                        return $rates;

                    $rates = $rates['services'];
                }

                if (is_array($rates)) {
                    $this->rates = array_merge($this->rates, $rates);
                } else {
                    $this->rates[] = $rates;
                }
            }
        }

        rsort($this->rates);
        $this->saveAllShippingRates();

        return [
            'status' => true,
            'jump_to_section' => 'shipping',
            'shippingMethods' => $this->getGroupedAllShippingRates(),
            'html'            => view('shop::checkout.onepage.shipping',
                ['shippingRateGroups' => $this->getGroupedAllShippingRates()])->render(),
        ];
    }
}
