<?php
require dirname( __DIR__ ) . '/vendor/autoload.php';

$customer_name = 'John Doe';

$vehicle1_json = '{
    "AirBagLocFront": "1st Row (Driver & Passenger)",
    "BedType": "Not Applicable",
    "BodyCabType": "Not Applicable",
    "BodyClass": "Convertible/Cabriolet",
    "BusFloorConfigType": "Not Applicable",
    "BusType": "Not Applicable",
    "CustomMotorcycleType": "Not Applicable",
    "DisplacementCC": "8000",
    "DisplacementCI": "488.1899527578",
    "DisplacementL": "8",
    "Doors": "2",
    "EngineConfiguration": "V-Shaped",
    "EngineCylinders": "10",
    "ErrorCode": "0",
    "ErrorText": "0 - VIN decoded clean. Check Digit (9th position) is correct",
    "FuelInjectionType": "Sequential Fuel Injection (SFI)",
    "FuelTypePrimary": "Gasoline",
    "Make": "DODGE",
    "MakeID": "476",
    "Manufacturer": "FCA US LLC",
    "ManufacturerId": "994",
    "Model": "Viper",
    "ModelID": "1897",
    "ModelYear": "1995",
    "MotorcycleChassisType": "Not Applicable",
    "MotorcycleSuspensionType": "Not Applicable",
    "Note": "Body Style: Open Body",
    "OtherEngineInfo": "Sales Code: EWB",
    "PlantCity": "DETROIT",
    "PlantCompanyName": "Connor Avenue/ New Mack Assembly Plant",
    "PlantCountry": "UNITED STATES (USA)",
    "PlantState": "MICHIGAN",
    "SeatBeltsAll": "Automatic",
    "Series2": "Special",
    "TrailerBodyType": "Not Applicable",
    "TrailerType": "Not Applicable",
    "Trim": "RT/10",
    "VIN": "1B3BR65EXSV201546",
    "VehicleType": "PASSENGER CAR"
}';

$vehicle2_array = [
    'vin' => "JN1AR5EF9LM100439",
    'make' => "NISSAN",
    'model' => "GT-R",
    'year' => 2020,
];

$vehicle3_json = '{
    "VIN": "JN1AR5EF9LM100439",
    "Make": "NISSAN",
    "Model": "GT-R",
    "Year": "2019"
}';

$date = 'Wed, 25 Sep 2013 15:28:57 -0700';

// example 1
$test = carmelosantana\SendADF\SendADF::instance()
    ->set_requestdate( $date )
    ->add_vehicle( $vehicle1_json, 'buy', 'used' )
    ->add_vehicle( $vehicle2_array, 'buy', 'new' )
    ->add_vehicle( $vehicle3_json, 'sell', 'used' )
    ->add_customer()
        ->add_contact()
            ->add_name( 'John', 'first' )
            ->add_name( 'Doe', 'last' )
            ->add_email( 'jdoe@hotmail.com' )
            ->add_phone( '393-999-3922', 'voice', 'morning' )
    ->add_vendor()
        ->add_node( 'vendorname', 'Hudson Valley Internet Outlet' )
        ->add_contact()
            ->add_name( 'Jane Smith', 'full' )
            ->add_email( 'jsmith@aol.com' )    
    ->add_provider()
        ->add_node( 'name', 'CarPoint', [ 'part' => 'full' ] )
        ->add_node( 'service', 'Used Car Classifieds' )
        ->add_node( 'url', 'http://carpoint.msn.com' )
        ->add_node( 'email', 'carcomm@carpoint.com' )
        ->add_node( 'phone', '425-555-1212' )
            ->add_contact()
                ->add_node( 'name', 'Fred Jones', [ 'part' => 'full' ] )
                ->add_node( 'email', 'support@carpoint.com' )
                ->add_node( 'phone', '425-253-2222', [ 'type' => 'voice', 'time' => 'day' ] )
                ->add_node( 'phone', '393-991-2999', [ 'type' => 'fax', 'time' => 'day' ] );

echo $test->getPrettyPrintXML();

// example 2
echo carmelosantana\SendADF\SendADF::instance()
    ->set_requestdate( $date )
    ->add_vehicle( $vehicle1_json, 'buy', 'used' )
    ->add_vehicle( $vehicle2_array, 'buy', 'new' )
    ->add_customer()
        ->add_contact()
            ->add_name( 'John', 'first' )
            ->add_name( 'Doe', 'last' )
            ->add_email( 'jdoe@hotmail.com' )
            ->add_phone( '393-999-3922', 'voice', 'morning' )
    ->add_vendor()
        ->add_node( 'vendorname', 'Hudson Valley Automotive' )
        ->add_contact()
            ->add_name( 'Jane Smith', 'full' )
            ->add_email( 'jsmith@aol.com' )    
    ->add_provider()
        ->add_contact()
            ->add_name( 'Carmelo Santana', 'full' )
            ->add_email( 'provider', 'git@carmelosantana.com' )
            ->add_phone( '425-555-1212' )
    ->getXML();