<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }
        if(is_post_type_archive('city')) {
            return __('Area Guides', 'hr__domain');
        }

        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'sage');
        }
        return get_the_title();
    }

    public static function title_for_type( $type )
    {
        switch ($type) {
            case 'city':
                $title = 'Cities';
                break;

            case 'artist':
                $title = 'Artists';
                break;

            case 'vibe-manager':
                $title = 'Vibe Managers';
                break;

            default:
                $title = 'Categories';
                break;
        }
        return $title;
    }

    public static function posts_for_menu( $post_type )
    {
        if( 'location_types' == $post_type )
        {

            $args = array(
                "taxonomy" => "location_types",
                "hide_empty" => true,
                "orderby" => "name",
                "order" => "ASC",
                'number' => 25
            );

            $items = get_terms($args);
        }
        else
        {
            $args = array(
                'post_type' => $post_type,
                'posts_per_page' => 25,
                "orderby" => "title",
                "order" => "ASC"
            );

            $query = new \WP_Query( $args );
            $items = $query->posts;
        }
        return $items;
    }

    public static function selected_city_menu( $city_option )
    {
        $selected_city = get_query_var('cat_city');
        // $cat_query_params['cat_city'] = $selected_city;
        return ($selected_city == $city_option->ID) ? 'selected' : '';
    }

    public static function show_active_for_post( $current_post )
    {
        return ( !empty( $current_post ) && $current_post->ID == get_the_ID() ) ? ' active' : '';
    }

    public static function dropdown_notice()
    {
        // $notice = (get_post_type() != 'artist' && !is_tax()) ? 'Artists : '. $cat_city_name : $cat_city_name;
        // if(get_post_type() == 'artist') {
        //   $notice .= ' : '. $subject;
        // }
        return '';
    }

    public static function menu_for_artists()
    {

        // $travel_page = get_page_by_path( 'travel' );
        // $travel_title = $travel_page->post_title;
        // $travel_sub_title = wp_strip_all_tags( $travel_page->post_content, true );
        $reservedObj = get_category_by_slug('reserved');
        $reservedId = $reservedObj->term_id;
        global $post;
        $cat_city_name;
        $artist_city;
        $cat_query_params = array();
        if(get_post_type() == 'artist') {
            $artist_city = get_field('artist_city', $post->ID)[0];
            $subject = $post->post_title;
            $cat_city_name = $artist_city->post_title;
            $cat_city_id = $artist_city->ID;
            $cat_query_params['cat_artist'] = $post->post_name;
            $cat_query_params['cat_city'] = $cat_city_id;
        } elseif ( get_post_type() == 'city' ) {
            $cat_city_name = $post->post_title;
            $cat_city_id = $post->ID;
            $cat_query_params['cat_city'] = $cat_city_id;
        } elseif ( is_tax( 'location_types' ) && get_query_var('cat_city') ) {
            $cat_city_id = get_query_var('cat_city');
            $tax_city = get_post( $cat_city_id );
            $cat_city_name = $tax_city->post_title;
        }

        $args = array(
          "post_type" => "artist",
          "orderby" => "title",
          "order" => "ASC",
          "numberposts" => "25"
        );

        if( get_post_type() == 'city'
            || get_post_type() == 'artist'
            || ( is_tax( 'location_types' ) && get_query_var('cat_city') )
          )
        {
          $city_id = (get_post_type() == 'city') ? $post->ID : $artist_city->ID;
          if(!$city_id) {
            $city_id = get_query_var('cat_city');
          }
          $meta = array(
            array(
              "key" => "artist_city",
              "value" => $city_id,
              "compare" => "LIKE"
            )
          );
          $args["meta_query"] = $meta;
        }

        $artists = get_posts( $args );
        return $artists;
    }

    public static function ref_for_object( $location )
    {
        if( !empty( $location ) ) {
            $id = $location->ID;
        }
        else
        {
            $id = get_the_ID();
        }
        return $id;
    }

    public static function get_website_for_location( $location = null )
    {
        $id = ( $location == null ) ? get_the_ID() : $location->ID;
        return get_field('website', $id );
    }

    public static function reverb_cities() {
        $args = array(
            'post_type' => 'city',
            'tax_query' => array(
                array(
                    'taxonomy' => 'hotel',
                    'field' => 'slug',
                    'terms' => 'reverb',
                    'operator' => 'IN'
                ),
            )
        );

        $posts = get_posts( $args );
        $city_ids = wp_list_pluck( $posts, 'ID' );
        return $city_ids;
    }
}
