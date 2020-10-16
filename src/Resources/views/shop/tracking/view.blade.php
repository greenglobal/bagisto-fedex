@extends('shop::layouts.master')

@section('page_title')
    {{ __('ggphp::fedex.admin.system.trackings-title') }}
@stop

@section('content-wrapper')

    <div class="main-container-wrapper container">
        <div class="header header-tracking">
            <div class="header-top">
                <h1>
                    {{ __('ggphp::fedex.admin.system.trackings-title') }}
                </h1>
            </div>
        </div>

        <div class="content-container">

            @if (! empty($trackings) && ! isset($trackings['status']))
                @foreach ($trackings as $tracking)
                    <div class="sale-container tracking">
                        <div class="tracking-info">
                            <div class="box">
                                <strong class="box-title">{{ __('ggphp::fedex.admin.system.tracking-id') }}:</strong>

                                <div class="box-content">
                                    #{{ $tracking['trackingId'] ?? '' }}
                                </div>
                            </div>

                            <div class="box">
                                <strong class="box-title">{{ __('ggphp::fedex.admin.system.order-id') }}:</strong>

                                <div class="box-content">
                                    <a href="{{ route('customer.orders.view', $order->id ?? '') }}">
                                        #{{ $order->id ?? '' }}
                                    </a>
                                </div>
                            </div>

                            <div class="box">
                                <strong class="box-title">
                                    {{ __('shop::app.customer.account.order.view.billing-address') }}
                                </strong>

                                <div class="box-content">
                                    @include ('admin::sales.address', ['address' => $order->billing_address])
                                </div>
                            </div>

                            @if ($order->shipping_address)
                                <div class="box">
                                    <strong class="box-title">
                                        {{ __('shop::app.customer.account.order.view.shipping-address') }}
                                    </strong>

                                    <div class="box-content">
                                        @include ('admin::sales.address', ['address' => $order->shipping_address])
                                    </div>
                                </div>

                                <div class="box">
                                    <strong class="box-title">
                                        {{ __('shop::app.customer.account.order.view.shipping-method') }}
                                    </strong>

                                    <div class="box-content">
                                        {{ $order->shipping_title ?? '' }}
                                    </div>
                                </div>
                            @endif

                            <div class="box">
                                <strong class="box-title">
                                    {{ __('shop::app.customer.account.order.view.payment-method') }}
                                </strong>

                                <div class="box-content">
                                    {{ core()->getConfigData('sales.paymentmethods.' . $order->payment->method . '.title') }}

                                    @php $additionalDetails = \Webkul\Payment\Payment::getAdditionalDetails($order->payment->method); @endphp

                                    @if (! empty($additionalDetails))
                                        <div class="instructions">
                                            <label>{{ $additionalDetails['title'] }}</label>
                                            <p>{{ $additionalDetails['value'] }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="process-bar">
                            <ul class="events">

                                @if (! empty($tracking['statusDetail']) && $tracking['statusDetail']->Code == 'DL')
                                    <li class="delivered">
                                        <span class="time checked">
                                            {{ $tracking['statusDetail']->CreationTime ? date('F, n/d/Y', strtotime($tracking['statusDetail']->CreationTime)) : '' }}
                                        </span>
                                        <span class="address checked">
                                            <strong>{{ $tracking['statusDetail']->Description }}</strong>
                                            {{
                                                $tracking['statusDetail']->Location->City ?? '' .
                                                ( $tracking['statusDetail']->Location->PostalCode ? (', ' .  $tracking['statusDetail']->Location->PostalCode) : '') .
                                                ( $tracking['statusDetail']->Location->StateOrProvinceCode ? (', ' .  $tracking['statusDetail']->Location->StateOrProvinceCode) : '') .
                                                ( $tracking['statusDetail']->Location->CountryCode ? (', ' .  $tracking['statusDetail']->Location->CountryCode) : '')
                                            }}
                                        </span>
                                    <li>
                                @else
                                    <li>
                                        <span class="time"></span>
                                        <span class="address">
                                            <strong>Delivered</strong>
                                        </span>
                                    </li>
                                @endif

                                @foreach ($tracking['events'] as $event)
                                    @if ($event->EventType == 'DL')
                                        @continue
                                    @endif

                                     <li>
                                        <span class="time checked">{{ $event->Timestamp ? date('F, n/d/Y', strtotime($event->Timestamp)) : '' }}</span>
                                        <span class="address checked">
                                            <strong>{{ $event->EventDescription ?? '' }}</strong>
                                            {{
                                                $event->Address->City ?? '' .
                                                ($event->Address->PostalCode ? (', ' . $event->Address->PostalCode) : '') .
                                                ($event->Address->StateOrProvinceCode ? (', ' . $event->Address->StateOrProvinceCode) : '') .
                                                ($event->Address->CountryCode ? (', ' . $event->Address->CountryCode) : '')
                                            }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="sale-container">
                    <p>{{ $trackings['message'] ?? '' }}</p>
                </div>
            @endif

        </div>
    </div>

@stop
