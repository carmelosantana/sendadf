<?php

declare(strict_types=1);

namespace CarmeloSantana\SendAdf;

/**
 * Creates a valid Auto-lead Data Format/ADF for the export of customer leads via XML.
 * - Default values are derived from ADF version 1.0
 */
class SendAdf
{
    /** @var array $nodes Stores working XML nodes */
    public $nodes = [];

    /** @var bool $validation Flag for tag and attribute validation */
    private $validation = true;

    /** @var string $version SendADF() version */
    private $version = '0.3.0';

    /** @var object Current XML document */
    protected $xml;

    /**
     * Start XML object
     * 
     * @param string $charset Character encoding
     * @param string $document_format Document format
     * @param string|int $document_version Document version
     */
    public function __construct(public string $charset = 'UTF-8', public string $document_format = 'adf', public string $document_version = '1.0')
    {
        // Start XML document
        $this->xml = new \SimpleXMLElement('<?xml version="1.0" encoding="' . $this->charset . '"?><?' . $this->document_format . ' version="' . $this->document_version . '"?><' . $this->document_format  . '/>');
    }

    /**
     * Starts an address node in current working element. 
     * 
     * @param string $type Type of address
     *
     * @return object This instance (current working document) 
     */
    public function addAddress(string $type = null): object
    {
        $this->startNode($this->getCurrent(), 'address', [], ['type' => $type]);

        return $this;
    }

    /**
     * Starts a contact node in current working element.
     * 
     * @param int $primarycontact Identifies if primary contact
     *
     * @return object This instance (current working document) 
     */
    public function addContact($primarycontact = null): object
    {
        $this->startNode($this->getCurrent(), 'contact', [], ['primarycontact' => $primarycontact]);

        return $this;
    }

    /**
     * Add customer node to prospect element.
     *  
     * @return object This instance (current working document)
     */
    public function addCustomer(): object
    {
        $this->startNode($this->getProspect(), 'customer');

        return $this;
    }

    /**
     * Add an email node to current working element.
     * 
     * @param string $data Email address of contact
     * @param int $preferredcontact Indicates this as the preferred contact method (attribute)
     * 
     * @return object This instance (current working document)
     */
    public function addEmail($data, $preferredcontact = null): object
    {
        $this->addChild($this->getCurrent(), 'email', $data, ['preferredcontact' => $preferredcontact]);

        return $this;
    }

    /**
     * Add name to current working element.
     * 
     * @param string $data Name of contact
     * @param string $part Part of name (attribute)
     * @param string $type Type of name (attribute)
     * 
     * @return object This instance (current working document)
     */
    public function addName($data, $part = 'full', $type = 'individual'): object
    {
        $this->addChild($this->getCurrent(), 'name', $data, ['part' => $part, 'type' => $type]);

        return $this;
    }

    /**
     * Add a user defined node to current working node.
     *
     * @param string $name Name of node
     * @param mixed $data Data for node
     * @param array $attributes Attributes array [ attribute_key => attribute_value ]
     * 
     * @return object This instance (current working document)
     */
    public function addNode(string $name = null, $data, array $attributes = []): object
    {
        $this->addChild($this->getCurrent(), $name, $data, $attributes);

        return $this;
    }

    /**
     * Add a user defined parent node to the current working element becoming the new current working node.
     *
     * @param string $name Name of new parent node
     * @param mixed $data Data for node
     * @param array $attributes Attributes array [ attribute_key => attribute_value ]
     * @param bool $close_node If enabled will open and close node
     * 
     * @return object This instance (current working document)
     */
    public function addParentNode(string $name, $data = null, $attributes = [], $close_node = false)
    {
        $this->startNode($this->getCurrent(), $name, $data, $attributes);

        if ($close_node)
            $this->closeNode();

        return $this;
    }

    /**
     * Add phone to current working element.
     * 
     * @param string $data Phone number of contact
     * @param string $type Type of phone number (attribute)
     * @param string $time Best time for this number (attribute) 
     * @param int $preferredcontact Indicates this as the preferred contact method (attribute)
     * 
     * @return object This instance (current working document)
     */
    public function addPhone($data, $type = 'voice', $time = 'nopreference', $preferredcontact = '0'): object
    {
        $this->addChild(null, 'phone', $data, ['type' => $type, 'time' => $time, 'preferredcontact' => $preferredcontact]);

        return $this;
    }

