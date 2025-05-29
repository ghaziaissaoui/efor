<?php

function cptui_register_my_cpts_talent()
{
    /**
     * Post Type: Talents.
     */

    $labels = [
        "name" => esc_html__("Talents", "efor"),
        "singular_name" => esc_html__("Talent", "efor"),
    ];

    $args = [
        "label" => esc_html__("Talents", "efor"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "rest_namespace" => "wp/v2",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "can_export" => false,
        "rewrite" => ["slug" => "talent", "with_front" => true],
        "query_var" => true,
        "supports" => ["title", "editor", "thumbnail", "custom-fields", "excerpt"],
        "show_in_graphql" => false,
    ];

    register_post_type("talent", $args);
}

add_action('init', 'cptui_register_my_cpts_talent');

function cptui_register_my_taxes_location()
{
    /**
     * Taxonomy: Locations.
     */

    $labels = [
        "name" => esc_html__("Locations", "talent"),
        "singular_name" => esc_html__("Location", "talent"),
    ];


    $args = [
        "label" => esc_html__("Locations", "talent"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => false,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => 'location', 'with_front' => true,],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "show_tagcloud" => false,
        "rest_base" => "location",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "rest_namespace" => "wp/v2",
        "show_in_quick_edit" => false,
        "sort" => false,
        "show_in_graphql" => false,
    ];
    register_taxonomy("location", ["talent"], $args);
}

add_action('init', 'cptui_register_my_taxes_location');

function cptui_register_my_cpts_implantation()
{
    /**
     * Post Type: Implantations.
     */

    $labels = [
        "name" => esc_html__("Implantations", "efor"),
        "singular_name" => esc_html__("Implantation", "efor"),
    ];

    $args = [
        "label" => esc_html__("Implantations", "efor"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => false,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "rest_namespace" => "wp/v2",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "can_export" => false,
        "rewrite" => ["slug" => "implantation", "with_front" => true],
        "query_var" => true,
        "supports" => [
            "title",
            "editor",
            "thumbnail",
        ],
        "show_in_graphql" => false,
    ];

    register_post_type("implantation", $args);
}

add_action('init', 'cptui_register_my_cpts_implantation');

function cptui_register_my_taxes_region()
{
    /**
     * Taxonomy: Régions.
     */

    $labels = [
        "name" => esc_html__("Régions", "efor"),
        "singular_name" => esc_html__("Région", "efor"),
    ];


    $args = [
        "label" => esc_html__("Régions", "efor"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => false,
        "hierarchical" => false,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => 'region', 'with_front' => true,],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "show_tagcloud" => false,
        "rest_base" => "region",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "rest_namespace" => "wp/v2",
        "show_in_quick_edit" => false,
        "sort" => false,
        "show_in_graphql" => false,
    ];
    register_taxonomy("region", ["implantation",], $args);
}
add_action('init', 'cptui_register_my_taxes_region');

function cptui_register_my_taxes_continent()
{
    $labels = [
        "name" => esc_html__("Continents", "efor"),
        "singular_name" => esc_html__("Continent", "efor"),
        "menu_name" => esc_html__("Continents", "efor"),
        "all_items" => esc_html__("Tous les continents", "efor"),
        "edit_item" => esc_html__("Modifier le continent", "efor"),
        "view_item" => esc_html__("Voir le continent", "efor"),
        "update_item" => esc_html__("Mettre à jour le continent", "efor"),
        "add_new_item" => esc_html__("Ajouter un nouveau continent", "efor"),
        "new_item_name" => esc_html__("Nom du nouveau continent", "efor"),
        "search_items" => esc_html__("Rechercher des continents", "efor"),
    ];

    $args = [
        "label" => esc_html__("Continents", "efor"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => false,
        "hierarchical" => false,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => 'continent', 'with_front' => true],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "show_tagcloud" => false,
        "rest_base" => "continent",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "rest_namespace" => "wp/v2",
        "show_in_quick_edit" => false,
        "sort" => false,
        "show_in_graphql" => false,
    ];

    register_taxonomy("continent", ["implantation"], $args);
}

add_action('init', 'cptui_register_my_taxes_continent');

function cptui_register_my_taxes_country()
{
    $labels = [
        "name" => esc_html__("Pays", "efor"),
        "singular_name" => esc_html__("Pays", "efor"),
        "menu_name" => esc_html__("Pays", "efor"),
        "all_items" => esc_html__("Tous les pays", "efor"),
        "edit_item" => esc_html__("Modifier le pays", "efor"),
        "view_item" => esc_html__("Voir le pays", "efor"),
        "update_item" => esc_html__("Mettre à jour le pays", "efor"),
        "add_new_item" => esc_html__("Ajouter un nouveau pays", "efor"),
        "new_item_name" => esc_html__("Nom du nouveau pays", "efor"),
        "search_items" => esc_html__("Rechercher des pays", "efor"),
    ];

    $args = [
        "label" => esc_html__("Countries", "efor"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => false,
        "hierarchical" => false,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => 'country', 'with_front' => true],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "show_tagcloud" => false,
        "rest_base" => "country",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "rest_namespace" => "wp/v2",
        "show_in_quick_edit" => false,
        "sort" => false,
        "show_in_graphql" => false,
    ];

    register_taxonomy("country", ["implantation"], $args);
}

add_action('init', 'cptui_register_my_taxes_country');
