<?php

namespace Mimosafa\WP\EntityDesign\Attributes;

class Taxonomy extends Attributes {

    /**
     * Default args
     *
     * @access protected
     * @see https://developer.wordpress.org/reference/classes/wp_taxonomy/set_props/
     */
    protected $labels                = [];
    protected $description           = '';
    protected $public                = true;
    protected $publicly_queryable    = null;
    protected $hierarchical          = false;
    protected $show_ui               = null;
    protected $show_in_menu          = null;
    protected $show_in_nav_menus     = null;
    protected $show_tagcloud         = null;
    protected $show_in_quick_edit    = null;
    protected $show_admin_column     = false;
    protected $meta_box_cb           = null;
    protected $capabilities          = [];
    protected $rewrite               = true;
    protected $query_var             = null; // If undefined, null
    protected $update_count_callback = '';
    protected $show_in_rest          = false;
    protected $rest_base             = false;
    protected $rest_controller_class = false;
    protected $_builtin              = false;

    /**
     * Object types
     */
    protected $object_types = [];

    /**
     * Private attributes list
     */
    protected static $privateAttrs = [
        '_builtin',
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
        //
    ];

}
