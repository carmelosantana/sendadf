<?php
require dirname( __DIR__ ) . '/vendor/autoload.php';

// example 5: Populating fields with arrays and objects. 
$vehicle1_array = [
    'year' => 1999,
    'make' => 'Chevrolet',
    'model' => 'Blazer'
];

$vehicle2_json = '{
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

$vehicle3_object = (object) [
    'vin' => "JN1AR5EF9LM100439",
    'make' => "NISSAN",
    'model' => "GT-R",
    'year' => 2020
];

$customer = [
    'name' => 'John Doe',
    'email' => 'jdoe@hotmail.com',
    'phone' => '393-999-3922'
];

$vendor = (object) [
    'name' => 'Jane Smith',
    'email' => 'jsmith@aol.com'
];

$provider = '{
    "name": "Carmelo Santana",
    "email": "git@carmelosantana.com",
    "phone": "425-555-1212"
}';

$date = 'Wed, 25 Sep 2013 15:28:57 -0700';

echo ( new carmelosantana\SendADF\SendADF() )
    ->add_requestdate( $date )
    ->add_vehicle( $vehicle1_array, 'trade-in', 'used' )
    ->add_vehicle( $vehicle2_json, 'buy', 'used' )
    ->add_vehicle( $vehicle3_object, 'lease', 'new' )
    ->add_customer()
        ->add_parent_node( 'contact', $customer, [], true)
    ->add_vendor()
        ->add_node( 'vendorname', 'Hudson Valley Automotive' )
        ->add_parent_node( 'contact', $vendor, [], true)
    ->add_provider()
        ->add_parent_node( 'contact', $provider, [], true)
    ->getPrettyPrintXML();
    