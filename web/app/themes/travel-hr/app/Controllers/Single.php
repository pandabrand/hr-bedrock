<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use App;

class Single extends Controller
{
    public function locations()
    {
        if( get_post_type() == 'artist' || get_post_type() == 'vibe-manager' )
        {
            $city_array = get_field( 'artist_city' );

            if( !empty( $city_array ) )
            {
                $city = array_pop( $city_array );

                $hotels_cat = get_the_terms( $city->ID, 'hotel' );

                if( !empty( $hotels_cat ) && !is_wp_error( $hotels_cat ) )
                {
                    $categories = wp_list_pluck( $hotels_cat, 'name' );
                }

                if( !empty( $categories ) && in_array( 'Reverb', $categories ) )
                {
                    $locations = array();
                }
                else
                {
                    $locations = get_field('artists_locations');
                }
            }
        }
        elseif( get_post_type() == 'city' )
        {
            $locations = get_posts(array(
                "numberposts" => -1,
                "post_type" => "location",
                "meta_query" => array(
                    array(
                        'key' => 'location_city',
                        'compare' => 'LIKE',
                        'value' => '"'.get_the_ID().'"'
                    ),
                )
            ));
        }
        return $locations;
    }

    public static function get_city_background_image( $location = null )
    {
        $id = ($location == null) ? get_the_ID() : $location->ID;
        $size = ( 'city' == \get_post_type( $id ) ) ? 'front-page-image' : 'full';

        if($image_id = get_field( 'background_image', $id ) )
        {
            $image_url = wp_get_attachment_image_url($image_id, $size);
        }
        else
        {
            $image_url = get_the_post_thumbnail_url($id, $size);
        }

        return $image_url;
    }

    public static function location_city_object( $location = null )
    {
        $id = ($location == null) ? get_the_ID() : $location->ID;

        $location_city_array = get_field('location_city', $id);

        $location_name = '';

        if ( !empty( $location_city_array ) )
        {
            $location_city_id = array_pop( $location_city_array );

            $location_city = get_post( $location_city_id );

            $location_name = ($location_city) ? $location_city->post_name : '';

        }
        return  $location_name;
    }

    public static function instagram_url( $location = null )
    {
        $id = $location->ID ?? get_the_ID();

        return get_field( 'instagram_url', $id );
    }

    public static function instagram_image_url( $location = null )
    {
        $id = $location->ID ?? get_the_ID();

        if( !empty( $instagram_image = get_field( 'instagram_image', $id ) ) )
        {
            $pattern = '/(^https?:\/\/www.instagram.com\/p\/[0-9a-zA-Z-_]*\/)/';

            $url = ( preg_match( $pattern, $instagram_image, $matches ) ) ? $matches[1] . 'media/?size=l' : null;

            $curl_options = array(
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_POSTFIELDS => array(),
                CURLOPT_POST => FALSE,
                CURLOPT_NOBODY => TRUE,
                CURLOPT_FOLLOWLOCATION => true,
            );

            $ch = curl_init();
            curl_setopt_array($ch, $curl_options);
            $response['result'] = curl_exec($ch);
            $response['error'] 	= curl_error($ch);
            $response['info'] 	= curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

            curl_close($ch);

            return $response['info'] ?? null;

        }
        else
        {
            return null;
        }
    }

