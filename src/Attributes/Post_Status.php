<?php

namespace Mimosafa\WP\EntityDesign\Attributes;

class Post_Status extends Attributes {

    /**
     * Default attributes
     * - WordPress Core
     *
     * @access protected
     * @see https://developer.wordpress.org/reference/functions/register_post_status/
     */

    /**
     * @var bool|string
     */
    protected $label;

    /**
     * @var bool|array
     */
    protected $label_count;

    /**
     * @var bool
     */
    protected $exclude_from_search;

    /**
     * @var bool
     */
    protected $public;

    /**
     * @var bool
     */
    protected $internal;

    /**
     * @var bool
     */
    protected $protected;

    /**
     * @var bool
     */
    protected $private;

    /**
     * @var bool
     */
    protected $publicly_queryable;

    /**
     * @var bool
     */
    protected $show_in_admin_status_list;

    /**
     * @var bool
     */
    protected $show_in_admin_all_list;

    /**
     * @var bool
     */
    protected $_builtin;

    /**
     * - WP Statuses
     *
     * @see https://github.com/imath/wp-statuses#registering-a-custom-status
     */

    /**
     * @var array
     */
    protected $post_type;

    /**
     * @var bool
     */
	protected $show_in_metabox_dropdown;

    /**
     * @var bool
     */
	protected $show_in_inline_dropdown;

    /**
     * @var bool
     */
	protected $show_in_press_this_dropdown;

    /**
     * @var array
     */
	protected $labels;

    /**
     * @var string
     */
	protected $dashicon;

    /**
     * Private attributes list
     */
    protected static $privateAttrs = [
        'post_type',
        // Built in
        '_builtin',
    ];

    /**
     * Attributes list that must be boolean
     */
    protected static $booleanAttrs = [
        // Core
        'exclude_from_search',
        'public',
        'internal',
        'protected',
        'private',
        'publicly_queryable',
        'show_in_admin_status_list',
        'show_in_admin_all_list',
        // WP Statuses
        'show_in_metabox_dropdown',
    	'show_in_inline_dropdown',
    	'show_in_press_this_dropdown',
    ];

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
        if ( $key === 'label_count' ) {
            if ( is_string( $args[0] ) ) {
                $this->label_count = _n_noop( $args[0] . ' <span class="count">(%s)</span>', $args[0] . ' <span class="count">(%s)</span>' );
            }
            else if ( is_array( $args[0] ) && count( $args[0] ) === 2 ) {
                $singular = array_shift( $args[0] );
                $plural = array_shift( $args[0] );
                if ( $singular && $plural && is_string( $singular ) && is_string( $plural ) ) {
                    $this->label_count = _n_noop( $singular . ' <span class="count">(%s)</span>', $plural . ' <span class="count">(%s)</span>' );
                }
            }
            return;
        }
        parent::set( $key, ...$args );
    }

    /**
     * Return array value converted from properties
     *
     * @access public
     *
     * @return array
     */
    public function toArray() {
        if ( ! $this->label_count ) {
            if ( $this->label ) {
                $this->label_count = _n_noop( $this->label . ' <span class="count">(%s)</span>', $this->label . ' <span class="count">(%s)</span>' );
            }
        }
        return parent::toArray();
    }

}
