<?php
/*
Plugin Name: Boxzilla Custom Classes
Plugin URI: https://conversionready.com
Description: Uses `boxzilla_box_client_options` and Boxzilla JS API to inject custom classes for styling. Adds post slug and title classes by default.
Version: 2016.11.16
Author: Leho Kraav
Author URI: https://conversionready.com
*/

final class Boxzilla_Custom_Classes {

    private static $plugin_dir_path;

    private static $plugin_dir_url;

    private static $slug;

    /**
     * @since 2016.11.14
     */
    public static function plugins_loaded() {

        if ( ! defined( 'BOXZILLA_VERSION' ) ) {
            return;
        }

        static::$plugin_dir_path = untrailingslashit( plugin_dir_path( __FILE__ ) );

        static::$plugin_dir_url = untrailingslashit( plugin_dir_url( __FILE__ ) );

        static::$slug = basename( static::$plugin_dir_path );

        /**
         * @since 2016.11.16
         */
        add_filter( 'boxzilla_box_client_options', function( $client_options, $box ) {

            $client_options['class'] = [
                'slug' => get_post_field( 'post_name', $box->ID ),
                'title' => sanitize_title( get_post_field( 'post_title', $box->ID ) ),
            ];

            return $client_options;

        }, 10, 2 );

        /**
         * @see https://github.com/ibericode/boxzilla.js/issues/14
         * @since 2016.11.16
         */
        add_action( 'wp_enqueue_scripts', function() {
            wp_enqueue_script( static::$slug, static::$plugin_dir_url . '/script.js', [ 'boxzilla' ], '2016.11.16' );
        } );

    }

}

add_action( 'plugins_loaded', [ 'Boxzilla_Custom_Classes', 'plugins_loaded' ] );
