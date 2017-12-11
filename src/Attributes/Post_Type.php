<?php

namespace Mimosafa\WP\EntityDesign\Attributes;

class Post_Type extends Attributes {

    /**
     * Default args
     *
     * @access protected
     * @see https://developer.wordpress.org/reference/classes/wp_post_type/set_props/
     */

    /**
     * @var array
     */
    protected $labels;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var bool
     */
    protected $public;

    /**
     * @var bool
     */
    protected $hierarchical;

    /**
     * @var bool
     */
    protected $exclude_from_search;

    /**
     * @var bool
     */
    protected $publicly_queryable;

    /**
     * @var bool
     */
    protected $show_ui;

    /**
     * @var bool|string
     */
    protected $show_in_menu;

    /**
     * @var bool
     */
    protected $show_in_nav_menus;

    /**
     * @var bool
     */
    protected $show_in_admin_bar;

    /**
     * @var int
     */
    protected $menu_position;

    /**
     * @var string
     */
    protected $menu_icon;

    /**
     * @var string|array
     */
    protected $capability_type;

    /**
     * @var array
     */
    protected $capabilities;

    /**
     * @var bool
     */
    protected $map_meta_cap;

    /**
     * @var array|bool
     */
    protected $supports;

    /**
     * @var callable
     */
    protected $register_meta_box_cb;

    /**
     * @var array
     */
    protected $taxonomies;

    /**
     * @var bool|string
     */
    protected $has_archive;

    /**
     * @var bool|string|array
     */
    protected $rewrite;

    /**
     * @var string|bool
     */
    protected $query_var;

    /**
     * @var bool
     */
    protected $can_export;

    /**
     * @var bool
     */
    protected $delete_with_user;

    /**
     * @var bool
     */
    protected $show_in_rest;

    /**
     * @var string
     */
    protected $rest_base;

    /**
     * @var string
     */
    protected $rest_controller_class;

    /**
     * @var bool
     */
    protected $_builtin;

    /**
     * @var string
     */
    protected $_edit_link;

    /**
     * Private attributes list
     */
    protected static $privateAttrs = [
        'taxonomies',
        // Builtin params
        '_builtin',
        '_edit_link',
    ];

    /**
     * Attributes list that must be string
     */
    protected static $stringAttrs = [
        'description',
    ];

    /**
     * Attributes list that must be boolean
     */
    protected static $booleanAttrs = [
        'public',
        'hierarchical',
        'map_meta_cap',
        'can_export',
        'show_in_rest',
        'exclude_from_search',
        'publicly_queryable',
        'show_ui',
        'show_in_nav_menus',
        'show_in_admin_bar',
        'delete_with_user',
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
        if ( $key === 'has_archive' ) {
            $bool = filter_var( $args[0], \FILTER_VALIDATE_BOOLEAN, \FILTER_NULL_ON_FAILURE );
            if ( is_bool( $bool ) ) {
                $this->has_archive = $bool;
                return;
            }
            if ( $string = filter_var( $args[0] ) ) {
                $this->has_archive = $string;
                return;
            }
            return;
        }
        parent::set( $key, ...$args );
    }

}
