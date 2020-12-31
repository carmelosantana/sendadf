# 📬 SendADF

PHP library to build valid Auto-Lead Data Format ADF/XML leads.

**Supports:**

- ADF 1.0

**Features:**

- Multiple vehicles
- Data attributes
- Data entry via an associative `array`, `object`, or `JSON`

## Install

Include `SendADF` in your project with [Composer](https://getcomposer.org/):

```bash
$ composer require carmelosantana/sendadf
```

**Requirements:**

- [PHP](https://www.php.net/manual/en/install.php) 7.3 or above
- [Composer](https://getcomposer.org/)

## Usage

Start by creating an instance of `SendADF`. `SendADF` supports passing lead data individual line items.

---

Data for our examples:

```php
$vehicle1_json = '{
    "AirBagLocFront": "1st Row (Driver & Passenger)",
    "BedType": "Not Applicable",
    "BodyClass": "Convertible/Cabriolet",
    "BusType": "Not Applicable",
    "DisplacementCC": "8000",
    "DisplacementCI": "488.1899527578",
    "DisplacementL": "8",
    "Doors": "2",
    "EngineConfiguration": "V-Shaped",
    "EngineCylinders": "10",
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
    "PlantCity": "DETROIT",
    "PlantCompanyName": "Connor Avenue/ New Mack Assembly Plant",
    "PlantCountry": "UNITED STATES (USA)",
    "PlantState": "MICHIGAN",
    "SeatBeltsAll": "Automatic",
    "Series2": "Special",
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
```

---

Creating a valid ADF line by line using predefined keys.

```php
\carmelosantana\SendADF\SendADF::instance()
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
```

- `<requestdata>` defaults to current server time if not provided.
- `<vehicle>` fields are normalized before checking for acceptable fields. This allows for mixed case keys; `make` or `MAKE`.
- `set_*` methods set a single value one time
- `add_*` methods can be used multiple time

## Methods

| Name | Description |
|------|-------------|
|[__construct](#sendadf__construct)|Start XML object|
|[add](#sendadfadd)|Resets current working node to <prospect>.|
|[add_contact](#sendadfadd_contact)|Starts a <contact> node in current working node.|
|[add_customer](#sendadfadd_customer)|Add <customer> to <prospect> node.|
|[add_email](#sendadfadd_email)|Add <email> current working node.|
|[add_name](#sendadfadd_name)|Add <name> current working node.|
|[add_node](#sendadfadd_node)|Add a user defined <node>.|
|[add_parent_node](#sendadfadd_parent_node)|Add a user defined parent node to the current working node. This node becomes the new current working node.|
|[add_phone](#sendadfadd_phone)|Add <phone> current working node.|
|[add_provider](#sendadfadd_provider)|Add <provider> to <prospect> node.|
|[add_vehicle](#sendadfadd_vehicle)|Add a <vehicle> node to <prospect>.|
|[add_vendor](#sendadfadd_vendor)|Add <vendor> to <prospect> node.|
|[date](#sendadfdate)|ISO 8601 format date|
|[getPrettyPrintXML](#sendadfgetprettyprintxml)|Format XML and make it pretty!|
|[getXML](#sendadfgetxml)|Returns valid ADF/XML
- provides any necessary missing values|
|[instance](#sendadfinstance)|Initialize instance, start ADF document.|
|[is_json](#sendadfis_json)|Checks if string is JSON.|
|[prepare_data](#sendadfprepare_data)|Converts JSON or php object to an array|
|[set_requestdate](#sendadfset_requestdate)|Sets requestdate|



### SendADF::__construct  

**Description**

```php
public __construct (string $, string $)
```

Start XML object

**Parameters**

* `(string) $`
: Version of ADF  
* `(string) $`
: Format of XML  

**Return Values**

`void`

---

### SendADF::add  

**Description**

```php
public add (void)
```

Resets current working node to <prospect>.

**Parameters**

`This function has no parameters.`

**Return Values**

`object`

> This instance (current working document)

---

### SendADF::add_contact  

**Description**

```php
public add_contact (void)
```

Starts a <contact> node in current working node.

**Parameters**

`This function has no parameters.`

**Return Values**

`object`

> This instance (current working document)

---

### SendADF::add_customer  

**Description**

```php
public add_customer (void)
```

Add <customer> to <prospect> node.

**Parameters**

`This function has no parameters.`

**Return Values**

`object`

> This instance (current working document)

---

### SendADF::add_email  

**Description**

```php
public add_email (string $, int $)
```

Add <email> current working node.

**Parameters**

* `(string) $`
: Email address of contact  
* `(int) $`
: Set prefferedcontact=”1” to indicate this as the preferred method of contact (attribute)  

**Return Values**

`object`

> This instance (current working document)

---

### SendADF::add_name  

**Description**

```php
public add_name (string $, string $, string $)
```

Add <name> current working node.

**Parameters**

* `(string) $`
: Name of contact  
* `(string) $`
: Part of name (attribute)  
* `(string) $`
: Type individual|business (attribute)  

**Return Values**

`object`

> This instance (current working document)

---

### SendADF::add_node  

**Description**

```php
public add_node (string $, string $, array $)
```

Add a user defined <node>.

**Parameters**

* `(string) $`
: Name of node  
* `(string) $`
: Data value for node  
* `(array) $`
: Attributes array [ attribute_key => attribute_value ]  

**Return Values**

`object`

> This instance (current working document)

---

### SendADF::add_parent_node  

**Description**

```php
public add_parent_node (string $, array $)
```

Add a user defined parent node to the current working node. This node becomes the new current working node.

**Parameters**

* `(string) $`
: Name of new parent node  
* `(array) $`
: Attributes array [ attribute_key => attribute_value ]  

**Return Values**

`object`

> This instance (current working document)

---

### SendADF::add_phone  

**Description**

```php
public add_phone (string $, string $, string $, int $)
```

Add <phone> current working node.

**Parameters**

* `(string) $`
: Phone number of contact  
* `(string) $`
: Type attribute (phone|fax|cellphone|pager)  
* `(string) $`
: Time parameter indicates that this entry is the preferred contact number.  
* `(int) $`
: Preferred contact attribute. Set prefferedcontact=”1” to indicate this as the preferred method of contact. (0|1)  

**Return Values**

`object`

> This instance (current working document)

---

### SendADF::add_provider  

**Description**

```php
public add_provider (void)
```

Add <provider> to <prospect> node.

**Parameters**

`This function has no parameters.`

**Return Values**

`object`

> This instance (current working document)

---

### SendADF::add_vehicle  

**Description**

```php
public add_vehicle (array $, string $, string $)
```

Add a <vehicle> node to <prospect>.

**Parameters**

* `(array) $`
: Data associative array of vehicle data  
* `(string) $`
: Interest attribute (buy|sell)  
* `(string) $`
: Status attribute (new|used)  

**Return Values**

`object`

> This instance (current working document)

---

### SendADF::add_vendor  

**Description**

```php
public add_vendor (void)
```

Add <vendor> to <prospect> node.

**Parameters**

`This function has no parameters.`

**Return Values**

`object`

> This instance (current working document)

---

### SendADF::date  

**Description**

```php
public static date (void)
```

ISO 8601 format date

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> Formatted date

---

### SendADF::getPrettyPrintXML  

**Description**

```php
public getPrettyPrintXML (void)
```

Format XML and make it pretty!

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> Human readable XML

---

### SendADF::getXML  

**Description**

```php
public getXML (void)
```

Returns valid ADF/XML
- provides any necessary missing values

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> ADF/XML

---

### SendADF::instance  

**Description**

```php
public static instance (void)
```

Initialize instance, start ADF document.

**Parameters**

`This function has no parameters.`

**Return Values**

`object`



---

### SendADF::is_json  

**Description**

```php
public static is_json (mixed $)
```

Checks if string is JSON. 

- https://stackoverflow.com/a/6041773/1007492 License CC BY-SA 3.0 

**Parameters**

* `(mixed) $`
: Data to check  

**Return Values**

`bool`

> Is this JSON?

---

### SendADF::prepare_data  

**Description**

```php
public static prepare_data (mixed $)
```

Converts JSON or php object to an array

**Parameters**

* `(mixed) $`
: Data input  

**Return Values**

`mixed`

> Prepared data for adding to

---

### SendADF::set_requestdate  

**Description**

```php
public set_requestdate (mixed $)
```

Sets requestdate

**Parameters**

* `(mixed) $`
: Time argument can be unix time stamp or date as a string.  

**Return Values**

`object`

> This instance (current working document)

## Roadmap

- [ ] `mail()` support
- [ ] `CDATA` support
- [ ] Add validation with DTD

## Support

Pull requests are welcomed for bug fixes.

⭐ Need help implementing or extending functionality with additional fields? [Contact](https://github.com/carmelosantana/) to discuss options.

## License

The code is licensed [MIT](https://opensource.org/licenses/MIT) and the documentation is licensed [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/).
