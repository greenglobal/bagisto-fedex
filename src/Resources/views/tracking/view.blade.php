@extends('admin::layouts.master')

@section('page_title')
    {{ __('ggphp::fedex.admin.system.tracking-title') }}
@stop

@section('css')
    <style type="text/css">
        .body-section {
            display: flex;
        }
        .body-section .secton-title {
            text-transform: capitalize;
        }
        .sale-container .sale-section .section-content .row .title {
            width: 325px;
            text-transform: capitalize;
        }
        .sale-container .sale-section.col-6 {
            width: 50%;
        }
        .sale-container .sale-section {
            padding: 0 30px;
        }
        .sale-container .track-details {
            background-color: #efefef;
            padding: 12px;
            margin-bottom: 20px;
        }
        .sale-container .track-title {
            font-size: 18px;
            padding: 15px;
        }
    </style>
@stop

@section('content-wrapper')

    <div class="content full-page">
        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="window.location = history.length > 1 ? document.referrer : '{{ route('admin.dashboard.index') }}'"></i>

                    {{ __('ggphp::fedex.admin.system.tracking-title') }} #{{ $trackingId }}
                </h1>
            </div>

            <div class="page-action">
            </div>
        </div>

        <div class="page-content">
            <div class="sale-container">
                <div slot="body">

                    @if (! isset($trackings['status']))
                        @foreach ($trackings as $key => $tracking)
                            <div class="track-details">

                                @if (count($trackings) > 1)
                                    <div class="track-title">
                                        {{ $tracking['operatingCompanyOrCarrierDescription'] }}
                                    </div>
                                @endif

                                <div class="track-body">
                                    <accordian :title="'{{ __('ggphp::fedex.admin.system.tracking-info') }}'" :active="{{ $key == 0 ? 'true' : 'false' }}">
                                        <div slot="body" class="body-section">
                                            <div class="sale-section">
                                                <div class="section-content">
                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.tracking-id') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['trackingId'] }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.tracking-number-unique-identifier') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['trackingNumberUniqueIdentifier'] }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.service-commit-message') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['serviceCommitMessage'] }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.destination-service-area') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['destinationServiceArea'] }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.company-or-carrier') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['operatingCompanyOrCarrierDescription'] }} - {{ $tracking['carrierCode'] }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.shipment-content-piece-count') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['shipmentContentPieceCount'] }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.delivery-attempts') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['deliveryAttempts'] }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.package-weight') }}
                                                        </span>

                                                        <span class="value">
                                                            {{ $tracking['packageWeight']->Value }}
                                                        </span>

                                                        <span class="value">
                                                            {{ $tracking['packageWeight']->Units }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.packaging') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['packaging']->Type }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.physical-packaging-type') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['physicalPackagingType'] }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.package-sequence-number') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['packageSequenceNumber'] }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.package-count') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['packageCount'] }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.package-content-piece-count') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['packageContentPieceCount'] }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.total-consolidation') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['totalUniqueAddressCountInConsolidation'] }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </accordian>
                                    <accordian :title="'{{ __('ggphp::fedex.admin.system.status-detail-and-service') }}'" :active="false">
                                        <div slot="body" class="body-section">
                                            <div class="sale-section col-6">
                                                <div class="secton-title">
                                                    <span>{{ __('ggphp::fedex.admin.system.status-detail') }}</span>
                                                </div>

                                                <div class="section-content">
                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.creation-time') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['statusDetail']->CreationTime ? date('F, n/d/Y', strtotime($tracking['statusDetail']->CreationTime)) : '' }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.code') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['statusDetail']->Code ?? '' }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.location') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['statusDetail']->Location->City ?? '' }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['statusDetail']->Location->StateOrProvinceCode }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['statusDetail']->Location->CountryCode ?? '' }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['statusDetail']->Location->CountryName ?? '' }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.residential') }}
                                                        </span>

                                                        <span class="value">
                                                            {{ ! empty($tracking['statusDetail']->Location->Residential) ? 'Yes' : 'No' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sale-section col-6">
                                                <div class="secton-title">
                                                    <span>{{ __('ggphp::fedex.admin.system.service') }}</span>
                                                </div>

                                                <div class="section-content">
                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.creation-time') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['statusDetail']->CreationTime ? date('F, n/d/Y', strtotime($tracking['statusDetail']->CreationTime)) : '' }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            Code
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['statusDetail']->Code ?? '' }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.location') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['statusDetail']->Location->City ?? '' }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['statusDetail']->Location->StateOrProvinceCode ?? '' }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['statusDetail']->Location->CountryCode ?? '' }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['statusDetail']->Location->CountryName ?? '' }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.residential') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ ! empty($tracking['statusDetail']->Location->Residential) ? 'Yes' : 'No' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </accordian>
                                    <accordian :title="'{{ __('ggphp::fedex.admin.system.payments') }}'" :active="false">
                                        <div slot="body">

                                            @if (! empty($tracking['payments']))
                                                @foreach ($tracking['payments'] as $key => $payment)
                                                    <div class="sale-section">
                                                        <div class="secton-title">
                                                            <span>{{ __('ggphp::fedex.admin.system.payment') }} {{ $key }}:</span>
                                                        </div>

                                                        <div class="section-content">
                                                            <div class="row">
                                                                <span class="title">
                                                                    {{ __('ggphp::fedex.admin.system.type') }}
                                                                </span>
                                                                <span class="value">
                                                                    {{ $payment->Type }}
                                                                </span>
                                                            </div>

                                                            <div class="row">
                                                                <span class="title">
                                                                    {{ __('ggphp::fedex.admin.system.classification') }}
                                                                </span>
                                                                <span class="value">
                                                                    {{ $payment->Classification }}
                                                                </span>
                                                            </div>

                                                            <div class="row">
                                                                <span class="title">
                                                                    {{ __('ggphp::fedex.admin.system.description') }}
                                                                </span>
                                                                <span class="value">
                                                                    {{ $payment->Description }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p>{{ __('ggphp::fedex.admin.system.no-data') }}</p>
                                            @endif

                                        </div>
                                    </accordian>
                                    <accordian :title="'{{ __('ggphp::fedex.admin.system.address') }}'" :active="false">
                                        <div slot="body" class="body-section">
                                            <div class="sale-section col-6">
                                                <div class="secton-title">
                                                    <span>{{ __('ggphp::fedex.admin.system.shipper-address') }}</span>
                                                </div>

                                                <div class="section-content">
                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.city') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['shipperAddress']->City }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.state-or-province-code') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['shipperAddress']->StateOrProvinceCode }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.country-code') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['shipperAddress']->CountryCode }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.country-name') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['shipperAddress']->CountryName }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.residential') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['shipperAddress']->Residential ? 'Yes' : 'No' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sale-section col-6">
                                                <div class="secton-title">
                                                    <span>{{ __('ggphp::fedex.admin.system.origin-location-address') }}</span>
                                                </div>

                                                <div class="section-content">
                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.city') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['originLocationAddress']->City }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.state-or-province-code') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['originLocationAddress']->StateOrProvinceCode }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.country-code') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['originLocationAddress']->CountryCode }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.country-name') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['originLocationAddress']->CountryName }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.residential') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['originLocationAddress']->Residential ? 'Yes' : 'No' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div slot="body" class="body-section">
                                            <div class="sale-section col-6">
                                                <div class="secton-title">
                                                    <span>{{ __('ggphp::fedex.admin.system.destination-address') }}</span>
                                                </div>

                                                <div class="section-content">
                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.city') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['destinationAddress']->City }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.state-or-province-code') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['destinationAddress']->StateOrProvinceCode }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.country-code') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['destinationAddress']->CountryCode }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.country-name') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['destinationAddress']->CountryName }}
                                                        </span>
                                                    </div>

                                                    <div class="row">
                                                        <span class="title">
                                                            {{ __('ggphp::fedex.admin.system.residential') }}
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['destinationAddress']->Residential ? 'Yes' : 'No' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="sale-section col-6">
                                                <div class="secton-title">
                                                    <span>{{ __('ggphp::fedex.admin.system.last-updated-destination-address') }}</span>
                                                </div>

                                                <div class="section-content">
                                                    <div class="row">
                                                        <span class="title">
                                                            City
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['lastUpdatedDestinationAddress']->City }}
                                                        </span>
                                                    </div>
                                                    <div class="row">
                                                        <span class="title">
                                                            State Or Province Code
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['lastUpdatedDestinationAddress']->StateOrProvinceCode }}
                                                        </span>
                                                    </div>
                                                    <div class="row">
                                                        <span class="title">
                                                            Country Code
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['lastUpdatedDestinationAddress']->CountryCode }}
                                                        </span>
                                                    </div>
                                                    <div class="row">
                                                        <span class="title">
                                                            Country Name
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['lastUpdatedDestinationAddress']->CountryName }}
                                                        </span>
                                                    </div>
                                                    <div class="row">
                                                        <span class="title">
                                                            Residential
                                                        </span>
                                                        <span class="value">
                                                            {{ $tracking['lastUpdatedDestinationAddress']->Residential ? 'Yes' : 'No' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </accordian>
                                    <accordian :title="'{{ __('ggphp::fedex.admin.system.events') }}'" :active="false">
                                        <div slot="body">

                                            @if (! empty($tracking['events']))
                                                @foreach (array_reverse($tracking['events']) as $key => $event)
                                                    <div class="sale-section">
                                                        <div class="secton-title">
                                                            <span>{{ __('ggphp::fedex.admin.system.event') }} {{ $key }}:</span>
                                                        </div>

                                                        <div class="section-content">
                                                            <div class="row">
                                                                <span class="title">
                                                                    {{ __('ggphp::fedex.admin.system.timestamp') }}
                                                                </span>
                                                                <span class="value">
                                                                    {{ $event->Timestamp ? date('F, n/d/Y H:i:s', strtotime($event->Timestamp)) : '' }}
                                                                </span>
                                                            </div>

                                                            <div class="row">
                                                                <span class="title">
                                                                    {{ __('ggphp::fedex.admin.system.event-type') }}
                                                                </span>
                                                                <span class="value">
                                                                    {{ $event->EventType }}
                                                                </span>
                                                            </div>

                                                            <div class="row">
                                                                <span class="title">
                                                                    {{ __('ggphp::fedex.admin.system.event-description') }}
                                                                </span>
                                                                <span class="value">
                                                                    {{ $event->EventDescription }}
                                                                </span>
                                                            </div>

                                                            <div class="row">
                                                                <span class="title">
                                                                    {{ __('ggphp::fedex.admin.system.city') }}
                                                                </span>
                                                                <span class="value">
                                                                    {{ $event->Address->City }}
                                                                </span>
                                                            </div>

                                                            <div class="row">
                                                                <span class="title">
                                                                    {{ __('ggphp::fedex.admin.system.state-or-province-code') }}
                                                                </span>
                                                                <span class="value">
                                                                    {{ $event->Address->StateOrProvinceCode }}
                                                                </span>
                                                            </div>

                                                            <div class="row">
                                                                <span class="title">
                                                                    {{ __('ggphp::fedex.admin.system.postal-code') }}
                                                                </span>
                                                                <span class="value">
                                                                    {{ $event->Address->PostalCode }}
                                                                </span>
                                                            </div>

                                                            <div class="row">
                                                                <span class="title">
                                                                    {{ __('ggphp::fedex.admin.system.country-code') }}
                                                                </span>
                                                                <span class="value">
                                                                    {{ $event->Address->CountryCode }}
                                                                </span>
                                                            </div>

                                                            <div class="row">
                                                                <span class="title">
                                                                    {{ __('ggphp::fedex.admin.system.country-name') }}
                                                                </span>
                                                                <span class="value">
                                                                    {{ $event->Address->CountryName }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p>{{ __('ggphp::fedex.admin.system.no-data') }}</p>
                                            @endif

                                        </div>
                                    </accordian>
                                    <accordian :title="'{{ __('ggphp::fedex.admin.system.dates-or-times') }}'" :active="false">
                                        <div slot="body">

                                            @if (! empty($tracking['datesOrTimes']))
                                                @foreach ($tracking['datesOrTimes'] as $key => $datesOrTime)
                                                    <div class="sale-section">
                                                        <div class="secton-title">
                                                            <span>{{ __('ggphp::fedex.admin.system.date-or-time') }} {{ $key }}:</span>
                                                        </div>

                                                        <div class="section-content">
                                                            <div class="row">
                                                                <span class="title">
                                                                    {{ __('ggphp::fedex.admin.system.type') }}
                                                                </span>
                                                                <span class="value">
                                                                    {{ $datesOrTime->Type }}
                                                                </span>
                                                            </div>

                                                            <div class="row">
                                                                <span class="title">
                                                                    {{ __('ggphp::fedex.admin.system.date-or-timestamp') }}
                                                                </span>
                                                                <span class="value">
                                                                    {{ $datesOrTime->DateOrTimestamp ? date('F, n/d/Y H:i:s', strtotime($datesOrTime->DateOrTimestamp)) : '' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p>{{ __('ggphp::fedex.admin.system.no-data') }}</p>
                                            @endif

                                        </div>
                                    </accordian>
                                    <accordian :title="'{{ __('ggphp::fedex.admin.system.other-identifiers') }}'" :active="false">
                                        <div slot="body">

                                            @if (! empty($tracking['otherIdentifiers']))
                                                @foreach ($tracking['otherIdentifiers'] as $key => $otherIdentifier)
                                                    <div class="sale-section">
                                                        <div class="secton-title">
                                                            <span>{{ __('ggphp::fedex.admin.system.identifier') }} {{ $key }}:</span>
                                                        </div>

                                                        <div class="section-content">
                                                            <div class="row">
                                                                <span class="title">
                                                                    {{ __('ggphp::fedex.admin.system.type') }}
                                                                </span>
                                                                <span class="value">
                                                                    {{ $otherIdentifier->PackageIdentifier->Type }}
                                                                </span>
                                                            </div>

                                                            <div class="row">
                                                                <span class="title">
                                                                    {{ __('ggphp::fedex.admin.system.value') }}
                                                                </span>
                                                                <span class="value">
                                                                    {{ $otherIdentifier->PackageIdentifier->Value }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p>{{ __('ggphp::fedex.admin.system.no-data') }}</p>
                                            @endif

                                        </div>
                                    </accordian>
                                    <accordian :title="'{{ __('ggphp::fedex.admin.system.delivery-option-eligibility-details') }}'" :active="false">
                                        <div slot="body">

                                            @if (! empty($tracking['deliveryOptionEligibilityDetails']))
                                                @foreach ($tracking['deliveryOptionEligibilityDetails'] as $key => $deliveryOptionEligibilityDetail)
                                                    <div class="sale-section">
                                                        <div class="secton-title">
                                                            <span>{{ __('ggphp::fedex.admin.system.option-eligibility') }} {{ $key }}:</span>
                                                        </div>

                                                        <div class="section-content">
                                                            <div class="row">
                                                                <span class="title">
                                                                    {{ __('ggphp::fedex.admin.system.option') }}
                                                                </span>
                                                                <span class="value">
                                                                    {{ $deliveryOptionEligibilityDetail->Option }}
                                                                </span>
                                                            </div>

                                                            <div class="row">
                                                                <span class="title">
                                                                    {{ __('ggphp::fedex.admin.system.eligibility') }}
                                                                </span>
                                                                <span class="value">
                                                                    {{ $deliveryOptionEligibilityDetail->Eligibility }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p>{{ __('ggphp::fedex.admin.system.no-data') }}</p>
                                            @endif

                                        </div>
                                    </accordian>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="message">
                            <p>{{ $trackings['message'] }}<p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@stop
