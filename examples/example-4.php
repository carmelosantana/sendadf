<?php
require dirname( __DIR__ ) . '/vendor/autoload.php';

// example 4: Custom tags using addParentNode() + addNode() with validation disabled.
$adf = ( new CarmeloSantana\SendAdf\SendAdf( 'WINDOWS-1250', '1.1' ) )
    ->validation( false )
    ->addRequestdate( '02/08/2021 10:41AM' )
    ->addParentNode( 'cars', [
        'Year' => 1999,
        'Make' => 'Chevrolet',
        'Model' => 'Blazer',
        'VIN' => '2GTEK19R7V1511644',
        'Stock' => 'P7286',
        'Trim' => 'LT',
        'Doors' => 4,
        'Body' => 'SUV',
        'Transmission' => 'A',
    ], [ 'i_want_to' => 'buy', 'status' => 'used', 'this' => 'not in spec' ] )
        ->addNode( 'odometer', 90000, [ 'status' => 'replaced', 'units' => 'miles'] ) 
        ->addParentNode( 'COLORS', [
            'interiorcolor' => 'lush brown',
            'exteriorcolor' => 'emerald green',
            'preference' => '2'
        ], [], true )
    ->closeNode()
    ->addParentNode( 'person' )
        ->addParentNode( 'contact' )
            ->addNode( 'Name', 'John', [ 'part' => 'first' ] )
            ->addNode( 'Name', 'Doe', [ 'part' => 'last' ] )
            ->addNode( 'Email_Address', 'jdoe@hotmail.com' )
            ->addNode( 'Cell', '393-999-3922', [ 'time' => 'morning' ] )
        ->closeNode()
        ->addParentNode( 'TimePlease', [ 'description' => 'Within 1 month' ], [], true )
        ->addNode( 'Words', 'Can you deliver my new car by next Thursday?' )
    ->closeNode()
    ->addParentNode( 'business' )
        ->addNode( 'businessname', 'Carmelo\'s Internet Outlet' )
        ->addNode( 'website', 'https://carmelosantana.com' )
        ->addParentNode( 'talk_to_me' )
            ->addNode( 'my_name_is', 'Carmelo Santana', [ 'part' => 'full' ] )
            ->addNode( 'email', 'git@carmelosantana.com' )
            ->addNode( 'voice', '333-999-2222', [ 'when' => 'evening'] )
            ->addNode( 'fax', '393-991-2999', [ 'when' => 'evening'] )
            ->addParentNode( 'where', null, [ 'type' => 'business' ] )
                ->addNode( 'street', '86 Broadway', [ 'line' => 1 ] )
                ->addNode( 'street', 'First Floor', [ 'line' => 2 ] )
                ->addNode( 'city', 'Newburgh' )
                ->addNode( 'state', 'NY' )
                ->addNode( 'zipcode', '12550-7638' )
                ->addNode( 'country', 'US' )
            ->closeNode()
        ->closeNode()
    ->closeNode()
    ->addParentNode( 'the_who' )
        ->addNode( 'name', 'CarPoint' )
        ->addNode( 'service', 'Used Car Classifieds' )
        ->addNode( 'url', 'http://carpoint.msn.com' )
        ->addNode( 'email', 'carcomm@carpoint.com' )
        ->addNode( 'phone', '425-555-1212' );
                
echo $adf->getPrettyPrintXML();
