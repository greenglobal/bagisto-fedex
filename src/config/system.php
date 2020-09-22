<?php

return [
    [
        'key'    => 'sales.carriers.fedexrate',
        'name'   => 'ggphp-shipping::app.admin.system.fedex-rate-shipping',
        'sort'   => 6,
        'fields' => [
            [
                'name'          => 'title',
                'title'         => 'admin::app.admin.system.title',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'description',
                'title'         => 'admin::app.admin.system.description',
                'type'          => 'textarea',
                'channel_based' => true,
                'locale_based'  => false,
            ], [
                'name'          => 'default_rate',
                'title'         => 'admin::app.admin.system.rate',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => false,
            ], [
                'name'       => 'type',
                'title'      => 'admin::app.admin.system.type',
                'type'       => 'select',
                'options'    => [
                    [
                        'title' => 'Per Unit',
                        'value' => 'per_unit',
                    ], [
                        'title' => 'Per Order',
                        'value' => 'per_order',
                    ]
                ],
                'validation' => 'required'
            ], [
                'name'          => 'active',
                'title'         => 'admin::app.admin.system.status',
                'type'          => 'boolean',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ], [
                'name'          => 'account_ID',
                'title'         => 'ggphp-shipping::app.admin.system.account-ID',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'meter_number',
                'title'         => 'ggphp-shipping::app.admin.system.meter-number',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'key',
                'title'         => 'ggphp-shipping::app.admin.system.key',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'password',
                'title'         => 'ggphp-shipping::app.admin.system.password',
                'type'          => 'password',
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'production_mode',
                'title'         => 'ggphp-shipping::app.admin.system.production-mode',
                'type'          => 'boolean',
                'channel_based' => false,
                'locale_based'  => true,
            ], [
                'name'          => 'packaging_type',
                'title'         => 'ggphp-shipping::app.admin.system.packaging-type',
                'type'          => 'select',
                'options'    => [
                    [
                        'title' => 'Your Packaging',
                        'value' => 'YOUR_PACKAGING',
                    ], [
                        'title' => 'FedEx Envelope',
                        'value' => 'FEDEX_ENVELOPE',
                    ], [
                        'title' => 'FedEx Pak',
                        'value' => 'FEDEX_PAK',
                    ], [
                        'title' => 'FedEx Box',
                        'value' => 'FEDEX_BOX',
                    ], [
                        'title' => 'FedEx Tube',
                        'value' => 'FEDEX_TUBE',
                    ], [
                        'title' => 'FedEx Small Box',
                        'value' => 'FEDEX_SMALL_BOX',
                    ], [
                        'title' => 'FedEx Medium Box',
                        'value' => 'FEDEX_MEDIUM_BOX',
                    ], [
                        'title' => 'FedEx Large Box',
                        'value' => 'FEDEX_LARGE_BOX',
                    ], [
                        'title' => 'FedEx Extra Large Box',
                        'value' => 'FEDEX_EXTRA_LARGE_BOX',
                    ], [
                        'title' => 'FedEx 10kg Box',
                        'value' => 'FEDEX_10KG_BOX',
                    ], [
                        'title' => 'FedEx 25kg Box',
                        'value' => 'FEDEX_25KG_BOX',
                    ]
                ],
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'weight_unit',
                'title'         => 'ggphp-shipping::app.admin.system.weight-unit',
                'type'       => 'select',
                'options'    => [
                    [
                        'title' => 'Pounds',
                        'value' => 'LB',
                    ], [
                        'title' => 'Kilograms',
                        'value' => 'KG',
                    ]
                ],
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'services',
                'title'         => 'ggphp-shipping::app.admin.system.services',
                'type'          => 'multiselect',
                'options'    => [
                    [
                        'title' => 'Europe First Priority',
                        'value' => 'EUROPE_FIRST_INTERNATIONAL_PRIORITY',
                    ], [
                        'title' => 'Priority Overnight',
                        'value' => 'PRIORITY_OVERNIGHT',
                    ], [
                        'title' => 'Standard Overnight',
                        'value' => 'STANDARD_OVERNIGHT',
                    ], [
                        'title' => '1 Day Freight',
                        'value' => 'FEDEX_1_DAY_FREIGHT',
                    ], [
                        'title' => '2 Day Freight',
                        'value' => 'FEDEX_2_DAY_FREIGHT',
                    ], [
                        'title' => '2 Day',
                        'value' => 'FEDEX_2_DAY',
                    ], [
                        'title' => '2 Day AM',
                        'value' => 'FEDEX_2_DAY_AM',
                    ], [
                        'title' => '3 Day Freight',
                        'value' => 'FEDEX_3_DAY_FREIGHT',
                    ], [
                        'title' => 'Express Saver',
                        'value' => 'FEDEX_EXPRESS_SAVER',
                    ], [
                        'title' => 'Ground',
                        'value' => 'FEDEX_GROUND',
                    ]
                ],
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'length_class',
                'title'         => 'ggphp-shipping::app.admin.system.length-class',
                'type'          => 'select',
                'options'    => [
                    [
                        'title' => 'Inches',
                        'value' => 'IN',
                    ], [
                        'title' => 'Centimeter',
                        'value' => 'CM',
                    ]
                ],
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => true,
            ]
        ]
    ]
];
