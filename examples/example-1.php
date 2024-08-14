<?php
require dirname( __DIR__ ) . '/vendor/autoload.php';

// example 1: Minimal lead from ADF version 1.0.
$adf = ( new CarmeloSantana\SendAdf\SendAdf() )
    ->addProspect( '' )
    ->addRequestdate( '3/30/2000 3:30PM' )
    ->addVehicle( [
        'year' => 1999,
        'make' => 'Chevrolet',
        'model' => 'Blazer'
    ], '', '' )
    ->addCustomer()
        ->addContact()
            ->addName( 'John Doe', '', '' )
            ->addPhone( '393-999-3922', '', '' )
    ->addVendor()
        ->addContact()
            ->addName( 'Acura of Bellevue', '', '' );

echo $adf->getXml();
