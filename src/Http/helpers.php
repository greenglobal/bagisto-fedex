<?php

use FedEx\RateService\Request;
use FedEx\RateService\ComplexType;
use FedEx\RateService\SimpleType;

    if (! function_exists('calculateShippingRates')) {
        function calculateShippingRates($data)
        {
            $rateRequest = new ComplexType\RateRequest();

            // Authentication & client details
            $rateRequest->WebAuthenticationDetail->UserCredential->Key = core()->getConfigData('sales.carriers.fedexrate.key') ?? '';
            $rateRequest->WebAuthenticationDetail->UserCredential->Password = core()->getConfigData('sales.carriers.fedexrate.password') ?? '';
            $rateRequest->ClientDetail->AccountNumber = core()->getConfigData('sales.carriers.fedexrate.account_ID') ?? '';
            $rateRequest->ClientDetail->MeterNumber = core()->getConfigData('sales.carriers.fedexrate.meter_number') ?? '';

            // Version
            $rateRequest->Version->ServiceId = 'crs';
            $rateRequest->Version->Major = 24;
            $rateRequest->Version->Minor = 0;
            $rateRequest->Version->Intermediate = 0;
            $rateRequest->ReturnTransitAndCommit = false;

            // Service type
            $rateRequest->RequestedShipment->PackagingType = $data['packaging_type'] ?? SimpleType\PackagingType::_YOUR_PACKAGING;

            // Preferred currency
            $rateRequest->RequestedShipment->PreferredCurrency = core()->getBaseCurrencyCode() ?? 'USD';

            // Shipper
            $rateRequest->RequestedShipment->Shipper->Address->StreetLines = [$data['shipper']['street_lines']];
            $rateRequest->RequestedShipment->Shipper->Address->City = $data['shipper']['city'];
            $rateRequest->RequestedShipment->Shipper->Address->StateOrProvinceCode = $data['shipper']['state'];
            $rateRequest->RequestedShipment->Shipper->Address->PostalCode = $data['shipper']['postal_code'];
            $rateRequest->RequestedShipment->Shipper->Address->CountryCode = $data['shipper']['country_code'];

            // Recipient
            $rateRequest->RequestedShipment->Recipient->Address->StreetLines = [$data['recipient']['street_lines']];
            $rateRequest->RequestedShipment->Recipient->Address->City = $data['recipient']['city'];
            $rateRequest->RequestedShipment->Recipient->Address->StateOrProvinceCode = $data['recipient']['state'];
            $rateRequest->RequestedShipment->Recipient->Address->PostalCode = $data['recipient']['postal_code'];
            $rateRequest->RequestedShipment->Recipient->Address->CountryCode = $data['recipient']['country_code'];

            // Shipping charges payment
            $rateRequest->RequestedShipment->ShippingChargesPayment->PaymentType = SimpleType\PaymentType::_SENDER;

            // Rate request types
            $rateRequest->RequestedShipment->RateRequestTypes = [SimpleType\RateRequestType::_LIST];
            $rateRequest->RequestedShipment->PackageCount = 1;

            // Create package line items
            $rateRequest->RequestedShipment->RequestedPackageLineItems = [new ComplexType\RequestedPackageLineItem()];

            // Package 1
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Value = $data['package']['weight'];
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Units =
                core()->getConfigData('sales.carriers.fedexrate.weight_unit') ??  SimpleType\WeightUnits::_LB;
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Length = $data['package']['length'];
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Width = $data['package']['width'];
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Height = $data['package']['height'];
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Units =
                core()->getConfigData('sales.carriers.fedexrate.length_class') ??  SimpleType\LinearUnits::_IN;
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->GroupPackageCount = 1;

            $rateServiceRequest = new Request();

            // Use production URL
            if (core()->getConfigData('sales.carriers.fedexrate.production_mode'))
                $rateServiceRequest->getSoapClient()->__setLocation(Request::PRODUCTION_URL);

            $response = $rateServiceRequest->getGetRatesReply($rateRequest);
            $rateDetails = [];

            if ($response->HighestSeverity == 'SUCCESS' && ! empty($response->RateReplyDetails)) {
                foreach ($response->RateReplyDetails as $rateReplyDetail) {
                    $data = [
                        'type' => $rateReplyDetail->ServiceDescription->ServiceType ?? '',
                        'name' => $rateReplyDetail->ServiceDescription->Description ?? '',
                        'astra' => $rateReplyDetail->ServiceDescription->AstraDescription ?? '',
                    ];

                    if (! empty($rateReplyDetail->RatedShipmentDetails)) {
                        foreach ($rateReplyDetail->RatedShipmentDetails as $ratedShipmentDetail) {
                            if ($ratedShipmentDetail->ShipmentRateDetail->RateType == 'PAYOR_ACCOUNT_PACKAGE') {
                                $data['amount'] = $ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Amount;
                                $data['currency'] = $ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Currency;
                            }
                        }
                    }

                    $rateDetails[] = $data;
                }
            } else {
                $rateDetails = [
                    'status' => FALSE,
                    'message' => $response->Notifications[0]->Message ?? '',
                ];
            }

            return $rateDetails;
        }
    }
?>
