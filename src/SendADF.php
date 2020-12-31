<?php
declare(strict_types=1);

namespace carmelosantana\SendADF;

/**
 * Creates a valid Auto-lead Data Format/ADF for the export of customer leads via XML.
 * - Default values are derived from ADF version 1.0
 */
class SendADF {
    /** @var object Current XML node */
    protected $current;

    /** @var object Previous working current node */
    protected $parent;
    
    /** @var object <prospect> node */
    protected $prospect;

    /** @var object Current XML document */
    protected $xml;

    /**
     * Start XML object
     * 
     * @param string Version of ADF
     * @param string Format of XML
     */
    public function __construct( $charset='UTF-8', $format='adf', $version='1.0' )
    {
        /** @var string Character encoding */
        $this->charset = strtoupper($charset);

        /** @var string Lead format requested */
        $this->format = strtolower($format);

        /** @var mixed adf version requested */
        $this->version = $version;

        /** @var array template of allowed parameters */
        $this->spec = Spec::get()->by_version( $this->format, $this->version );

        /** @var object start XML object */
        $this->xml = new \SimpleXMLElement( '<?xml version="1.0" encoding="' . $this->charset . '"?><?' . $this->format . ' version="' . $this->version . '"?><' . $this->format . '/>' );

        /** @var array set current working node and primary prospect node  */
        $this->current = $this->prospect = $this->xml->addChild( array_key_first( $this->spec ) );
    }

	/**
	 * Initialize instance, start ADF document.
	 *
	 * @return object
	 */
	public static function instance(): object
	{
		return new static();
    }

    /**
     * Resets current working node to <prospect>.
     *
     * @return object This instance (current working document)
     */
    public function add(): object {
        $this->current = $this->prospect;

        return $this;
    }
    
    /**
     * Starts a <contact> node in current working node. 
     *
     * @return object This instance (current working document) 
     */
    public function add_contact(): object
    {
        $this->start_node( $this->current, 'contact' );

        return $this;
    }

    /**
     * Add <customer> to <prospect> node.
     *  
     * @return object This instance (current working document)
     */
    public function add_customer(): object
    {
        $this->start_node( $this->prospect, 'customer' );

        return $this;
    }

    /**
     * Add <email> current working node.
     * 
     * @param string Email address of contact
     * @param int Set prefferedcontact=”1” to indicate this as the preferred method of contact (attribute)
     * 
     * @return object This instance (current working document)
     */
    public function add_email( $data, $preferredcontact=null ): object
    {
        $this->add_child( $this->current, 'email', $data, [ 'preferredcontact' => $preferredcontact ] );

        return $this;
    }

    /**
     * Add <name> current working node.
     * 
     * @param string Name of contact
     * @param string Part of name (attribute)
     * @param string Type individual|business (attribute)
     * 
     * @return object This instance (current working document)
     */
    public function add_name( $data, $part='full', $type='individual' ): object
    {
        $this->add_child( $this->current, 'name', $data, [ 'part' => $part, 'type' => $type ] );

        return $this;
    }

    /**
     * Add a user defined <node>.
     *
     * @param string Name of node
     * @param string Data value for node
     * @param array Attributes array [ attribute_key => attribute_value ]
     * 
     * @return object This instance (current working document)
     */
    public function add_node( string $name=null, string $data=null, array $attributes=[] ): object
    {
        $this->add_child( $this->current, $name, $data, $attributes );

        return $this;
    }

    /**
     * Add a user defined parent node to the current working node. This node becomes the new current working node.
     *
     * @param string Name of new parent node
     * @param array Attributes array [ attribute_key => attribute_value ]
     * 
     * @return object This instance (current working document)
     */
    public function add_parent_node( string $name=null, array $attributes=[] )
    {
        $this->add_child( $this->current, $name, $attributes );

        return $this;        
    }

    /**
     * Add <phone> current working node.
     * 
     * @param string Phone number of contact
     * @param string Type attribute (phone|fax|cellphone|pager)
     * @param string Time parameter indicates that this entry is the preferred contact number.
     * @param int Preferred contact attribute. Set prefferedcontact=”1” to indicate this as the preferred method of contact. (0|1)
     * 
     * @return object This instance (current working document)
     */
    public function add_phone( $data, $type='full', $time='individual', $preferredcontact=null ): object
    {
        $this->add_child( null, 'phone', $data, [ 'type' => $type, 'time' => $time, 'preferredcontact' => $preferredcontact ] );

        return $this;
    }

    /**
     * Add <provider> to <prospect> node.
     * 
     * @return object This instance (current working document)
     */
    public function add_provider(): object
    {
        $this->start_node( $this->prospect, 'provider' );
        
        return $this;
    }
 
    /**
     * Add <vendor> to <prospect> node.
     * 
     * @return object This instance (current working document)
     */    
    public function add_vendor(): object
    {
        $this->start_node( $this->prospect, 'vendor' );

        return $this;
    }

