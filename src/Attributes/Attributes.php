<?php

namespace Mimosafa\WP\EntityDesign\Attributes;

abstract class Attributes {

    /**
     * Private attributes list
     * - This property must be sat each class, if exists
     */
    protected static $privateAttrs = [];

    /**
     * Attributes list that must be string
     * - This property must be sat each class, if exists
     */
    protected static $stringAttrs = [];

    /**
     * Attributes list that must be boolean
     * - This property must be sat each class, if exists
     */
    protected static $booleanAttrs = [];

    /**
     * Constructor
     *
     * @param array $args
     */
    public function __construct( array $args = [] ) {
        if ( $args ) {
            foreach ( $args as $key => $value ) {
                $this->set( $key, $value );
            }
        }
    }

    /**
     * Attribute setter
     *
     * @access public
     *
     * @param string  $key
     * @param mixed[] $args
     * @return void
     */
    public function set( string $key, ...$args ) {
        if ( empty( $key ) || empty( $args ) || in_array( $key, static::$privateAttrs, true ) ) {
            return;
        }
        if ( in_array( $key, static::$stringAttrs, true ) ) {
            // Attribute that must be string
            if ( $value = filter_var( $args[0] ) ) {
                $this->$key = $value;
            }
            return;
        }
        if ( in_array( $key, static::$booleanAttrs, true ) ) {
            // Attribute that must be boolean
            $value = filter_var( $args[0], \FILTER_VALIDATE_BOOLEAN, \FILTER_NULL_ON_FAILURE );
            if ( is_bool( $value ) ) {
                $this->$key = $value;
            }
            return;
        }
        if ( count( $args ) === 1 ) {
            $this->$key = $args[0];
            return;
        }
        // When this method has more than 3 arguments, the {$key} property will be associative array.
        // And this array will be deeper deeper by the num of {$args}.
        if ( ! property_exists( $this, $key ) || ! is_array( $this->$key ) ) {
            $this->$key = [];
        }
        $array =& $this->$key;
        while ( $args ) {
            $arrayKey = array_shift( $args );
            if ( count( $args ) === 1 ) {
                $array[$arrayKey] = array_shift( $args );
            }
            else {
                if ( ! isset( $array[$arrayKey] ) || ! is_array( $array[$arrayKey] ) ) {
                    $array[$arrayKey] = [];
                }
                $array =& $array[$arrayKey];
            }
        }
    }

    /**
     * Return array value converted from properties
     *
     * @access public
     *
     * @return array
     */
    public function toArray() {
        $array = [];
        foreach ( get_object_vars( $this ) as $key => $prop ) {
            if ( isset( $prop ) ) {
                $array[$key] = $prop;
            }
        }
        return $array;
    }

}
