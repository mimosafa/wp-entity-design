<?php

namespace Mimosafa\WP\EntityDesign;

class Taxonomy extends Entity {

    /**
     * Priority of registration
     *
     * @var int
     */
    protected $priority = 1;

    /**
     * Container of instances
     *
     * @var array[Taxonomy]
     */
    protected static $instances = [];

    /**
     * Object types
     *
     * @var array
     */
    private $object_types = [];

    /**
     * Constructor
     *
     * @access protected
     *
     * @param string $name
     * @param Attributes\Taxonomy $attrs
     */
    protected function __construct( string $name, Attributes\Taxonomy $attributes ) {
        parent::__construct( $name, $attributes );
        add_filter( 'mimosafa_entity_design_post_type_args', [$this, 'post_type_args'], 10, 2 );
    }

    /**
     * Taxonomy attribute setter
     *
     * @access public
     *
     * @param string $key
     * @param mixed[] $values
     * @return self
     */
    public function set( string $key, ...$values ) {
        if ( in_array( $key, ['object_types', 'post_type', 'post_types'], true ) ) {
            return $this->post_type( $values[0] );
        }
        return parent::set( $key, ...$values );
    }

    /**
     * Bind post_type to $this
     *
     * @access public
     *
     * @param string|Post_Type|array $post_type
     * @return self
     */
    public function post_type( $post_type ) {
        /** Called recursive, or not @var bool */
        static $depth = false;
        if ( $post_type ) {
            if ( is_array( $post_type ) ) {
                if ( $depth || $post_type !== array_values( $post_type ) ) {
                    return $this;
                }
                $depth = true;
                foreach ( $post_type as $pt ) {
                    $this->post_type( $pt );
                }
                $depth = false;
                return $this;
            }
            if ( $post_type instanceof Post_Type ) {
                $this->object_types[] = $post_type->getName();
            }
            else if ( is_string( $post_type ) ) {
                $this->object_types[] = $post_type;
            }
        }
        return $this;
    }

    /**
     * Taxonomy registration to system
     *
     * @access public
     */
    public function register() {
        $args = $this->attributes->toArray();
        $name = apply_filters( 'mimosafa_entity_design_taxonomy_name', $this->name, $args );
        $args = apply_filters( 'mimosafa_entity_design_taxonomy_args', $args, $this->name );
        $object_types = array_unique( $this->object_types );
        register_taxonomy( $name, $object_types, $args );
    }

    /**
     * Registration $this for post_types
     *
     * @access public
     *
     * @param array $args Post_type's arguments
     * @param string $name Post_type's name
     * @return array
     */
    public function post_type_args( Array $args, string $name ) {
        if ( $this->object_types && in_array( $name, $this->object_types, true ) ) {
            if ( ! isset( $args['taxonomies'] ) || ! is_array( $args['taxonomies'] ) ) {
                $args['taxonomies'] = [];
            }
            if ( ! in_array( $this->name, $args['taxonomies'], true ) ) {
                $args['taxonomies'][] = $this->name;
            }
        }
        return $args;
    }

    /**
     * Taxonomy name string filter
     *
     * @access protected
     *
     * @param string $string
     * @return string|bool:false
     */
    protected static function nameFilter( string $string ) {
        if ( $string = parent::nameFilter( $string ) ) {
            return strlen( $string ) < 33 ? $string : false;
        }
        return false;
    }

}