    /**
     * Add primary prospect node to adf element.
     *
     * @param string $status Identify leads that are being resent (attribute)
     * 
     * @return object
     */
    public function addProspect(string $status = 'new'): object
    {
        $prospect = $this->xml->addChild('prospect');

        if ($status)
            $prospect->addAttribute('status', $status);

        array_unshift($this->nodes, $prospect);

        return $this;
    }

    /**
     * Add provider to prospect element.
     * 
     * @return object This instance (current working document)
     */
    public function addProvider(): object
    {
        $this->startNode($this->getProspect(), 'provider');

        return $this;
    }

    /**
     * Converts time to ISO 8601. Defaults to current time() if none provided.
     * 
     * @param mixed $time Can be unix time stamp or date as a string
     * 
     * @return object This instance (current working document)
     */
    public function addRequestdate($time = null): object
    {
        // check if we already have requestdate in current working document
        if ($this->hasRequestdate())
            return $this;

        // no time provided
        if (!$time)
            $time = time();

        // try to convert to unix timestamp
        if (!is_int($time))
            $time = strtotime($time);

        // conversion failed use current time() for requestdate
        if (!$time)
            $time = time();

        $this->addChild($this->getProspect(), 'requestdate', self::date($time));

        return $this;
    }

    /**
     * Add vendor to prospect element.
     * 
     * @return object This instance (current working document)
     */
    public function addVendor(): object
    {
        $this->startNode($this->getProspect(), 'vendor');

        return $this;
    }

    /**
     * Add a vehicle node to prospect element.
     * 
     * @param mixed $data Data associative array of vehicle data
     * @param string $interest Identifies intended purpose of this vehicle (attribute)
     * @param string $status Identifies new or used vehicle (attribute)
     * 
     * @return object This instance (current working document)
     */
    public function add_vehicle($data, $interest = 'buy', $status = 'new'): object
    {
        $this->startNode($this->getProspect(), 'vehicle', $data, ['interest' => $interest, 'status' => $status]);

        return $this;
    }

    /**
     * Closes current working element.
     *
     * @return object This instance (current working document)
     */
    public function closeNode(): object
    {
        array_shift($this->nodes);

        return $this;
    }


    /**
     * Format XML and make it pretty!
     *
     * @return string Human readable XML
     */
    public function getPrettyPrintXML(): string
    {
        $dom = new \DOMDocument;
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($this->getXml());
        $dom->formatOutput = true;

        return $dom->saveXML();
    }

    /**
     * Returns complete ADF/XML.
     * 
     * @return string ADF/XML 
     */
    public function getXml(): string
    {
        // set requestdate if validation is enabled and requestdate is missing
        if ($this->validation and !$this->hasRequestdate())
            $this->addRequestdate();

        return $this->xml->asXML();
    }

    /**
     * Disabling validation allows for use of custom ADF tags.
     *
     * @param bool $validate Validation enabled by default, false to disable
     * 
     * @return object This instance (current working document)
     */
    public function validation($validate = true): object
    {
        $this->validation = $validate;

        return $this;
    }

    /**
     * SendADF version
     *
     * @return string
     */
    public function version(): string
    {
        return $this->version;
    }

    /**
     * Adds a child node + attributes to provided element. Performs any necessary tag validation.
     * 
     * @param mixed XML object of parent element. Defaults to current working element.
     * @param string $child New node tag
     * @param mixed $data Data to populate node. Accepts strings and various arrays
     * @param array $attributes Attributes array [ attribute_key => attribute_value ]
     * 
     * @return object New child node
     */
    private function addChild($parent = null, string $child = null, $data = null, array $attributes = []): object
    {
        if (!$parent)
            $parent = $this->getCurrent();

        if (!$child)
            throw new \Exception("<$child> missing");

        if (!self::validateElement($parent, $child, $this->validation))
            throw new \Exception("<$child> not a valid tag of parent " . $parent->getName());

        $data = self::prepareData($data);

        if (is_string($data)) {
            $node = $parent->addChild($child, $data);
        } else {
            $node = $parent->addChild($child);

            if (is_array($data) and !empty($data))
                array_walk($data, [$this, 'iterateAddChild'], $node);
        }

        if (is_array($attributes) and !empty($attributes))
            array_walk($attributes, [$this, 'iterateAddAttribute'], $node);

        return $node;
    }

