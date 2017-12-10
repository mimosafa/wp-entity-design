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
     * Container of instances
     *
     * @var array[Post_Type]
     */
    protected static $instances = [];

    /**
     * Taxonomies
     *
     * @var array
     */
    private $taxonomies = [];

    /**
     * Constructor
     *
     * @access protected
     *
     * @param string $name
     * @param Attributes\Post_Type $attrs
     */
    protected function __construct( string $name, Attributes\Post_Type $attributes ) {
        parent::__construct( $name, $attributes );
        add_filter( 'mimosafa_entity_design_taxonomy_args', [$this, 'taxonomy_args'], 10, 2 );
    }

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
        if ( in_array( $key, ['taxonomy', 'taxonomies'], true ) ) {
            return $this->taxonomy( $values[0] );
        }
        if ( $key === 'post_status' ) {
            return $this->post_status( $values[0] );
        }
        return parent::set( $key, ...$values );
    }

    /**
     * Bind taxonomy to $this
     *
     * @access public
     *
     * @param string|Taxonomy|array $status
     * @return self
     */
    public function taxonomy( $taxonomy ) {
        static $depth = false;
        if ( $taxonomy ) {
            if ( is_array( $taxonomy ) ) {
                if ( $depth || $taxonomy !== array_values( $taxonomy ) ) {
                    return $this;
                }
                $depth = true;
                foreach ( $taxonomy as $tx ) {
                    $this->taxonomy( $tx );
                }
                $depth = false;
                return $this;
            }
            if ( $taxonomy instanceof Taxonomy ) {
                $this->taxonomies[] = $taxonomy->getName();
            }
            else if ( is_string( $taxonomy ) ) {
                $this->taxonomies[] = $taxonomy;
            }
        }
        return $this;
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
        static $depth = false;
        if ( $status ) {
            if ( is_array( $status ) ) {
                if ( $depth ) {
                    return $this;
                }
                $depth = true;
                foreach ( $status as $ps ) {
                    $this->post_status( $ps );
                }
                $depth = false;
                return $this;
            }
            if ( ! is_object( $status ) || ! $status instanceof Post_Status ) {
                if ( empty( $status ) || ! is_string( $status ) || ! $status = Post_Status::getInstance( $status ) ) {
                    return $this;
                }
            }
            $status->set( 'post_type', $this->name );
        }
        return $this;
    }

    /**
     * Post_type registration to system
     *
     * @access public
     */
    public function register() {
        $args = $this->attributes->toArray();
        $name = apply_filters( 'mimosafa_entity_design_post_type_name', $this->name, $args );
        $args = apply_filters( 'mimosafa_entity_design_post_type_args', $args, $this->name );
        $args['taxonomies'] = array_unique( $this->taxonomies );
        register_post_type( $name, $args );
    }

    /**
     * Registration $this for taxonomies
     *
     * @access public
     *
     * @param array $args Taxonomy's arguments
     * @param string $name Taxonomy's name
     * @return array
     */
    public function taxonomy_args( Array $args, string $name ) {
        if ( $this->taxonomies && in_array( $name, $this->taxonomies, true ) ) {
            if ( ! isset( $args['object_types'] ) || ! is_array( $args['object_types'] ) ) {
                $args['object_types'] = [];
            }
            if ( in_array( $this->name, $args['object_types'], true ) ) {
                $args['object_types'] = $this->name;
            }
        }
        return $args;
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
