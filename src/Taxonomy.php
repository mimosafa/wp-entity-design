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
     * @var bool
     */
    protected static $once = false;

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
        if ( self::$instances ) {
            foreach ( self::$instances as $instance ) {
                $args = $instance->attributes->toArray();
                $name = apply_filters( 'mimosafa_entity_design_taxonomy_name', $instance->name, $args );
                $args = apply_filters( 'mimosafa_entity_design_taxonomy_args', $args, $instance->name );
                if ( isset( $args['object_type'] ) ) {
                    $object_type = $args['object_type'];
                    unset( $args['object_type'] );
                }
                else {
                    $object_type = [];
                }
                register_taxonomy( $name, $object_type, $args );
            }
        }
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
