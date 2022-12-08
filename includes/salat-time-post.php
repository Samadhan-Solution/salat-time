<?php
namespace SalatTimes;

class TimeKeeper
{
    function __construct()
    {
        add_action('init', array( 'SalatTimes\TimeKeeper', 'define_salat_time_post_type' ),  0);
    }



    public static function define_salat_time_post_type()
    {

        // Set UI labels for Custom Post Type
        $labels = array(
            'name' => 'Salat Times',
            'singular_name' => 'Salat Time',
            'menu_name' => 'Salat Times',
            'parent_item_colon' => 'Parent Salat Time',
            'all_items' => 'All Salat Times',
            'view_item' => 'View Salat Time',
            'add_new_item' => 'Add New Salat Time',
            'add_new' => 'Add New',
            'edit_item' => 'Edit Salat Time',
            'update_item' => 'Update Salat Time',
            'search_items' => 'Search Salat Time',
            'not_found' => 'Not Found',
            'not_found_in_trash' => 'Not found in Trash'
        );

        // Set other options for Custom Post Type

        $args = array(
            'label' => 'Salat Times',
            'description' => 'Salat Time news and reviews',
            'labels' => $labels,
            // Features this CPT supports in Post Editor
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'revisions', 'page-attributes'),
            // You can associate this CPT with a taxonomy or custom taxonomy.
            'taxonomies' => array('genres'),
            /* A hierarchical CPT is like Pages and can have
            * Parent and child items. A non-hierarchical CPT
            * is like Posts.
            */
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-calendar-alt',
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'post',
            'show_in_rest' => true,

        );

        // Registering your Custom Post Type
        register_post_type('salat_times', $args);

    }

    public static function create_initial_time($title, $time, $display_order)
    {

        $record = get_page_by_title($title, OBJECT, 'salat_times');

        if (empty($record)) {
            $record = array(
                'post_title' => $title,
                'post_content' => $time,
                'menu_order' => $display_order,
                'post_status' => 'publish',
                'post_author' => 1,
                'post_type' => 'salat_times',
            );
            wp_insert_post($record);
        }
    }

    public static function create_initial_salat_times(){
        TimeKeeper::create_initial_time('Shuruq', '5:30 am', 1);
        TimeKeeper::create_initial_time('Dhuhr',  '1:25 pm',2);
        TimeKeeper::create_initial_time('Asr',  '5:40 pm',3);
        TimeKeeper::create_initial_time('Magrib',  '7:10 pm',4);
        TimeKeeper::create_initial_time('Eisha',  '9:30 pm',5);
    }
}

new TimeKeeper();
