<?php
/**
 * Slate Custom Taxonomies
 *
 * This file is reserved for registering custom taxonomies using the Slate_Taxonomy class.
 *
 * @since 1.0
 *
 * @package WordPress
 * @subpackage Slate
 */

class Slate_Custom_Taxonomies {

    public function __construct() {

        add_action('init', array($this, 'slate_taxonomy_init'));

    }

    /**
     * Registers taxonomies.
     *
     * This class handles the registering of multiple taxonomies.
     */

    public function slate_taxonomy_init() {
        new Slate_Taxonomy('Character Categories', 'characters');
        new Slate_Taxonomy('Item Categories', 'items');
    }

}