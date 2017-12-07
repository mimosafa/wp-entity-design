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
     * Post_type attribute setter
     *
     * @access public
     *
     * @param string $key
     * @param mixed[] $values
     * @return self
     */
    public function set( string $key, ...$values ) {
        if ( $values && in_array( $key, ['post_status', 'post_statuses'], true ) ) {
            return $this->post_status( $values[0] );
        }
        return parent::set( $key, ...$values );
    }

    /**
     * Bind post_status to $this
     *
     * @access public
     *
     * @param string|Post_Status|array $status
     * @return self
     */
    public function post_status( $status ) {
        static $hir = 0;
        if ( is_array( $status ) ) {
            if ( $hir > 0 ) {
                return $this;
            }
            $hir++;
            foreach ( $status as $ps ) {
                $this->post_status( $ps );
            }
        }
        if ( ! is_object( $status ) || ! $status instanceof Post_Status ) {
            if ( empty( $status ) || ! is_string( $status ) || ! $status = Post_Status::getInstance( $status ) ) {
                return $this;
            }
        }
        $status->set( 'post_type', $this->name );
        $hir = 0;
        return $this;
    }

    /**
     * Post_type registration to system
     *
     * @access public
     */
    public function register() {
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
