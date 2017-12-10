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
     * Taxonomy registration to system
     *
     * @access public
     */
    public function register() {
        $args = $this->attributes->toArray();
        $name = apply_filters( 'mimosafa_entity_design_taxonomy_name', $this->name, $args );
        $args = apply_filters( 'mimosafa_entity_design_taxonomy_args', $args, $this->name );
        if ( isset( $args['object_type'] ) ) {
            $object_types = array_unique( array_filter( (array) $args['object_type'] ) );
            unset( $args['object_type'] );
        }
        else {
            $object_types = [];
        }
        register_taxonomy( $name, $object_types, $args );
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