    /**
     * Add a <vehicle> node to <prospect>.
     * 
     * @param array Data associative array of vehicle data
     * @param string Interest attribute (buy|sell)
     * @param string Status attribute (new|used)
     * 
     * @return object This instance (current working document)
     */
    public function add_vehicle( $data, $interest='buy', $status='new' ): object
    {
        $this->add_child( $this->prospect, 'vehicle', $data, [ 'interest' => $interest, 'status' => $status ] );
        
        return $this;
    }

    /**
     * Sets requestdate
     * 
     * @param mixed Time argument can be unix time stamp or date as a string.
     * 
     * @return object This instance (current working document)
     */
    public function set_requestdate( $time=null ): object
    {
        /** @var int defaults to current time() if none provided */
        if ( !$time )
            $time = time();

        if ( !is_int( $time ) )
            $time = strtotime( $time );

        $this->requestdate = self::date( $time );

        $this->add_child( $this->prospect, 'requestdate', $this->requestdate);

        return $this;
    }

    /**
     * Format XML and make it pretty!
     *
     * @return string Human readable XML
     */
    public function getPrettyPrintXML(){
        $dom = new \DOMDocument;
        $dom->preserveWhiteSpace = false;
        $dom->loadXML( $this->getXML() );
        $dom->formatOutput = true;
        
        return $dom->saveXML();
    }
    
    /**
     * Returns valid ADF/XML
     * - provides any necessary missing values
     * 
     * @return string ADF/XML 
     */
    public function getXML(): string
    {
        if ( !property_exists( $this, 'requestdate' ) )
            $this->set_requestdate();

        return $this->xml->asXML();
    }

    /**
     * Adds a child node + attributes if provided.
     * 
     * @param mixed XML object or null for <prospect>
     * @param string Name of child node
     * @param mixed Data for child node
     * @param array Attributes for child node
     * 
     * @return object New child node
     */
    private function add_child( $parent=null, string $child=null, $data=[], array $attributes=[] ): object
    {
        if ( !$parent )
            $parent = $this->current;

        if ( !$child )
            throw new \Exception( "<$child> missing" );
        
        $data = self::prepare_data( $data );
        
        if ( is_string( $data ) ){
            $node = $parent->addChild( $child, $data );

        } else {
            $node = $parent->addChild( $child );

            if ( is_array( $data ) and !empty( $data ) )
                array_walk( $data, [ $this, 'iterate_addChild'], $node );
        }

        if ( is_array( $attributes ) and !empty( $attributes ) )
            array_walk( $attributes, [ $this, 'iterate_addAttribute'], $node );

        return $node;
    }

    /**
     * Opens a new node and sets as current working node. 
     *
     * @param mixed XML object where node will be placed or null for <prospect>
     * @param string Name of node
     * @param array Data to populate node
     * @param array Attributes for new current node
     * 
     * @return object Newly created node
     */
    private function start_node( $parent, $name, $data=[], $attributes=[] )
    {
        $this->current = $this->add_child( $parent, $name, $data, $attributes );

        return $this->current;
    }

    /**
     * addChild iterator, if parameters are allowed
     * 
     * @param mixed Value value from array_walk
     * @param string Key key from array_walk
     * @param array Parameters array of allowed keys
     * 
     * @return void
     */
    private function iterate_addAttribute( $value, $key, $node ): void
    {
        if ( !isset( Spec::get()->parameters( $node->getName() )['@attributes'] ) )
            return;

        if ( in_array( strtolower( $key ), Spec::get()->parameters( $node->getName() )['@attributes'] ) ){
            $value = (string) $value;

            if ( !empty( $value ) )
                $node->addAttribute( strtolower( $key ), (string) $value );
        }
    }

    /**
     * addChild iterator, if parameters are allowed
     * 
     * @param mixed $value value from array_walk
     * @param string $key key from array_walk
     * @param array $parameters array of allowed keys
     * 
     * @return void
     */
    private function iterate_addChild( $value, $key, $node ): void
    {
        if ( in_array( strtolower( $key ), Spec::get()->parameters( $node->getName() ) ) ){
            $node->addChild( strtolower( $key ), (string) $value );

        }
    }

    /**
     * Converts JSON or php object to an array
     * 
     * @param mixed Data input
     * 
     * @return mixed Prepared data for adding to 
     */
    static function prepare_data( $data )
    {
        if ( self::is_json( $data ) )
            $data = json_decode( $data );

        if ( is_object( $data ) )
            return (array) $data;

        return $data;
    }

    /**
     * ISO 8601 format date
     * 
     * @return string Formatted date
     */
    static function date( $time=null ): string
    {
        return date( 'c' , ( $time ?? time() ) );
    }

    /**
     * Checks if string is JSON.
     * - https://stackoverflow.com/a/6041773/1007492 License CC BY-SA 3.0
     * 
     * @param mixed Data to check
     * 
     * @return bool Is this JSON?
     */
    static function is_json( $data ): bool
    {
        if ( !is_string( $data ) )
            return false;

		json_decode( $data );

		return ( json_last_error() == JSON_ERROR_NONE );
    }
}
