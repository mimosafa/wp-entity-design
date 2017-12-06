<?php

namespace Mimosafa\WP\EntityDesign;

class Post_Status extends Entity {

    /**
     * Priority of registration
     *
     * @var int
     */
    protected $priority = 3;

    /**
     * @var bool
     */
    protected static $once = false;

    /**
     * Container of instances
     *
     * @var array[Post_Status]
     */
    protected static $instances = [];

    /**
     * Post status registration to system
     *
     * @access public
     */
    public function register() {
        if ( self::$instances ) {
            foreach ( self::$instances as $instance ) {
                $args = $instance->attributes->toArray();
                $name = apply_filters( 'mimosafa_entity_design_post_status_name', $instance->name, $args );
                $args = apply_filters( 'mimosafa_entity_design_post_status_args', $args, $instance->name );
                register_post_status( $name, $args );
            }
        }
    }

}
