<?php
declare(strict_types=1);

namespace carmelosantana\SendADF;

class Spec {
    private $email = [
        '@attributes' => [
            'preferredcontact'
        ]
    ];    

    private $id = [
        '@attributes' => [
            'source'
        ]
    ];

    private $name = [
        '@attributes' => [
            'part'
        ]
    ];

    private $phone = [
        '@attributes' => [
            'type'
        ]
    ];    

    private $contact = [
        '@attributes' => [
            'primarycontact'
        ],
        'name' => [
            '@attributes' => [
                'part'
            ]
        ],
        'email',
        'phone',
        'address' => [
            'street' => [
                '@attributes' => [
                    'line'
                ]
            ],
            'apartment',
            'city',
            'regioncode',
            'postalcode',
            'country',
        ]
    ];

    private $vehicle =  [
        '@attributes' => [
            'interest',
            'status'
        ],
        'id',
        'year',     // required
        'make',     // required
        'model',    // required
        'vin',
        'stock',
        'trim',
        'doors',
        'bodystyle',
        'transmission',
        'odometer',
        'condition' => [
            'excellent',
            'good',
            'fair',
            'poor',
            'unknown'
        ],
        'colorcombination' => [],
        'price',
        'pricecomments',
        'option' => [],
        'finance' => [],
        'comments'
    ];

    /**
	 * Initialize instance
	 *
	 * @return static
	 */
	public static function get()
	{
		return new static();
    }

    public function parameters( $node )
    {
        return $this->$node;
    }
 
    public function by_version( $format='adf', $version='1.0' )
    {
        switch ( $format ){
            default:
                if ( version_compare( $version, '1.0', '>=' ) ){
                    return [
                        'prospect' => [
                            'id',
                            'type',
                            'vehicle' => $this->vehicle,
                            'customer' => [
                                'contact' => $this->contact,
                            ],
                            'vendor' => [
                                'id' => $this->id,
                                'vendorname'
                            ],
                            'provider' => [
                                'id' => $this->id,
                                'name' => $this->name,
                                'service'
                            ]
                        ]
                    ];
                }            
            break;
        }
    }
}