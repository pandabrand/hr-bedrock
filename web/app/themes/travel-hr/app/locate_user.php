<?php
namespace App;

use Roots\Sage\Assets;

add_action('wp_enqueue_scripts', function() {
    if( is_single() || is_tax( 'location_types' ) ):
        $args = array(
        "post_type" => "city",
        'post_status' => 'publish',
        "numberposts" => -1,
        'tax_query'=> array(
            array(
                'taxonomy' => 'hotel',
                'field' => 'slug',
                'terms' => 'reverb',
                'operator' => 'NOT IN'
            ),
        ),
        );
        $cities = get_posts( $args );
        $map_info = array( 'cities' => array( ) );
        foreach($cities as $city) {
        $city_output = array(
            'city_id' => $city->ID,
            'title' => get_the_title($city->ID),
            'link' => get_the_permalink($city->ID),
            'location' => get_field('city_location', $city->ID)
        );
        $map_info['cities'][] = $city_output;
        }

        wp_register_script( 'ajax-script', asset_path('scripts/main.js'), array('jquery'), null, true ); // jQuery will be included automatically
        wp_localize_script( 'ajax-script', 'map_info', $map_info );
        wp_enqueue_script('ajax-script');

        wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) ); // setting ajaxurl
    endif;
    }
);
