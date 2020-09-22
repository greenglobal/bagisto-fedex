<?php

namespace GGPHP\Shipping\Carriers;

use Webkul\Checkout\Models\CartShippingRate;
use Webkul\Checkout\Facades\Cart;
use Webkul\Shipping\Carriers\AbstractShipping;

/**
 * Class Rate.
 *
 */
class Fedex extends AbstractShipping
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code = 'fedexrate';

    /**
     * Returns rate for fedexrate
     *
     * @return array
     */
    public function calculate()
    {
        $data = ['status' => false];

        if (! $this->isAvailable()) {
            $data['message'] = 'Unavailable shipping method';

            return $data;
        }

        $cart = Cart::getCart();

        if (empty($cart->shipping_address)) {
            $data['message'] = 'No shipping address';

            return $data;
        }

        // Get shipping address
        $address = $cart->shipping_address;
        $shipperStreetLines = core()->getConfigData('sales.shipping.origin.address1') ?? '';
        $shipperCity = core()->getConfigData('sales.shipping.origin.city') ?? '';
        $shipperState = core()->getConfigData('sales.shipping.origin.state') ?? '';
        $shipperZipCode = core()->getConfigData('sales.shipping.origin.zipcode') ?? '';
        $shipperCountryCode = core()->getConfigData('sales.shipping.origin.country') ?? '';

        if (empty($shipperZipCode) || empty($shipperCountryCode)) {
            $data['message'] = 'No Zip/Postal code or Country in dashboard configuration';

            return $data;
        }

        $shippingInfo = [
            'shipper' => [
                'street_lines' => $shipperStreetLines,
                'city' => $shipperCity,
                'state' => $shipperState,
                'postal_code' => $shipperZipCode,
                'country_code' => $shipperCountryCode,
            ],
            'recipient' => [
                'street_lines' => $address->address1 ?? ($address->address2 ?? ''),
                'city' => $address->city ?? '',
                'state' => $address->state ?? '',
                'postal_code' => $address->postcode ?? '',
                'country_code' => $address->country ?? '',
            ],
            'packaging_type' => $this->getConfigData('packaging_type') ?? 'YOUR_PACKAGING',
        ];
        $defaultAmount = $this->getConfigData('default_rate') ?? 0;

        if ($this->getConfigData('type') == 'per_unit') {
            foreach ($cart->items as $item) {
                if ($item->product->getTypeInstance()->isStockable()) {
                    $defaultAmount = $defaultAmount + ($defaultAmount * $item->quantity);
                    $shipping = $item->child->product->product ?? $item->product;

                    $shippingInfo['package'] = [
                        'weight' => ($shippingInfo['package']['weight'] ?? 0) + ((int) ($shipping->weight ?? 0) * $item->quantity),
                        'length' => ($shippingInfo['package']['length'] ?? 0) + ((int) ($shipping->depth ?? 0) * $item->quantity),
                        'width' => ($shippingInfo['package']['width'] ?? 0) + ((int) ($shipping->width ?? 0) * $item->quantity),
                        'height' => ($shippingInfo['package']['height'] ?? 0) + ((int) ($shipping->height ?? 0) * $item->quantity),
                    ];
                }
            }

            // Get shipping rates
            $rateDetails = calculateShippingRates($shippingInfo);

            if (isset($rateDetails['status']) && !$rateDetails['status'])
                return $rateDetails;

            $services = [];
            $presentServices = explode(',', $this->getConfigData('services'));
            foreach ($rateDetails as $rateDetail) {
                if (! empty($rateDetail['type']) && in_array($rateDetail['type'], $presentServices)) {
                    $object = new CartShippingRate;
                    $object->carrier = 'fedexrate';
                    $object->carrier_title = $this->getConfigData('title');
                    $object->method = 'fedexrate_' . ($rateDetail['type'] ?? '');
                    $object->method_title = $rateDetail['name'] ?? '';
                    $object->method_description = ($rateDetail['name'] ?? '')
                        . (! empty($rateDetail['astra']) ? ' - ' . $rateDetail['astra'] : '');
                    $object->price += $rateDetail['amount'] ?? core()->convertPrice($defaultAmount);
                    $object->base_price += $rateDetail['amount'] ?? $defaultAmount;
                    $services[] = $object;
                    unset($object);
                }
            }
        } else {
            $object->price = core()->convertPrice($this->getConfigData('default_rate'));
            $object->base_price = $this->getConfigData('default_rate');
        }

        $data['status'] = true;
        $data['services'] = $services;

        return $data;
    }
}
