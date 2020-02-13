<?php

namespace App;

use Roots\Sage\Assets;

add_action('wp_enqueue_scripts', function () {
  if( is_single() || is_tax( 'location_types' ) ):
    global $post;
    $json_locations = array('locations' => array());
    if( is_single() && get_post_type($post->ID) == 'artist' ) {
      if( have_rows( 'artists_locations', $post->ID ) ) {
        while( have_rows( 'artists_locations', $post->ID ) ): the_row();
          $location = get_sub_field('location')[0];
          $location_output = array(
            'location_id' => $location->ID,
            'title' => get_the_title($location->ID),
            'website' => get_field('website', $location->ID),
            'coords' => get_field('address', $location->ID)
          );
          $json_locations['locations'][] = $location_output;
        endwhile;
      }
      $related_city = get_field('artist_city', $post->ID)[0];
      $city = array(
        'title' => get_the_title($related_city->ID),
        'location' => get_field('city_location', $related_city->ID)
      );
      $json_locations['city'] = $city;
    } elseif ( is_single() && get_post_type() == 'city' ) {
      $locations = get_posts(array(
        'numberposts' => -1,
        'post_type' => 'location',
        'meta_query' => array(
          array(
            'key' => 'location_city',
            'compare' => 'LIKE',
            'value' => '"'.$post->ID.'"'
          ),
        )
      ));
      if( !empty( $locations ) ) {
        foreach($locations as $location) {
          $location_output = array(
            'location_id' => $location->ID,
            'title' => get_the_title($location->ID),
            'website' => get_field('website', $location->ID),
            'coords' => get_field('address', $location->ID)
          );
          $json_locations['locations'][] = $location_output;
        }
      }
      $city = array(
        'title' => get_the_title($post->ID),
        'location' => get_field('city_location', $post->ID)
      );
      $json_locations['city'] = $city;
    } elseif( is_tax('location_types')  ) {
        $term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

        $locations = get_posts(array(
            'post_type' => 'location',
            'numberposts' => 19,
            'tax_query' => array(array(
                'taxonomy' => $term->taxonomy,
                'field' => 'term_id',
                 'terms' => $term->term_taxonomy_id
            ))
        ));

        if( !empty( $locations ) ) {
        foreach($locations as $location) {
          $location_output = array(
            'location_id' => $location->ID,
            'title' => get_the_title($location->ID),
            'website' => get_field('website', $location->ID),
            'coords' => get_field('address', $location->ID)
          );
          $json_locations['locations'][] = $location_output;
        }
        $first = get_field('location_city', $locations[0]->ID);
        $first_city = get_post($first[0]);
        $city = array(
            'title' => get_the_title($first_city->ID),
            'location' => get_field('city_location', $first_city->ID)
        );
        $json_locations['city'] = $city;
      }
    }
    $map_info = array(
      'api_key' => MAPBOX_API,
    );
    $json_locations['map_info'] = $map_info;
    $js_data = json_encode($json_locations);
    wp_register_script('map_js', asset_path('scripts/map_data.js'), array(), null, true);
    wp_localize_script( 'map_js', 'map_vars', $js_data );
    wp_enqueue_script('map_js');
  endif;
}
);
