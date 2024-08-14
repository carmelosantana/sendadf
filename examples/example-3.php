<?php
require dirname( __DIR__ ) . '/vendor/autoload.php';

// example 3: Use addParentNode() + addNode() to avoid default values.
$adf = ( new CarmeloSantana\SendAdf\SendAdf() )
    ->addRequestdate( '02/08/2021 10:41AM' )
    ->addParentNode( 'vehicle', [
        'year' => 1999,
        'make' => 'Chevrolet',
        'model' => 'Blazer',
        'vin' => '2GTEK19R7V1511644',
        'stock' => 'P7286',
        'trim' => 'LT',
        'doors' => 4,
        'bodystyle' => 'SUV',
        'transmission' => 'A',
    ], [ 'interest' => 'buy', 'status' => 'used', 'this' => 'not in spec' ] )
        ->addNode( 'odometer', 90000, [ 'status' => 'replaced', 'units' => 'miles'] ) 
        ->addParentNode( 'colorcombination', [
            'interiorcolor' => 'lush brown',
            'exteriorcolor' => 'emerald green',
            'preference' => '2'
        ], [], true )
    ->closeNode()
    ->addParentNode( 'customer' )
        ->addParentNode( 'contact' )
            ->addNode( 'name', 'John', [ 'part' => 'first' ] )
            ->addNode( 'name', 'Doe', [ 'part' => 'last' ] )
            ->addNode( 'email', 'jdoe@hotmail.com' )
            ->addNode( 'phone', '393-999-3922', [ 'type' => 'voice', 'time' => 'morning' ] )
        ->closeNode()
        ->addParentNode( 'timeframe', [ 'description' => 'Within 1 month' ], [], true )
        ->addNode( 'comments', 'Can you deliver my new car by next Thursday?' )
    ->closeNode()
    ->addParentNode( 'vendor' )
        ->addNode( 'vendorname', 'Carmelo\'s Internet Outlet' )
        ->addNode( 'url', 'https://carmelosantana.com' )
        ->addParentNode( 'contact' )
            ->addNode( 'name', 'Carmelo Santana', [ 'part' => 'full' ] )
            ->addNode( 'email', 'git@carmelosantana.com' )
            ->addNode( 'phone', '333-999-2222', [ 'type' => 'voice', 'time' => 'evening'] )
            ->addNode( 'phone', '393-991-2999', [ 'type' => 'fax', 'time' => 'evening'] )
            ->addParentNode( 'address', null, [ 'type' => 'business' ] )
                ->addNode( 'street', '86 Broadway', [ 'line' => 1 ] )
                ->addNode( 'street', 'First Floor', [ 'line' => 2 ] )
                ->addNode( 'city', 'Newburgh' )
                ->addNode( 'regioncode', 'NY' )
                ->addNode( 'postalcode', '12550-7638' )
                ->addNode( 'country', 'US' )
            ->closeNode()
        ->closeNode()
    ->closeNode()
    ->addParentNode( 'provider' )
        ->addNode( 'name', 'CarPoint' )
        ->addNode( 'service', 'Used Car Classifieds' )
        ->addNode( 'url', 'http://carpoint.msn.com' )
        ->addNode( 'email', 'carcomm@carpoint.com' )
        ->addNode( 'phone', '425-555-1212' );
                
echo $adf->getPrettyPrintXML();
