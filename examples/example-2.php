<?php
require dirname( __DIR__ ) . '/vendor/autoload.php';

// example 2: Full lead from ADF version 1.0.
$adf = ( new CarmeloSantana\SendAdf\SendAdf() )
    ->add_prospect( 'new' )
    ->add_node( 'requestdate', '2000-03-30T15:30:20-08:00' )
    ->add_vehicle( [
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
        ->add_node( 'odometer', 90000, [ 'status' => 'replaced', 'units' => 'miles'] ) 
        ->add_parent_node( 'colorcombination', [
            'interiorcolor' => 'lush brown',
            'exteriorcolor' => 'emerald green',
            'preference' => '2'
        ], [], true )
        ->add_parent_node( 'colorcombination', [
            'interiorcolor' => 'gray',
            'exteriorcolor' => 'cobalt blue',
            'preference' => '1'
        ], [], true )
        ->add_node( 'price', 26995, [ 'type' => 'quote', 'currency' => 'USD'] ) 
        ->add_parent_node( 'option', [
            'optionname' => 'Sport',
            'manufacturercode' => 'p394',
            'weighting' => '65'
        ], [], true )
        ->add_parent_node( 'option', [
            'optionname' => 'Keyless Entry',
            'manufacturercode' => 'p395',
            'weighting' => '100'
        ], [], true )
        ->add_parent_node( 'finance' )
            ->add_node( 'amount', 5000, [
                'type' => 'downpayment',
                'currency' => 'USD'
            ] )
            ->add_node( 'amount', 1000, [
                'type' => 'monthly',
                'currency' => 'USD'
            ] )
            ->add_node( 'amount', 50000, [
                'type' => 'total',
                'currency' => 'USD'
            ] )
            ->add_node( 'balance', 2000, [
                'type' => 'residual',
                'currency' => 'USD'
            ] )
        ->close_node()
        ->add_node( 'comments', 'keyless entry essential' )
    ->add_customer()
        ->add_contact()
            ->add_name( 'John', 'first' )
            ->add_name( 'Doe', 'last' )
            ->add_email( 'jdoe@hotmail.com' )
            ->add_phone( '393-999-3922', 'voice', 'morning' )
            ->add_phone( '393-991-2999', 'voice', 'evening', 1 )
            ->add_phone( '393-999-2999', 'fax', 'evening' )
            ->add_address( 'home' )
                ->add_node( 'street', '10 first avenue', [ 'line' => 1 ] )
                ->add_node( 'apartment', 'G-17' )
                ->add_node( 'city', 'Spokane' )
                ->add_node( 'regioncode', 'WA' )
                ->add_node( 'postalcode', '98002-3903' )
                ->add_node( 'country', '98002-3903' )
            ->close_node()
        ->close_node()
        ->add_parent_node( 'timeframe', [ 'description' => 'Within 1 month' ], [], true )
        ->add_node( 'comments', 'Can you deliver my new car by next Thursday?' )
    ->add_vendor()
        ->add_node( 'vendorname', 'Carmelo\'s Internet Outlet' )
        ->add_node( 'url', 'https://carmelosantana.com' )
        ->add_contact( 1 )
            ->add_name( 'Carmelo Santana', 'full' )
            ->add_email( 'git@carmelosantana.com' )
            ->add_phone( '333-999-2222', 'voice', 'evening' )
            ->add_phone( '393-991-2999', 'fax', 'evening' )
            ->add_address( 'business' )
                ->add_node( 'street', '86 Broadway', [ 'line' => 1 ] )
                ->add_node( 'street', 'First Floor', [ 'line' => 2 ] )
                ->add_node( 'city', 'Newburgh' )
                ->add_node( 'regioncode', 'NY' )
                ->add_node( 'postalcode', '12550-7638' )
                ->add_node( 'country', 'US' )
    ->add_provider()        
        ->add_node( 'name', 'CarPoint' )
        ->add_node( 'service', 'Used Car Classifieds' )
        ->add_node( 'url', 'http://carpoint.msn.com' )
        ->add_email( 'carcomm@carpoint.com' )
        ->add_phone( '425-555-1212' )
        ->add_contact( 1 )
            ->add_name( 'Fred Jones', 'full' )
            ->add_email( 'support@carpoint.com' )
            ->add_phone( '425-253-2222', 'voice', 'day' )
            ->add_phone( '393-991-2999', 'fax', 'day' )
            ->add_address()
                ->add_node( 'street', 'One Microsoft Way', [ 'line' => 1 ] )
                ->add_node( 'street', 'Building 8', [ 'line' => 2 ] )
                ->add_node( 'city', 'Redmond' )
                ->add_node( 'regioncode', 'WA' )
                ->add_node( 'postalcode', '98052' )
                ->add_node( 'country', 'US' );
                
echo $adf->getPrettyPrintXML();
