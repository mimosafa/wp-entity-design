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
     * Container of instances
     * - This property must be sat each class
     *
     * @var array[Entity]
     */
    protected static $instances = [];

    /**
     * Check {$name} entity exists
     *
     * @access public
     * @static
     *
     * @param string $name
     * @return bool
     */
    public static function exists( string $name ): bool {
        return isset( static::$instances[$name] );
    }

    /**
     * Make entity
     *
     * @access public
     * @static
     *
     * @param string $name Entity name
     * @param array|string|Attributes\Attributes $args
     * @return Entity|null
     */
    public static function make( string $name, $args = [] ) {
        if ( ! $name = static::nameFilter( $name ) ) {
            # throw new \Exception();
            return;
        }
        if ( static::exists( $name ) ) {
            # throw new \Exception();
            return;
        }
        $attrClass = str_replace( __NAMESPACE__, __NAMESPACE__ . '\\Attributes', get_called_class() );
        if ( ! is_object( $args ) || ! is_a( $args, $attrClass ) ) {
            $args = new $attrClass( wp_parse_args( $args ) );
        }
        return static::$instances[$name] = new static( $name, $args );
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
    public static function getInstance( string $name ) {
        return static::$instances[$name] ?? null;
    }

    /**
     * Get name of entity
     *
     * @access public
     *
     * @return string
     */
    public function getName(): string {
        return $this->name;
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
        add_action( 'init', [$this, 'register'], $this->priority );
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
    public function set( string $key, ...$values ) {
        $this->attributes->set( $key, ...$values );
        return $this;
    }

    /**
     * Entity registration to system (This method called only once)
     *
     * @access public
     * @abstract
     */
    abstract public function register();

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

}
