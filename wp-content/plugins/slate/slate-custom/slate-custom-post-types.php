<?php
/**
 * Slate Custom Post Types
 *
 * This file is reserved for registering custom post types using the Slate_Post_Type class.
 *
 * @since 1.0
 *
 * @package WordPress
 * @subpackage Slate
 */

class Slate_Custom_Post_Types {

    public function __construct() {

        add_action('init', array($this, 'slate_post_type_init'));

    }

    /**
     * Registers post types.
     *
     * This class handles the registering of multiple post types.
     *
     * @since 1.0
     */
    public function slate_post_type_init() {

        new Slate_Post_Type('Characters', array(
            'has_archive' => true,
            'rewrite' => array(
                'with_front' => false,
                'slug' => 'characters'
            )
        ));

        new Slate_Post_Type('Items', array(
            'has_archive' => true,
            'rewrite' => array(
                'with_front' => false,
                'slug' => 'items'
            )
        ));

        new Slate_Post_Type('Games', array(
            'has_archive' => true,
            'rewrite' => array(
                'with_front' => false,
                'slug' => 'game-library'
            )
        ));

    }

}
