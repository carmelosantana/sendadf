# ![SendADF](https://sendadf.org/wp-content/uploads/2021/01/SendADF-logo.png)

PHP library that builds valid Auto-Lead Data Format ADF/XML leads.

**Supports**

- [ADF 1.0](https://github.com/carmelosantana/sendadf/blob/main/docs/adf-1.0.dtd)

**Features**

- Complete ADF implementation
- Validate tags and attributes *(optional)*
- Custom tags and attributes
- Data entry via an associative `array`, `object`, or `JSON`
- Attempts date conversion to [ISO 8601:1988](https://en.wikipedia.org/wiki/ISO_8601)
- Default attributes for `name`, `phone`, `prospect`, and `vehicle`

---

- [SendADF](#)
  - [Install](#install)
  - [Usage](#usage)
    - [Basic lead](#basic-lead)
    - [Output](#output)
    - [Default values](#default-values)
  - [Examples](#examples)
  - [Methods](#methods)
    - [SendADF::__construct](#sendadf__construct)
    - [SendADF::add_address](#sendadfadd_address)
    - [SendADF::add_contact](#sendadfadd_contact)
    - [SendADF::add_customer](#sendadfadd_customer)
    - [SendADF::add_email](#sendadfadd_email)
    - [SendADF::add_name](#sendadfadd_name)
    - [SendADF::add_node](#sendadfadd_node)
    - [SendADF::add_parent_node](#sendadfadd_parent_node)
    - [SendADF::add_phone](#sendadfadd_phone)
    - [SendADF::add_prospect](#sendadfadd_prospect)
    - [SendADF::add_provider](#sendadfadd_provider)
    - [SendADF::add_requestdate](#sendadfadd_requestdate)
    - [SendADF::add_vehicle](#sendadfadd_vehicle)
    - [SendADF::add_vendor](#sendadfadd_vendor)
    - [SendADF::close_node](#sendadfclose_node)
    - [SendADF::date](#sendadfdate)
    - [SendADF::getPrettyPrintXML](#sendadfgetprettyprintxml)
    - [SendADF::getXML](#sendadfgetxml)
    - [SendADF::is_json](#sendadfis_json)
    - [SendADF::prepare_data](#sendadfprepare_data)
    - [SendADF::validate_attribute](#sendadfvalidate_attribute)
    - [SendADF::validate_element](#sendadfvalidate_element)
    - [SendADF::validation](#sendadfvalidation)
    - [SendADF::version](#sendadfversion)
  - [Support](#support)
  - [Funding](#funding)
  - [License](#license)

---

## Install

Include SendADF in your project with [Composer](https://getcomposer.org/):

```bash
$ composer require carmelosantana/sendadf
```

**Requirements:**

- [PHP](https://www.php.net/manual/en/install.php) 7.3 or above
- [Composer](https://getcomposer.org/)

## Usage

### Basic lead

This [example](https://github.com/carmelosantana/sendadf/blob/main/examples/example-1.php) lead represents the minimum data required to comply with ADF specifications.

```php
$adf = ( new carmelosantana\SendADF\SendADF() )
    ->add_prospect( 'new' )
    ->add_requestdate( '2/9/2020 6:26PM' )
    ->add_vehicle( [
        'year' => 1999,
        'make' => 'Chevrolet',
        'model' => 'Blazer'
    ], 'buy', 'used' )
    ->add_customer()
        ->add_contact()
            ->add_name( 'John Doe' )
            ->add_phone( '393-999-3922' )
    ->add_vendor()
        ->add_contact()
            ->add_name( 'Acura of Bellevue' );
```

### Output

Basic output with no tabs:

```php
echo $adf->getXML();
```

```xml
<?xml version="1.0" encoding="UTF-8"?>
<?adf version="1.0"?>
<adf><prospect status="new"><requestdate>2020-02-09T18:26:00-05:00</requestdate><vehicle interest="buy" status="used"><year>1999</year><make>Chevrolet</make><model>Blazer</model></vehicle><customer><contact><name part="full" type="individual">John Doe</name><phone type="voice" time="nopreference">393-999-3922</phone></contact></customer><vendor><contact><name part="full" type="individual">Acura of Bellevue</name></contact></vendor></prospect></adf>
```

With tabs:

```php
echo $adf->getPrettyPrintXML();
```

```xml
<?xml version="1.0" encoding="UTF-8"?>
<?adf version="1.0"?>
<adf>
  <prospect status="new">
    <requestdate>2020-02-09T18:26:00-05:00</requestdate>
    <vehicle interest="buy" status="used">
      <year>1999</year>
      <make>Chevrolet</make>
      <model>Blazer</model>
    </vehicle>
    <customer>
      <contact>
        <name part="full" type="individual">John Doe</name>
        <phone type="voice" time="nopreference">393-999-3922</phone>
      </contact>
    </customer>
    <vendor>
      <contact>
        <name part="full" type="individual">Acura of Bellevue</name>
      </contact>
    </vendor>
  </prospect>
</adf>
```

### Default values

Default attribute values are added if none are supplied. This is to adhere to the ADF standard.

```php
$adf = ( new carmelosantana\SendADF\SendADF() )
    ->add_requestdate()
    ->add_vehicle( [
        'year' => 2020,
        'make' => 'Chevrolet',
        'model' => 'Blazer'
    ] )
    ->add_customer()
        ->add_contact()
            ->add_name( 'John Doe' )
            ->add_phone( '393-999-3922' );

echo $adf->getPrettyPrintXML();
```

```xml
<?xml version="1.0" encoding="UTF-8"?>
<?adf version="1.0"?>
<adf>
  <prospect status="new">
    <requestdate>2021-02-09T19:32:16-05:00</requestdate>
    <vehicle interest="buy" status="new">
      <year>1999</year>
      <make>Chevrolet</make>
      <model>Blazer</model>
    </vehicle>
    <customer>
      <contact>
        <name part="full" type="individual">John Doe</name>
        <phone type="voice" time="nopreference">393-999-3922</phone>
      </contact>
    </customer>
  </prospect>
</adf>
```

- `prospect` tag is opened with status new without calling `add_prospect`.
- `add_requestdate` current server time is used as the default for `requestdate` when none is provided.
- `name` part and type are provided.
- `phone` type and time are provided.

Default values can be avoided by using `add_parent_node` and `add_node` as seen in [example 3](https://github.com/carmelosantana/sendadf/blob/main/examples/example-3.php).

Sending empty values as shown in [example 1](https://github.com/carmelosantana/sendadf/blob/main/examples/example-1.php) can disable these attributes as well.

## Examples

[Example 1](https://github.com/carmelosantana/sendadf/blob/main/examples/example-1.php)

- Bare minimum to get started

[Example 2](https://github.com/carmelosantana/sendadf/blob/main/examples/example-2.php)

- Full document with all elements and attribute examples

[Example 3](https://github.com/carmelosantana/sendadf/blob/main/examples/example-3.php)

- Avoid default values
- Manually open and close nodes

[Example 4](https://github.com/carmelosantana/sendadf/blob/main/examples/example-4.php)

- Disable validation
- Custom tags and attributes

[Example 5](https://github.com/carmelosantana/sendadf/blob/main/examples/example-5.php)

- Data entry via `arrays`, `objects` and `JSON`

## Methods

| Name                                             | Description                                                                                          |
| ------------------------------------------------ | ---------------------------------------------------------------------------------------------------- |
| [__construct](#sendadf__construct)               | Start XML object                                                                                     |
| [add_address](#sendadfadd_address)               | Starts an address node in current working element.                                                   |
| [add_contact](#sendadfadd_contact)               | Starts a contact node in current working element.                                                    |
| [add_customer](#sendadfadd_customer)             | Add customer node to prospect element.                                                               |
| [add_email](#sendadfadd_email)                   | Add an email node to current working element.                                                        |
| [add_name](#sendadfadd_name)                     | Add name to current working element.                                                                 |
| [add_node](#sendadfadd_node)                     | Add a user defined node to current working node.                                                     |
| [add_parent_node](#sendadfadd_parent_node)       | Add a user defined parent node to the current working element becoming the new current working node. |
| [add_phone](#sendadfadd_phone)                   | Add phone to current working element.                                                                |
| [add_prospect](#sendadfadd_prospect)             | Add primary prospect node to adf element.                                                            |
| [add_provider](#sendadfadd_provider)             | Add provider to prospect element.                                                                    |
| [add_requestdate](#sendadfadd_requestdate)       | Converts time to ISO 8601. Defaults to current time() if none provided.                              |
| [add_vehicle](#sendadfadd_vehicle)               | Add a vehicle node to prospect element.                                                              |
| [add_vendor](#sendadfadd_vendor)                 | Add vendor to prospect element.                                                                      |
| [close_node](#sendadfclose_node)                 | Closes current working element.                                                                      |
| [date](#sendadfdate)                             | Formats date to ISO 8601. Defaults to current time() if none provided.                               |
| [getPrettyPrintXML](#sendadfgetprettyprintxml)   | Format XML and make it pretty!                                                                       |
| [getXML](#sendadfgetxml)                         | Returns complete ADF/XML.                                                                            |
| [is_json](#sendadfis_json)                       | Checks if string is JSON.                                                                            |
| [prepare_data](#sendadfprepare_data)             | Converts JSON and objects to an array. Integers are converted into strings.                          |
| [validate_attribute](#sendadfvalidate_attribute) | Validates attribute, if validation is enabled.                                                       |
| [validate_element](#sendadfvalidate_element)     | Validates tag, if validation is enabled.                                                             |
| [validation](#sendadfvalidation)                 | Disabling validation allows for use of custom ADF tags.                                              |
| [version](#sendadfversion)                       | SendADF version                                                                                      |

---

### SendADF::__construct  

**Description**

```php
public __construct (string $charset, string|int $document_version)
```

Start XML object 

 

**Parameters**

* `(string) $charset`
: Character encoding  
* `(string|int) $document_version`
: Document version  

**Return Values**

`void`


---


### SendADF::add_address  

**Description**

```php
public add_address (string $type)
```

Starts an address node in current working element. 

 

**Parameters**

* `(string) $type`
: Type of address  

**Return Values**

`object`

> This instance (current working document)


---


### SendADF::add_contact  

**Description**

```php
public add_contact (int $primarycontact)
```

Starts a contact node in current working element. 

 

**Parameters**

* `(int) $primarycontact`
: Identifies if primary contact  

**Return Values**

`object`

> This instance (current working document)


---


### SendADF::add_customer  

**Description**

```php
public add_customer (void)
```

Add customer node to prospect element. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`object`

> This instance (current working document)


---


### SendADF::add_email  

**Description**

```php
public add_email (string $data, int $preferredcontact)
```

Add an email node to current working element. 

 

**Parameters**

* `(string) $data`
: Email address of contact  
* `(int) $preferredcontact`
: Indicates this as the preferred contact method (attribute)  

**Return Values**

`object`

> This instance (current working document)


---


### SendADF::add_name  

**Description**

```php
public add_name (string $data, string $part, string $type)
```

Add name to current working element. 

 

**Parameters**

* `(string) $data`
: Name of contact  
* `(string) $part`
: Part of name (attribute)  
* `(string) $type`
: Type of name (attribute)  

**Return Values**

`object`

> This instance (current working document)


---


### SendADF::add_node  

**Description**

```php
public add_node (string $name, mixed $data, array $attributes)
```

Add a user defined node to current working node. 

 

**Parameters**

* `(string) $name`
: Name of node  
* `(mixed) $data`
: Data for node  
* `(array) $attributes`
: Attributes array [ attribute_key => attribute_value ]  

**Return Values**

`object`

> This instance (current working document)


---


### SendADF::add_parent_node  

**Description**

```php
public add_parent_node (string $name, mixed $data, array $attributes, bool $close_node)
```

Add a user defined parent node to the current working element becoming the new current working node. 

 

**Parameters**

* `(string) $name`
: Name of new parent node  
* `(mixed) $data`
: Data for node  
* `(array) $attributes`
: Attributes array [ attribute_key => attribute_value ]  
* `(bool) $close_node`
: If enabled will open and close node  

**Return Values**

`object`

> This instance (current working document)


---


### SendADF::add_phone  

**Description**

```php
public add_phone (string $data, string $type, string $time, int $preferredcontact)
```

Add phone to current working element. 

 

**Parameters**

* `(string) $data`
: Phone number of contact  
* `(string) $type`
: Type of phone number (attribute)  
* `(string) $time`
: Best time for this number (attribute)  
* `(int) $preferredcontact`
: Indicates this as the preferred contact method (attribute)  

**Return Values**

`object`

> This instance (current working document)


---


### SendADF::add_prospect  

**Description**

```php
public add_prospect (string $status)
```

Add primary prospect node to adf element. 

 

**Parameters**

* `(string) $status`
: Identify leads that are being resent (attribute)  

**Return Values**

`object`




---


### SendADF::add_provider  

**Description**

```php
public add_provider (void)
```

Add provider to prospect element. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`object`

> This instance (current working document)


---


### SendADF::add_requestdate  

**Description**

```php
public add_requestdate (mixed $time)
```

Converts time to ISO 8601. Defaults to current time() if none provided. 

 

**Parameters**

* `(mixed) $time`
: Can be unix time stamp or date as a string  

**Return Values**

`object`

> This instance (current working document)


---


### SendADF::add_vehicle  

**Description**

```php
public add_vehicle (mixed $data, string $interest, string $status)
```

Add a vehicle node to prospect element. 

 

**Parameters**

* `(mixed) $data`
: Data associative array of vehicle data  
* `(string) $interest`
: Identifies intended purpose of this vehicle (attribute)  
* `(string) $status`
: Identifies new or used vehicle (attribute)  

**Return Values**

`object`

> This instance (current working document)


---


### SendADF::add_vendor  

**Description**

```php
public add_vendor (void)
```

Add vendor to prospect element. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`object`

> This instance (current working document)


---


### SendADF::close_node  

**Description**

```php
public close_node (void)
```

Closes current working element. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`object`

> This instance (current working document)


---


### SendADF::date  

**Description**

```php
public static date (mixed $time)
```

Formats date to ISO 8601. Defaults to current time() if none provided. 

 

**Parameters**

* `(mixed) $time`
: Time to convert  

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

Returns complete ADF/XML. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> ADF/XML


---


### SendADF::is_json  

**Description**

```php
public static is_json (mixed $data)
```

Checks if string is JSON. 

- https://stackoverflow.com/a/6041773/1007492 License CC BY-SA 3.0 

**Parameters**

* `(mixed) $data`
: Data to check  

**Return Values**

`bool`

> Is this JSON?


---


### SendADF::prepare_data  

**Description**

```php
public static prepare_data (mixed $data)
```

Converts JSON and objects to an array. Integers are converted into strings. 

 

**Parameters**

* `(mixed) $data`
: Data to prepare for input into a node  

**Return Values**

`mixed`

> Prepared data


---


### SendADF::validate_attribute  

**Description**

```php
public static validate_attribute (object $parent, object $node, bool $validation)
```

Validates attribute, if validation is enabled. 

 

**Parameters**

* `(object) $parent`
: Element attribute is being applied to  
* `(object) $node`
: Attribute being checked  
* `(bool) $validation`
: $this->validation value  

**Return Values**

`bool`

> Validation response


---


### SendADF::validate_element  

**Description**

```php
public static validate_element (object $parent, object $node, bool $validation)
```

Validates tag, if validation is enabled. 

 

**Parameters**

* `(object) $parent`
: Element tag is being applied to  
* `(object) $node`
: Tag being checked  
* `(bool) $validation`
: $this->validation value  

**Return Values**

`bool`

> Validation response


---


### SendADF::validation  

**Description**

```php
public validation (bool $validate)
```

Disabling validation allows for use of custom ADF tags. 

 

**Parameters**

* `(bool) $validate`
: Validation enabled by default, false to disable  

**Return Values**

`object`

> This instance (current working document)


---


### SendADF::version  

**Description**

```php
public version (void)
```

SendADF version 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

---

## Support

⭐ [Contact](https://github.com/carmelosantana/) to discuss commercial support.

## Funding

If you find SendADF useful or use it in a commercial environment please consider donating today with one of the following options.

- [PayPal](https://www.paypal.com/donate?hosted_button_id=WHCW333MC7CNW)
- Bitcoin `bc1qhxu9yf9g5jkazy6h4ux6c2apakfr90g2rkwu45`
- Ethereum `0x9f5D6dd018758891668BF2AC547D38515140460f`
- Tron `TFw3D8UwduZJvx8J4FPPgPVZ2PPJfyXs3k`

## License

The code is licensed [MIT](https://opensource.org/licenses/MIT) and the documentation is licensed [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/).
