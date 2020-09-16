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
        $reverb_cities = App::reverb_cities();
        // $artists = wp_cache_get( 'artists_five' );
        if( true ) //false === $artists )
        {
            $meta_query = array(
                'relation' => 'AND',
                array(
                    'relation' => 'OR',
                    array (
                        'key'   => 'vibe_manager',
                        'compare' => 'NOT EXISTS',
                    ),
                    array (
                        'key'   => 'vibe_manager',
                        'compare'   => '=',
                        'value' => '0',
                    ),
                ),
            );

            if( !empty( $reverb_cities ) )
            {
                $reverb_array = array(
                    'relation' => 'AND'
                );

                foreach( $reverb_cities as $city_id ) {
                    $reverb_array[] = array(
                        'key' => 'artist_city',
                        'value' => '"' . $city_id . '"',
                        'compare' => 'NOT LIKE',
                    );
                }
                $meta_query[] = $reverb_array;
            }

            $args = array(
                'post_type' => 'artist',
                'posts_per_page' => 4,
                'orderby' => 'rand',
                'meta_query' => $meta_query,
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
                        'full_post' => $post
                    );
                }
            }
            // wp_cache_set( 'artists_five', $artists );
        }
        return $artists;
    }

    public function banner_content() {
        global $post;
        $banner_content = array();
        if( $banner_image = get_field('banner_image', $post->ID) )
        {
            $banner_content['image'] =  wp_get_attachment_image_url(
                $banner_image,
                'front-page-image'
            );
        }

        $banner_content['title'] = get_field('banner_title', $post->ID) ?? '';
        $banner_content['content'] = get_field('banner_copy', $post->ID) ?? '';
        $banner_content['link_text'] = get_field('banner_link_text', $post->ID) ?? '';
        $banner_content['link'] = get_field('banner_link', $post->ID) ?? '';

        return $banner_content;
    }
}
