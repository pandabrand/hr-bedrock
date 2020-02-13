<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Archive extends Controller
{
    public static function getTermName()
    {
        $term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
        return ( !empty( $term ) ) ? $term->name : '';
    }

    public static function getPostNav()
    {
        return paginate_links(
            array(
              'prev_text'          => sprintf( __( '<< %s' ), get_post_type() ),
              'next_text'          => sprintf( __( '%s >>' ), get_post_type() ),
              'show_all'           => true,
              'screen_reader_text' => sprintf( __( '%s Navigation' ), get_post_type() )
            )
        );
    }
}
