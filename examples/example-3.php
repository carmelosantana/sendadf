<?php
require dirname( __DIR__ ) . '/vendor/autoload.php';

// example 3: Use add_parent_node() + add_node() to avoid default values.
$adf = ( new carmelosantana\SendADF\SendADF() )
    ->add_requestdate( '02/08/2021 10:41AM' )
    ->add_parent_node( 'vehicle', [
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
        ->add_node( 'odometer', 90000, [ 'status' => 'replaced', 'units' => 'miles'] ) 
        ->add_parent_node( 'colorcombination', [
            'interiorcolor' => 'lush brown',
            'exteriorcolor' => 'emerald green',
            'preference' => '2'
        ], [], true )
    ->close_node()
    ->add_parent_node( 'customer' )
        ->add_parent_node( 'contact' )
            ->add_node( 'name', 'John', [ 'part' => 'first' ] )
            ->add_node( 'name', 'Doe', [ 'part' => 'last' ] )
            ->add_node( 'email', 'jdoe@hotmail.com' )
            ->add_node( 'phone', '393-999-3922', [ 'type' => 'voice', 'time' => 'morning' ] )
        ->close_node()
        ->add_parent_node( 'timeframe', [ 'description' => 'Within 1 month' ], [], true )
        ->add_node( 'comments', 'Can you deliver my new car by next Thursday?' )
    ->close_node()
    ->add_parent_node( 'vendor' )
        ->add_node( 'vendorname', 'Carmelo\'s Internet Outlet' )
        ->add_node( 'url', 'https://carmelosantana.com' )
        ->add_parent_node( 'contact' )
            ->add_node( 'name', 'Carmelo Santana', [ 'part' => 'full' ] )
            ->add_node( 'email', 'git@carmelosantana.com' )
            ->add_node( 'phone', '333-999-2222', [ 'type' => 'voice', 'time' => 'evening'] )
            ->add_node( 'phone', '393-991-2999', [ 'type' => 'fax', 'time' => 'evening'] )
            ->add_parent_node( 'address', null, [ 'type' => 'business' ] )
                ->add_node( 'street', '86 Broadway', [ 'line' => 1 ] )
                ->add_node( 'street', 'First Floor', [ 'line' => 2 ] )
                ->add_node( 'city', 'Newburgh' )
                ->add_node( 'regioncode', 'NY' )
                ->add_node( 'postalcode', '12550-7638' )
                ->add_node( 'country', 'US' )
            ->close_node()
        ->close_node()
    ->close_node()
    ->add_parent_node( 'provider' )
        ->add_node( 'name', 'CarPoint' )
        ->add_node( 'service', 'Used Car Classifieds' )
        ->add_node( 'url', 'http://carpoint.msn.com' )
        ->add_node( 'email', 'carcomm@carpoint.com' )
        ->add_node( 'phone', '425-555-1212' );
                
echo $adf->getPrettyPrintXML();
