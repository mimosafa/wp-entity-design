<?php

namespace Mimosafa\WP\EntityDesign\Attributes;

class Taxonomy extends Attributes {

    /**
     * Default args
     *
     * @access protected
     * @see https://developer.wordpress.org/reference/classes/wp_taxonomy/set_props/
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
    protected $publicly_queryable;

    /**
     * @var bool
     */
    protected $hierarchical;

    /**
     * @var bool
     */
    protected $show_ui;

    /**
     * @var bool
     */
    protected $show_in_menu;

    /**
     * @var bool
     */
    protected $show_in_nav_menus;

    /**
     * @var bool
     */
    protected $show_tagcloud;

    /**
     * @var bool
     */
    protected $show_in_quick_edit;

    /**
     * @var bool
     */
    protected $show_admin_column;

    /**
     * @var callable|bool
     */
    protected $meta_box_cb;

    /**
     * @var array
     */
    protected $capabilities;

    /**
     * @var bool|array
     */
    protected $rewrite;

    /**
     * @var string
     */
    protected $query_var;

    /**
     * @var callable
     */
    protected $update_count_callback;

    /**
     * @var bool
     */
    protected $show_in_rest;

    /**
     * @var string
     */
    protected $rest_base;

    /**
     * @var string REST API Controller class name
     */
    protected $rest_controller_class;

    /**
     * @var bool
     */
    protected $_builtin;

    /**
     * Private attributes list
     */
    protected static $privateAttrs = [
        // Built in
        '_builtin',
    ];

    /**
     * Attributes list that must be string
     */
    protected static $stringAttrs = [
        'description',
        'query_var',
    ];

    /**
     * Attributes list that must be boolean
     */
    protected static $booleanAttrs = [
        'public',
        'publicly_queryable',
        'hierarchical',
        'show_ui',
        'show_in_menu',
        'show_in_nav_menus',
        'show_tagcloud',
        'show_in_quick_edit',
        'show_admin_column',
        'show_in_rest',
    ];

}
