<?php
declare(strict_types=1);

namespace CarmeloSantana\SendAdf;

class Spec {
    /** @var array ADF */
    private $adf = [
        'prospect'    
    ];

    /** @var array Prospect */
    private $prospect = [
        '@attributes' => [
            'status' => [
                'new',
                'resend'
            ]
        ],        
        'id',
        'requestdate',
        'vehicle',
        'customer',
        'vendor',
        'provider',
    ];

    /** @var array Vehicle */
    private $vehicle =  [
        '@attributes' => [
            'interest' => [
                'buy',
                'lease',
                'sell',
                'trade-in',
                'test-drive',
            ],
            'status' => [
                'new',
                'used'
            ]
        ],
        'id',
        'year',
        'make',
        'model',
        'vin',
        'stock',
        'trim',
        'doors',
        'bodystyle',
        'transmission',
        'condition',
        'price',
        'pricecomments',
        'comments',
        // attlist + elements
        'odometer',
        'colorcombination',
        'imagetag',
        'option',
        'finance',
    ];

    private $odometer = [
        '@attributes' => [
            'status' => [
                'unknown',
                'rolledover',
                'replaced',
                'original'
            ],
            'units' => [
                'km',
                'mi'
            ]
        ]
    ];
    
    private $colorcombination = [
        'interiorcolor',
        'exteriorcolor',
        'preference'
    ];

    private $imagetag = [
        '@attributes' => [
            'width',
            'height',
            'alttext'
        ]
    ];

    private $option = [
        'optionname',
        'manufacturercode',
        'stock',
        'weighting',
        'price'
    ];

    /** @var array Finance */
    private $finance = [
        'method',
        'amount',
        'balance'
    ];

    private $amount = [
        '@attributes' => [
            'type' => [
                'downpayment',
                'monthly',
                'total'
            ],
            'limit' => [
                'maximum',
                'minimum',
                'exact'
            ],
            'currency'
        ]
    ];

    private $balance = [
        '@attributes' => [
            'type' => [
                'finance',
                'residual'
            ],
            'currency'
        ]
    ];

    /** @var array Customer */
    private $customer = [
        'contact',
        'id',
        'timeframe',
        'comments'
    ];

    private $timeframe = [
        'description',
        'earliestdate',
        'latestdate',
    ];

    /** @var array Vendor */
    private $vendor = [
        'id',
        'vendorname',
        'url',
        'contact'
    ];

    /** @var array Provider */
    private $provider = [
        'id',
        'name',
        'service',
        'url',
        'email',
        'phone',
        'contact'
    ];    

    /** @var array Contact */
    private $contact = [
        '@attributes' => [
            'primarycontact' => [
                1,
                0
            ]
        ],
        'name',
        'email',
        'phone',
        'address'
    ];

    private $name = [
        '@attributes' => [
            'part' => [
                'first',
                'middle',
                'suffix',
                'last',
                'full'
            ],
            'type' => [
                'individual',
                'business'
            ]
        ]
    ];

    private $phone = [
        '@attributes' => [
            'type' => [
                'phone', // not in DTD but in documentation
                'voice',
                'fax',
                'cellphone',
                'pager'
            ],
            'time' => [
                'morning',
                'afternoon',
                'evening',
                'nopreference',
                'day'
            ],
            'preferredcontact' => [
                0,
                1
            ]
        ]
    ];    

    private $email = [
        '@attributes' => [
            'preferredcontact' => [
                0,
                1
            ]
        ]
    ];    

    private $address = [
        '@attributes' => [
            'type' => [
                'work',
                'home',
                'delivery'
            ]
        ],        
        'street',
        'apartment',
        'city',
        'regioncode',
        'postalcode',
        'country',
    ];

    private $street = [
        '@attributes' => [
            'line' => [
                1,
                2,
                3,
                4,
                5
            ]
        ]
    ];

    /** @var array Price */
    private $price = [
        '@attributes' => [
            'type' => [
                'quote',
                'offer',
                'msrp',
                'invoice',
                'call',
                'appraisal',
                'asking'
            ],
            'currency',
            'delta' => [
                'absolute',
                'relative',
                'percentage'
            ],
            'relativeto' => [
                'msrp',
                'invoice'
            ],
            'source'
        ]        
    ];

    /** @var array Shared */
    private $id = [
        '@attributes' => [
            'sequence',
            'source'
        ]
    ];

    private $comments = [];

    private $stock = [];

    private $url = [];

    /**
     * Checks if XML element is part of specification.
     *
     * @param string $node XML element
     * @return void
     */
    public function element( $node ): array
    {
        if ( isset($this->$node) )
            return $this->$node;
    }

    /**
	 * Initialize instance
	 *
	 * @return static
	 */
	public static function get()
	{
		return new static();
    }
}
