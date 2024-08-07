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

## Install

Include SendADF in your project with [Composer](https://getcomposer.org/):

```bash
composer require carmelosantana/sendadf
```

**Requirements:**

- [PHP](https://www.php.net/manual/en/install.php) 8.1 or above
- [Composer](https://getcomposer.org/)

## Usage

### Basic lead

This [example](https://github.com/carmelosantana/sendadf/blob/main/examples/example-1.php) lead represents the minimum data required to comply with ADF specifications.

```php
$adf = ( new CarmeloSantana\SendAdf\SendAdf() )
    ->addProspect( 'new' )
    ->addRequestdate( '2/9/2020 6:26PM' )
    ->addVehicle( [
        'year' => 1999,
        'make' => 'Chevrolet',
        'model' => 'Blazer'
    ], 'buy', 'used' )
    ->addCustomer()
        ->addContact()
            ->addName( 'John Doe' )
            ->addPhone( '393-999-3922' )
    ->addVendor()
        ->addContact()
            ->addName( 'Acura of Bellevue' );
```

### Output

Basic output with no tabs:

```php
echo $adf->getXml();
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
$adf = ( new CarmeloSantana\SendAdf\SendAdf() )
    ->addRequestdate()
    ->addVehicle( [
        'year' => 2020,
        'make' => 'Chevrolet',
        'model' => 'Blazer'
    ] )
    ->addCustomer()
        ->addContact()
            ->addName( 'John Doe' )
            ->addPhone( '393-999-3922' );

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

## Support

Community support available on [Discord](https://discord.gg/VCMvAMSJfg).

## Funding

If you find SendADF useful or use it in a commercial environment please consider donating today with one of the following options.

- [PayPal](https://www.paypal.com/donate?hosted_button_id=WHCW333MC7CNW)
- Bitcoin `bc1qhxu9yf9g5jkazy6h4ux6c2apakfr90g2rkwu45`
- Ethereum `0x9f5D6dd018758891668BF2AC547D38515140460f`
- Tron `TFw3D8UwduZJvx8J4FPPgPVZ2PPJfyXs3k`

## License

The code is licensed [MIT](https://opensource.org/licenses/MIT) and the documentation is licensed [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/).
