<?php
    if (! function_exists('fedExCalculateShippingRates')) {
        function fedExCalculateShippingRates($data)
        {
            $rateRequest = new FedEx\RateService\ComplexType\RateRequest();

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
            $rateRequest->RequestedShipment->PackagingType = $data['packaging_type'] ?? FedEx\RateService\SimpleType\PackagingType::_YOUR_PACKAGING;

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
            $rateRequest->RequestedShipment->ShippingChargesPayment->PaymentType = FedEx\RateService\SimpleType\PaymentType::_SENDER;

            // Rate request types
            $rateRequest->RequestedShipment->RateRequestTypes = [FedEx\RateService\SimpleType\RateRequestType::_LIST];
            $rateRequest->RequestedShipment->PackageCount = 1;

            // Create package line items
            $rateRequest->RequestedShipment->RequestedPackageLineItems = [new FedEx\RateService\ComplexType\RequestedPackageLineItem()];

            // Package 1
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Value = $data['package']['weight'];
            $weightUnits = core()->getConfigData('general.general.locale_options.weight_unit') ?? '';
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Units =
                $weightUnits == 'kgs' ? FedEx\RateService\SimpleType\WeightUnits::_KG : FedEx\RateService\SimpleType\WeightUnits::_LB;
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Length = $data['package']['length'];
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Width = $data['package']['width'];
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Height = $data['package']['height'];
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Units =
                core()->getConfigData('sales.carriers.fedexrate.length_class') ??  FedEx\RateService\SimpleType\LinearUnits::_IN;
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->GroupPackageCount = 1;

            $rateServiceRequest = new FedEx\RateService\Request();

            // Use production URL
            if (core()->getConfigData('sales.carriers.fedexrate.production_mode'))
                $rateServiceRequest->getSoapClient()->__setLocation(FedEx\RateService\Request::PRODUCTION_URL);

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

    if (! function_exists('fedExTrackById')) {
        function fedExTrackById($trackingIds)
        {
            $trackRequest = new FedEx\TrackService\ComplexType\TrackRequest();

            // User credential
            $trackRequest->WebAuthenticationDetail->UserCredential->Key = core()->getConfigData('sales.carriers.fedexrate.key') ?? '';
            $trackRequest->WebAuthenticationDetail->UserCredential->Password = core()->getConfigData('sales.carriers.fedexrate.password') ?? '';

            // Client detail
            $trackRequest->ClientDetail->AccountNumber = core()->getConfigData('sales.carriers.fedexrate.account_ID') ?? '';
            $trackRequest->ClientDetail->MeterNumber = core()->getConfigData('sales.carriers.fedexrate.meter_number') ?? '';

            // Version
            $trackRequest->Version->ServiceId = 'trck';
            $trackRequest->Version->Major = 19;
            $trackRequest->Version->Intermediate = 0;
            $trackRequest->Version->Minor = 0;

            // For get all events
            $trackRequest->ProcessingOptions = [FedEx\TrackService\SimpleType\TrackRequestProcessingOptionType::_INCLUDE_DETAILED_SCANS];

            // Track shipments
            $trackRequest->SelectionDetails = [];

            foreach ($trackingIds as $key => $trackingId) {
                $trackRequest->SelectionDetails[] = new FedEx\TrackService\ComplexType\TrackSelectionDetail();
                $trackRequest->SelectionDetails[$key]->PackageIdentifier->Value = $trackingId;
                $trackRequest->SelectionDetails[$key]->PackageIdentifier->Type =
                    FedEx\TrackService\SimpleType\TrackIdentifierType::_TRACKING_NUMBER_OR_DOORTAG;
            }

            $request = new FedEx\TrackService\Request();
            $response = $request->getTrackReply($trackRequest);

            $trackReplyDetails = [];

            if (! empty($response) && $response->HighestSeverity == 'SUCCESS' && ! empty($response->CompletedTrackDetails)) {
                foreach ($response->CompletedTrackDetails as $key => $trackReplyDetail) {
                    if (! empty($notification = $trackReplyDetail->TrackDetails[0]->Notification->Severity) && $notification == 'SUCCESS') {
                        foreach ($trackReplyDetail->TrackDetails as $trackDetail) {
                            $trackReplyDetails[$key]['trackingId'] = $trackDetail->TrackingNumber ?? '';
                            $trackReplyDetails[$key]['trackingNumberUniqueIdentifier'] =
                                $trackDetail->TrackingNumberUniqueIdentifier ?? '';
                            $trackReplyDetails[$key]['statusDetail'] = $trackDetail->StatusDetail ?? '';
                            $trackReplyDetails[$key]['serviceCommitMessage'] = $trackDetail->ServiceCommitMessage ?? '';
                            $trackReplyDetails[$key]['destinationServiceArea'] = $trackDetail->DestinationServiceArea ?? '';
                            $trackReplyDetails[$key]['carrierCode'] = $trackDetail->CarrierCode ?? '';
                            $trackReplyDetails[$key]['operatingCompanyOrCarrierDescription'] =
                                $trackDetail->OperatingCompanyOrCarrierDescription ?? '';
                            $trackReplyDetails[$key]['otherIdentifiers'] = $trackDetail->OtherIdentifiers ?? [];
                            $trackReplyDetails[$key]['service'] = $trackDetail->Service ?? '';
                            $trackReplyDetails[$key]['packageWeight'] = $trackDetail->PackageWeight ?? '';
                            $trackReplyDetails[$key]['packaging'] = $trackDetail->Packaging ?? '';
                            $trackReplyDetails[$key]['physicalPackagingType'] = $trackDetail->PhysicalPackagingType ?? '';
                            $trackReplyDetails[$key]['packageSequenceNumber'] = $trackDetail->PackageSequenceNumber ?? '';
                            $trackReplyDetails[$key]['packageCount'] = $trackDetail->PackageCount ?? '';
                            $trackReplyDetails[$key]['shipmentContentPieceCount'] = $trackDetail->ShipmentContentPieceCount ?? '';
                            $trackReplyDetails[$key]['packageContentPieceCount'] = $trackDetail->PackageContentPieceCount ?? '';
                            $trackReplyDetails[$key]['payments'] = $trackDetail->Payments ?? [];
                            $trackReplyDetails[$key]['shipperAddress'] = $trackDetail->ShipperAddress ?? '';
                            $trackReplyDetails[$key]['originLocationAddress'] = $trackDetail->OriginLocationAddress ?? '';
                            $trackReplyDetails[$key]['datesOrTimes'] = $trackDetail->DatesOrTimes ?? [];
                            $trackReplyDetails[$key]['lastUpdatedDestinationAddress'] = $trackDetail->LastUpdatedDestinationAddress ?? '';
                            $trackReplyDetails[$key]['destinationAddress'] = $trackDetail->DestinationAddress ?? '';
                            $trackReplyDetails[$key]['deliveryAttempts'] = $trackDetail->DeliveryAttempts ?? '';
                            $trackReplyDetails[$key]['totalUniqueAddressCountInConsolidation'] =
                                $trackDetail->TotalUniqueAddressCountInConsolidation ?? '';
                            $trackReplyDetails[$key]['deliveryOptionEligibilityDetails'] =
                                $trackDetail->DeliveryOptionEligibilityDetails ?? [];
                            $trackReplyDetails[$key]['events'] = $trackDetail->Events ?? [];
                        }
                    } else {
                        $trackReplyDetails = [
                            'message' => $trackReplyDetail->TrackDetails[0]->Notification->Message ?? '',
                            'status' => FALSE,
                        ];
                    }
                }
            } else {
                $trackReplyDetails = [
                    'message' => $response->Notifications[0]->Message ?? '',
                    'status' => FALSE,
                ];
            }

            return $trackReplyDetails;
        }
    }
?>
