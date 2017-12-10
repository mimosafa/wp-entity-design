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
        $args = $this->attributes->toArray();
        $name = apply_filters( 'mimosafa_entity_design_post_status_name', $this->name, $args );
        $args = apply_filters( 'mimosafa_entity_design_post_status_args', $args, $this->name );
        register_post_status( $name, $args );
    }

}
