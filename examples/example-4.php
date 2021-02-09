<?php
require dirname( __DIR__ ) . '/vendor/autoload.php';

// example 4: Custom tags using add_parent_node() + add_node() with validation disabled.
$adf = ( new carmelosantana\SendADF\SendADF( 'WINDOWS-1250', '1.1' ) )
    ->validation( false )
    ->add_requestdate( '02/08/2021 10:41AM' )
    ->add_parent_node( 'cars', [
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
        ->add_node( 'odometer', 90000, [ 'status' => 'replaced', 'units' => 'miles'] ) 
        ->add_parent_node( 'COLORS', [
            'interiorcolor' => 'lush brown',
            'exteriorcolor' => 'emerald green',
            'preference' => '2'
        ], [], true )
    ->close_node()
    ->add_parent_node( 'person' )
        ->add_parent_node( 'contact' )
            ->add_node( 'Name', 'John', [ 'part' => 'first' ] )
            ->add_node( 'Name', 'Doe', [ 'part' => 'last' ] )
            ->add_node( 'Email_Address', 'jdoe@hotmail.com' )
            ->add_node( 'Cell', '393-999-3922', [ 'time' => 'morning' ] )
        ->close_node()
        ->add_parent_node( 'TimePlease', [ 'description' => 'Within 1 month' ], [], true )
        ->add_node( 'Words', 'Can you deliver my new car by next Thursday?' )
    ->close_node()
    ->add_parent_node( 'business' )
        ->add_node( 'businessname', 'Carmelo\'s Internet Outlet' )
        ->add_node( 'website', 'https://carmelosantana.com' )
        ->add_parent_node( 'talk_to_me' )
            ->add_node( 'my_name_is', 'Carmelo Santana', [ 'part' => 'full' ] )
            ->add_node( 'email', 'git@carmelosantana.com' )
            ->add_node( 'voice', '333-999-2222', [ 'when' => 'evening'] )
            ->add_node( 'fax', '393-991-2999', [ 'when' => 'evening'] )
            ->add_parent_node( 'where', null, [ 'type' => 'business' ] )
                ->add_node( 'street', '86 Broadway', [ 'line' => 1 ] )
                ->add_node( 'street', 'First Floor', [ 'line' => 2 ] )
                ->add_node( 'city', 'Newburgh' )
                ->add_node( 'state', 'NY' )
                ->add_node( 'zipcode', '12550-7638' )
                ->add_node( 'country', 'US' )
            ->close_node()
        ->close_node()
    ->close_node()
    ->add_parent_node( 'the_who' )
        ->add_node( 'name', 'CarPoint' )
        ->add_node( 'service', 'Used Car Classifieds' )
        ->add_node( 'url', 'http://carpoint.msn.com' )
        ->add_node( 'email', 'carcomm@carpoint.com' )
        ->add_node( 'phone', '425-555-1212' );
                
echo $adf->getPrettyPrintXML();
