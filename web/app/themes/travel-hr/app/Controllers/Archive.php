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

    public static function hrLoadMoreAjaxScripts()
    {
        global $wp_query;
        wp_register_script('loadmore_js', \App\asset_path('scripts/load_more.js'), array('jquery'), null, true);

        wp_localize_script( 'loadmore_js', 'hr_loadmore_params', [
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'posts' => json_encode( $wp_query->query_vars ),
            'current_page' => get_query_var( 'paged' ) ?? 1,
            'max_page' => $wp_query->max_num_pages
            ]
        );

        wp_enqueue_script('loadmore_js');
    }

    public static function loadMorePagination()
    {
        global $wp_query;

        if (  $wp_query->max_num_pages > 1 )
        {
            echo '<div><button class="btn btn-primary hr-loadmore">Load More</button></div>';
        }
    }

    public static function hrLoadMoreAjaxHandler()
    {
        $args = json_decode( stripslashes( $_POST['query'] ), true );
        $args['paged'] = $args['paged'] + 1;
        $args['post_status'] = 'publish';
        $ajaxposts = new \WP_Query( $args );

        $GLOBALS['wp_query'] = $ajaxposts;

        if( $ajaxposts->have_posts() )
        {
            while( $ajaxposts->have_posts() )
            {
                $ajaxposts->the_post();
                echo \App\template('partials.content-'.get_post_type());
            }

        }
        wp_die();
    }
}