    public static function large_url( $location = null )
    {
        $id = ($location == null) ? get_the_ID() : $location->ID;

        $location_image = Single::instagram_image_url($location) ?? esc_url( wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large-feature' )[0] );

        return $location_image;
    }

    public static function artist_posts( $location = null )
    {
        $id = ($location == null) ? get_the_ID() : $location->ID;
        global $wpdb;
        return $wpdb->get_results(
          "SELECT wp_postmeta.* FROM wp_postmeta
          LEFT OUTER JOIN wp_posts ON wp_postmeta.post_id = wp_posts.ID WHERE wp_postmeta.meta_key LIKE 'artists_locations_%_location' AND wp_postmeta.meta_value LIKE '%{$id}%'
          AND wp_posts.post_status = 'publish'"
          , OBJECT );
    }

    public static function location_for_array( $location_arr )
    {
        if( !is_array( $location_arr ) && $location_arr instanceof \WP_Post ) {
            return $location_arr;
        }

        $array_for_location = $location_arr['location'];
        $location = null;

        if( !empty( $array_for_location ) )
        {
            $location = array_pop( $array_for_location );
        }

        return ( get_post_type() == 'artist' || get_post_type() == 'vibe-manager' ) ? $location : $location_arr;
    }

    public static function address( $location = null )
    {
        $id = ($location == null) ? get_the_ID() : $location->ID;
        return get_field('address', $id)['address'];
    }

    public static function latLng( $location = null )
    {
        $id = ($location == null) ? get_the_ID() : $location->ID;
        $address = get_field('address', $id);
        return ['lat' => $address['lat'], 'lng' => $address['lng']];
    }

    public function additional_posts()
    {
        $reverb_cities = App::reverb_cities();
        $args = array();
        if ( get_post_type() == 'artist' || get_post_type() == 'vibe-manager' ) {
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
                'post_type' => get_post_type(),
                'orderby'   => 'rand',
                'posts_per_page' => 4,
                'meta_query' => $meta_query,
                'exclude' => array(get_the_ID()),
            );
        }

        if ( get_post_type() == 'city' ) {
            $args = array(
                'post_type' => get_post_type(),
                'orderby'   => 'rand',
                'posts_per_page' => 4,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'hotel',
                        'field' => 'slug',
                        'terms' => 'reverb',
                        'operator' => 'NOT IN'
                    ),
                )
            );
        }

        $posts = array_map(
            function( $post ) {
                return array(
                    'link' => get_the_permalink($post->ID),
                    'image' => get_the_post_thumbnail_url($post, 'large-feature'),
                    'icon_class' => App\get_post_icon_class($post),
                    'category_type_title' => App\get_category_type_title($post),
                    'subject' => App\get_category_type_subject($post),
                    'title' => App\get_card_title($post),
                    'excerpt' => App\get_card_excerpt($post),
                );
            },
            get_posts($args)
        );

        return $posts;

    }

    public function image_id()
    {
        return get_post_thumbnail_id();
    }

    public function artists()
    {

        // $artists = wp_cache_get( 'artists_five' );
        if( true ) //false === $artists )
        {
            $vibe_managers = array();
            $vibe_args = array(
                'post_type' => 'vibe-manager',
                'posts_per_page' => 1,
                'meta_query' => array(
                    array (
                        'key'   => 'artist_city',
                        'compare'   => 'LIKE',
                        'value' => '"' . get_the_ID() . '"',
                    ),
                )
            );

            $vibe_query = new \WP_Query( $vibe_args );

            if( $vibe_query->post_count > 0 )
            {
                foreach( $vibe_query->posts as $post )
                {
                    $summary = ( has_excerpt( $post->ID ) ) ? get_the_excerpt($post->ID) : wp_trim_words( $post->post_content, '35', '...' );
                    $vibe_managers[] = array(
                        'image' => wp_get_attachment_image(
                            get_post_thumbnail_id( $post->ID ),
                            'medium',
                            false,
                            array( 'class' => 'img-fluid' )
                        ),
                        'name' => $post->post_title,
                        'link' => get_the_permalink( $post->ID ),
                        'summary' => $summary,
                        'locations' => array_slice( get_field( 'artists_locations', $post ), 0, 4 ),
                        'full_post' => $post
                    );
                }
            }
            $post_per_page = count($vibe_managers) > 0 ? 3 : 4;

            $args = array(
                'post_type' => 'artist',
                'posts_per_page' => $post_per_page,
                'meta_query' => array(
                    array (
                        'key'   => 'artist_city',
                        'compare'   => 'LIKE',
                        'value' => '"' . get_the_ID() . '"',
                    ),
                )
            );

            $query = new \WP_Query( $args );

            $artists = array();
            if( $query->post_count > 0 )
            {
                foreach( $query->posts as $post )
                {
                    $summary = ( has_excerpt( $post->ID ) ) ? get_the_excerpt($post->ID) : wp_trim_words( $post->post_content, '35', '...' );
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
                        'locations' => array_slice( get_field( 'artists_locations', $post ), 0, 4 ),
                        'full_post' => $post
                    );
                }
            }
            // wp_cache_set( 'artists_five', $artists );
        }
        return array_merge($artists, $vibe_managers);
    }
}
