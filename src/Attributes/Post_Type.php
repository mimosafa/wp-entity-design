<?php

namespace Mimosafa\WP\EntityDesign\Attributes;

class Post_Type extends Attributes {

    /**
     * Default args
     *
     * @access protected
     * @see https://developer.wordpress.org/reference/classes/wp_post_type/set_props/
     */
    protected $labels                = [];
    protected $description           = '';
    protected $public                = false;
    protected $hierarchical          = false;
    protected $exclude_from_search   = null;
    protected $publicly_queryable    = null;
    protected $show_ui               = null;
    protected $show_in_menu          = null;
    protected $show_in_nav_menus     = null;
    protected $show_in_admin_bar     = null;
    protected $menu_position         = null;
    protected $menu_icon             = null;
    protected $capability_type       = 'post';
    protected $capabilities          = [];
    protected $map_meta_cap          = null;
    protected $supports              = [];
    protected $register_meta_box_cb  = null;

    /**
     * @var array
     */
    protected $taxonomies = [];
    
    protected $has_archive           = false;
    protected $rewrite               = true;
    protected $query_var             = true;
    protected $can_export            = true;
    protected $delete_with_user      = null;
    protected $show_in_rest          = false;
    protected $rest_base             = false;
    protected $rest_controller_class = false;
    protected $_builtin              = false;
    protected $_edit_link            = 'post.php?post=%d';

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

}