    /**
     * Starts a new parent node and sets as current working element. 
     *
     * @param mixed $parent XML object of parent element. Defaults to current working element.
     * @param string $name New node tag
     * @param mixed $data Data to populate node. Accepts strings and various arrays
     * @param array $attributes Attributes array [ attribute_key => attribute_value ]
     * 
     * @return object New parent node
     */
    private function startNode($parent = null, string $name = null, $data = null, array $attributes = []): object
    {
        array_unshift($this->nodes, $this->addChild($parent, $name, $data, $attributes));

        return $this->getCurrent();
    }

    /**
     * Get current working element.
     *
     * @return object Current element
     */
    private function getCurrent(): object
    {
        if (!isset($this->nodes[0]))
            $this->addProspect();

        return $this->nodes[0];
    }

    /**
     * Get and if missing sets primary prospect element.
     *
     * @return object Prospect element
     */
    private function getProspect(): object
    {
        if (!isset($this->nodes[0]))
            $this->addProspect();

        $prospect = end($this->nodes);
        reset($this->nodes);

        return $prospect;
    }
    /**
     * Iterates through attributes applying each to supplied element. Performs validation checks if enabled.
     * 
     * @param mixed $value Value from array_walk
     * @param string $key Key from array_walk
     * @param object $node Element to apply attributes to
     * 
     * @return void
     */
    private function iterateAddAttribute($value, $key, $node): void
    {
        if (self::validateAttribute($node, $key, $this->validation)) {
            $value = self::prepareData($value);

            if ($this->validation)
                $key = strtolower($key);

            if (!empty($value))
                $node->addAttribute($key, $value);
        }
    }

    /**
     * Iterates through tags applying each to supplied element. Performs validation checks if enabled.
     * 
     * @param mixed $value Value from array_walk
     * @param string $key Key from array_walk
     * @param object $node Element to apply tags to
     * 
     * @return void
     */
    private function iterateAddChild($value, $key, $node): void
    {
        if (!is_object($node))
            return;

        if (self::validateElement($node, $key, $this->validation)) {
            $value = self::prepareData($value);

            if ($this->validation)
                $key = strtolower($key);

            if (!empty($value))
                $node->addChild($key, $value);
        }
    }

    /**
     * Checks if current working document has a requestdate element.
     * 
     * @return bool If requestdate exists
     */
    private function hasRequestdate(): bool
    {
        if (isset(((array) $this->getProspect()->children())['requestdate']))
            return true;

        return false;
    }

    /**
     * Formats date to ISO 8601. Defaults to current time() if none provided.
     * 
     * @param mixed $time Time to convert
     * 
     * @return string Formatted date
     */
    static function date($time = null): string
    {
        return date('c', ($time ?? time()));
    }

    /**
     * Checks if string is JSON.
     * - https://stackoverflow.com/a/6041773/1007492 License CC BY-SA 3.0
     * 
     * @param mixed $data Data to check
     * 
     * @return bool Is this JSON?
     */
    static function isJson($data): bool
    {
        if (!is_string($data))
            return false;

        json_decode($data);

        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Converts JSON and objects to an array. Integers are converted into strings. 
     * 
     * @param mixed $data Data to prepare for input into a node
     * 
     * @return mixed Prepared data
     */
    static function prepareData($data)
    {
        if (self::isJson($data))
            $data = json_decode($data);

        if (is_object($data))
            return (array) $data;

        if (is_int($data))
            return (string) $data;

        return $data;
    }

    /**
     * Validates attribute, if validation is enabled.
     *
     * @param object $parent Element attribute is being applied to
     * @param object $node Attribute being checked
     * @param bool $validation $this->validation value
     * 
     * @return bool Validation response
     */
    static function validateAttribute(object $parent, string $node, bool $validation): bool
    {
        if (!$validation)
            return true;

        $node = strtolower($node);

        if (!isset(Spec::get()->element($parent->getName())['@attributes']))
            return false;

        $attributes = Spec::get()->element($parent->getName())['@attributes'];

        if (in_array($node, $attributes) or key_exists($node, $attributes))
            return true;

        return false;
    }

    /**
     * Validates tag, if validation is enabled.
     *
     * @param object $parent Element tag is being applied to
     * @param object $node Tag being checked
     * @param bool $validation $this->validation value
     * 
     * @return bool Validation response
     */
    static function validateElement(object $parent, string $node, bool $validation): bool
    {
        if (!$validation)
            return true;

        if (in_array(strtolower($node), Spec::get()->element($parent->getName())))
            return true;

        return false;
    }
}
