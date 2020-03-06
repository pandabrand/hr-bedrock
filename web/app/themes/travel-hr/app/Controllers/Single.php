<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use App;

class Single extends Controller
{
    public function locations()
    {
        if( get_post_type() == 'artist' )
        {
            $locations = get_field('artists_locations');
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

    public static function location_city_object( $location = null )
    {
        $id = ($location == null) ? get_the_ID() : $location->ID;

        $location_city_id = get_field('location_city', $id);

        return (!empty($location_city_id)) ? get_post($location_city_id[0])->post_name : '';
    }

    public static function large_url( $location = null )
    {
        $id = ($location == null) ? get_the_ID() : $location->ID;

        return esc_url( wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large-feature' )[0] );
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
        return ( get_post_type() == 'artist') ? $location_arr['location'][0] : $location_arr;
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
        $args = array(
            'post_type' => get_post_type(),
            'orderby'   => 'rand',
            'posts_per_page' => 4,
            'exclude' => array(get_the_ID()),
        );

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
}
