<?php

namespace Mimosafa\WP\EntityDesign;

class Post_Type extends Entity {

    /**
     * Priority of registration
     *
     * @var int
     */
    protected $priority = 2;

    /**
     * @var bool
     */
    protected static $once = false;

    /**
     * Container of instances
     *
     * @var array[Post_Type]
     */
    protected static $instances = [];

    /**
     * Post_type registration to system
     *
     * @access protected
     */
    protected function register() {
        if ( self::$instances ) {
            foreach ( self::$instances as $instance ) {
                $args = $instance->attributes->toArray();
                $name = apply_filters( 'mimosafa_entity_design_post_type_name', $instance->name, $args );
                $args = apply_filters( 'mimosafa_entity_design_post_type_args', $args, $instance->name );
                register_post_type( $name, $args );
            }
        }
    }

    /**
     * Post_type name string filter
     *
     * @access protected
     *
     * @param string $string
     * @return string|bool:false
     */
    protected static function nameFilter( string $string ) {
        if ( $string = parent::nameFilter( $string ) ) {
            return strlen( $string ) < 21 ? $string : false;
        }
        return false;
    }

}
