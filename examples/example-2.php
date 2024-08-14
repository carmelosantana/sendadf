<?php
require dirname( __DIR__ ) . '/vendor/autoload.php';

// example 2: Full lead from ADF version 1.0.
$adf = ( new CarmeloSantana\SendAdf\SendAdf() )
    ->addProspect( 'new' )
    ->addNode( 'requestdate', '2000-03-30T15:30:20-08:00' )
    ->addVehicle( [
        'year' => 1999,
        'make' => 'Chevrolet',
        'model' => 'Blazer',
        'vin' => '2GTEK19R7V1511644',
        'stock' => 'P7286',
        'trim' => 'LT',
        'doors' => 4,
        'bodystyle' => 'SUV',
        'transmission' => 'A',
    ], 'buy', 'used' )
        ->addNode( 'odometer', 90000, [ 'status' => 'replaced', 'units' => 'miles'] ) 
        ->addParentNode( 'colorcombination', [
            'interiorcolor' => 'lush brown',
            'exteriorcolor' => 'emerald green',
            'preference' => '2'
        ], [], true )
        ->addParentNode( 'colorcombination', [
            'interiorcolor' => 'gray',
            'exteriorcolor' => 'cobalt blue',
            'preference' => '1'
        ], [], true )
        ->addNode( 'price', 26995, [ 'type' => 'quote', 'currency' => 'USD'] ) 
        ->addParentNode( 'option', [
            'optionname' => 'Sport',
            'manufacturercode' => 'p394',
            'weighting' => '65'
        ], [], true )
        ->addParentNode( 'option', [
            'optionname' => 'Keyless Entry',
            'manufacturercode' => 'p395',
            'weighting' => '100'
        ], [], true )
        ->addParentNode( 'finance' )
            ->addNode( 'amount', 5000, [
                'type' => 'downpayment',
                'currency' => 'USD'
            ] )
            ->addNode( 'amount', 1000, [
                'type' => 'monthly',
                'currency' => 'USD'
            ] )
            ->addNode( 'amount', 50000, [
                'type' => 'total',
                'currency' => 'USD'
            ] )
            ->addNode( 'balance', 2000, [
                'type' => 'residual',
                'currency' => 'USD'
            ] )
        ->closeNode()
        ->addNode( 'comments', 'keyless entry essential' )
    ->addCustomer()
        ->addContact()
            ->addName( 'John', 'first' )
            ->addName( 'Doe', 'last' )
            ->addEmail( 'jdoe@hotmail.com' )
            ->addPhone( '393-999-3922', 'voice', 'morning' )
            ->addPhone( '393-991-2999', 'voice', 'evening', 1 )
            ->addPhone( '393-999-2999', 'fax', 'evening' )
            ->addAddress( 'home' )
                ->addNode( 'street', '10 first avenue', [ 'line' => 1 ] )
                ->addNode( 'apartment', 'G-17' )
                ->addNode( 'city', 'Spokane' )
                ->addNode( 'regioncode', 'WA' )
                ->addNode( 'postalcode', '98002-3903' )
                ->addNode( 'country', '98002-3903' )
            ->closeNode()
        ->closeNode()
        ->addParentNode( 'timeframe', [ 'description' => 'Within 1 month' ], [], true )
        ->addNode( 'comments', 'Can you deliver my new car by next Thursday?' )
    ->addVendor()
        ->addNode( 'vendorname', 'Carmelo\'s Internet Outlet' )
        ->addNode( 'url', 'https://carmelosantana.com' )
        ->addContact( 1 )
            ->addName( 'Carmelo Santana', 'full' )
            ->addEmail( 'git@carmelosantana.com' )
            ->addPhone( '333-999-2222', 'voice', 'evening' )
            ->addPhone( '393-991-2999', 'fax', 'evening' )
            ->addAddress( 'business' )
                ->addNode( 'street', '86 Broadway', [ 'line' => 1 ] )
                ->addNode( 'street', 'First Floor', [ 'line' => 2 ] )
                ->addNode( 'city', 'Newburgh' )
                ->addNode( 'regioncode', 'NY' )
                ->addNode( 'postalcode', '12550-7638' )
                ->addNode( 'country', 'US' )
    ->addProvider()        
        ->addNode( 'name', 'CarPoint' )
        ->addNode( 'service', 'Used Car Classifieds' )
        ->addNode( 'url', 'http://carpoint.msn.com' )
        ->addEmail( 'carcomm@carpoint.com' )
        ->addPhone( '425-555-1212' )
        ->addContact( 1 )
            ->addName( 'Fred Jones', 'full' )
            ->addEmail( 'support@carpoint.com' )
            ->addPhone( '425-253-2222', 'voice', 'day' )
            ->addPhone( '393-991-2999', 'fax', 'day' )
            ->addAddress()
                ->addNode( 'street', 'One Microsoft Way', [ 'line' => 1 ] )
                ->addNode( 'street', 'Building 8', [ 'line' => 2 ] )
                ->addNode( 'city', 'Redmond' )
                ->addNode( 'regioncode', 'WA' )
                ->addNode( 'postalcode', '98052' )
                ->addNode( 'country', 'US' );
                
echo $adf->getPrettyPrintXML();
