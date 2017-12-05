<?php

namespace Mimosafa\WP\EntityDesign;

abstract class Entity {

    /**
     * Priority of registration
     *
     * @var int
     */
    protected $priority = 10;

    /**
     * Unique name of entity
     *
     * @var string
     */
    protected $name;

    /**
     * Attributes of entity
     *
     * @var Attributes
     */
    protected $attributes;

    /**
     * Flag for initializing only once
     * - This property must be sat each class
     *
     * @var bool
     */
    protected static $once = false;

    /**
     * Container of instances
     * - This property must be sat each class
     *
     * @var array[Entity]
     */
    protected static $instances = [];

    /**
     * Define entity
     *
     * @access public
     * @static
     *
     * @param string $name Entity name
     * @param array[]|string[] $args Variable-length argument for compatibility with other class
     * @return Entity|null
     */
    public static function make( string $name, ...$args ) {
        if ( ! $name = static::nameFilter( $name ) ) {
            # throw new \Exception();
            return;
        }
        $_args = static::prepareArgs( $args );
        $attrClass = str_replace( __NAMESPACE__, __NAMESPACE__ . '\\Attributes', get_called_class() );
        if ( ! $instance = static::get( $name ) ) {
            return static::$instances[$name] = new static( $name, new $attrClass( $_args ) );
        }
        if ( $_args ) {
            foreach ( $_args as $key => $value ) {
                $instance->attr( $key, $value );
            }
        }
        return $instance;
    }

    /**
     * Get Entity instance
     *
     * @access public
     * @static
     *
     * @param string $name name of Entity
     * @return Entity|null
     */
    public static function get( string $name ) {
        return static::$instances[$name] ?? null;
    }

    /**
     * Constructor
     *
     * @access protected
     *
     * @param string $name
     * @param Attributes\Attributes $attrs
     */
    protected function __construct( string $name, Attributes\Attributes $attributes ) {
        $this->name = $name;
        $this->attributes = $attributes;
        add_action( 'init', [$this, 'init'], $this->priority );
    }

    /**
     * Entity attribute setter
     *
     * @access public
     *
     * @param string $key
     * @param mixed[] $values
     * @return static
     */
    public function attr( string $key, ...$values ) {
        $this->attributes->set( $key, ...$values );
        return $this;
    }

    /**
     * Initializing class
     *
     * @access public
     */
    public function init() {
        if ( ! static::$once ) {
            $this->register();
            static::$once = true;
        }
    }

    /**
     * Entity registration to system (This method called only once)
     *
     * @access protected
     * @abstract
     */
    abstract protected function register();

    /**
     * Entity name string filter
     *
     * @access protected
     * @static
     *
     * @param string $string
     * @return string|bool:false
     */
    protected static function nameFilter( string $string ) {
        if ( ! $string || sanitize_key( $string ) !== $string ) {
            return false;
        }
        return $string;
    }

    /**
     * Arguments preparation
     *
     * @access protected
     * @static
     *
     * @param array[array] $argsArray
     * @return array
     */
    protected static function prepareArgs( array $argsArray ): Array {
        return $argsArray ? wp_parse_args( $argsArray[0] ) : [];
    }

}
