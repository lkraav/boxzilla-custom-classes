<?php
/*
Plugin Name: Boxzilla, Wrapped
Plugin URI: https://conversionready.com
Description: Uses `add_filter boxzilla_box_content` to wrap box content into a customizable `<div>`
Version: 2016.11.14
Author: Leho Kraav
Author URI: https://conversionready.com
*/

final class Boxzilla_Wrapped {

    /**
     * @since 2016.11.14
     */
    public static function plugins_loaded() {

        if ( ! defined( 'BOXZILLA_VERSION' ) ) {
            return;
        }

        /**
         * Example default output
         *
         * <div id="boxzilla-wrap-3439" class="boxzilla-slug-some-title-here boxzilla-title-some-title-here boxzilla-wrap">
         *     {$content}
         * </div>
         *
         * In translation scenarios, it may make sense to have a separate fixed
         * slug for commong styling vs localized human-readable titles
         *
         * @since 2016.11.14
         */
        add_filter( 'boxzilla_box_content', function( $content, $box ) {

            $attr['id'] = 'boxzilla-wrap-' . $box->ID;

            $attr['class'] = [
                'boxzilla-slug-' . get_post_field( 'post_name', $box->ID ),
                'boxzilla-title-' . sanitize_title( $box->title ),
                'boxzilla-wrap',
            ];

            $attr = apply_filters( 'boxzilla_wrap_attr', $attr );

            $content = sprintf( '<div %1$s>%2$s</div>',
                static::attr2text( $attr ),
                $content
            );

            return $content;

        }, 10, 2 );

    }

    /**
     * @since 2016.11.14
     */
    private static function attr2text( $attr ) {

        $out = '';

        foreach ( $attr as $name => $value ) {

            if ( is_array( $value ) ) {
                $value = join( ' ', $value );
            }

            $out .= $value ? sprintf( ' %s="%s"', esc_html( $name ), esc_attr( $value ) ) : esc_html( " {$name}" );

        }

        return trim( $out );

    }

}

add_action( 'plugins_loaded', [ 'Boxzilla_Wrapped', 'plugins_loaded' ] );
