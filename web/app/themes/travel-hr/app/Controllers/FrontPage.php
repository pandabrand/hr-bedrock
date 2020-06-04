<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class FrontPage extends Controller
{
    public function image_id()
    {
        return get_post_thumbnail_id();
    }

    public function artists()
    {
        // $artists = wp_cache_get( 'artists_five' );
        if( true ) //false === $artists )
        {
            $args = array(
                'post_type' => 'artist',
                'posts_per_page' => 4,
                'meta_query' => array(
                    'key'   => 'vibe_manager',
                    'value' => '1',
                    'compare' => 'NOT'
                )
            );

            $query = new \WP_Query( $args );

            if( $query->post_count > 0 )
            {
                foreach( $query->posts as $post )
                {
                    $summary = ( has_excerpt( $post->ID ) ) ? $post->post_excerpt : wp_trim_words( $post->post_content, '35', '...' );
                    $artists[] = array(
                        'image' => wp_get_attachment_image(
                            get_post_thumbnail_id( $post->ID ),
                            'medium',
                            false,
                            array( 'class' => 'img-fluid' )
                        ),
                        'name' => $post->post_title,
                        'link' => get_the_permalink( $post->ID ),
                        'summary' => $summary,
                        'locations' => array_slice( get_field( 'artists_locations', $post ), 0, 4 )
                    );
                }
            }
            // wp_cache_set( 'artists_five', $artists );
        }
        return $artists;
    }
}
