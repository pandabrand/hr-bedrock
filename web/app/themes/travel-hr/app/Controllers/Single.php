<?php

namespace App\Controllers;

use Sober\Controller\Controller;

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
}
