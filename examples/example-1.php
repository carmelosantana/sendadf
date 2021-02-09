<?php
require dirname( __DIR__ ) . '/vendor/autoload.php';

// example 1: Minimal lead from ADF version 1.0.
$adf = ( new carmelosantana\SendADF\SendADF() )
    ->add_prospect( '' )
    ->add_requestdate( '3/30/2000 3:30PM' )
    ->add_vehicle( [
        'year' => 1999,
        'make' => 'Chevrolet',
        'model' => 'Blazer'
    ], '', '' )
    ->add_customer()
        ->add_contact()
            ->add_name( 'John Doe', '', '' )
            ->add_phone( '393-999-3922', '', '' )
    ->add_vendor()
        ->add_contact()
            ->add_name( 'Acura of Bellevue', '', '' );

echo $adf->getXML();
