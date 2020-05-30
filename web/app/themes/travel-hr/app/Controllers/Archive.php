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

    public static function getAlphaPagination()
    {
        $taxonomy = 'glossary';
        $query_obj = get_queried_object();
        $alpha_archive_name = 'hr_'.$query_obj->name.'_archive_alphabet';
        // save the terms that have posts in an array as a transient
        if ( false === ( $alphabet = get_transient( $alpha_archive_name ) ) ) {
            // It wasn't there, so regenerate the data and save the transient
            $terms = get_terms($taxonomy);

            $alphabet = array();
            if($terms){
                foreach ($terms as $term){
                    $alphabet[] = $term->slug;
                }
            }
            set_transient( $alpha_archive_name, $alphabet );
        }
        // write_log($alphabet);

        print '<div id="archive-menu" class="row cc-row archive__navigation-row space-around">';

            foreach(range('a', 'z') as $i) :

                $current = ($i == get_query_var($taxonomy)) ? "current-menu-item" : "menu-item";

                if (in_array( $i, $alphabet )){
                    printf( '<a class="page-numbers %s" href="%s">%s</a>', $current, get_term_link( $i, $taxonomy ), strtoupper($i) );
                } else {
                    printf( '<div class="page-numbers %s">%s</div>', $current, strtoupper($i) );
                }

            endforeach;

        print '</div>';
    }
}
