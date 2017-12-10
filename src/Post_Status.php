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
     * Post_types
     *
     * @var array
     */
    private $post_type = [];

    /**
     * Post status attribute setter
     *
     * @access public
     *
     * @param string $key
     * @param mixed[] $values
     * @return self
     */
    public function set( string $key, ...$values ) {
        if ( in_array( $key, ['post_type', 'post_types'], true ) ) {
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
                $this->post_type[] = $post_type->getName();
            }
            else if ( is_string( $post_type ) ) {
                $this->post_type[] = $post_type;
            }
        }
        return $this;
    }

    /**
     * Post status registration to system
     *
     * @access public
     */
    public function register() {
        $args = $this->attributes->toArray();
        $name = apply_filters( 'mimosafa_entity_design_post_status_name', $this->name, $args );
        $args = apply_filters( 'mimosafa_entity_design_post_status_args', $args, $this->name );
        $args['post_type'] = array_unique( $this->post_type );
        register_post_status( $name, $args );
    }

}
