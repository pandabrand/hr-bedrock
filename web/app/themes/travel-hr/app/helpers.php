<?php

namespace App;

use Roots\Sage\Container;

/**
 * Get the sage container.
 *
 * @param string $abstract
 * @param array  $parameters
 * @param Container $container
 * @return Container|mixed
 */
function sage($abstract = null, $parameters = [], Container $container = null)
{
    $container = $container ?: Container::getInstance();
    if (!$abstract) {
        return $container;
    }
    return $container->bound($abstract)
        ? $container->makeWith($abstract, $parameters)
        : $container->makeWith("sage.{$abstract}", $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param array|string $key
 * @param mixed $default
 * @return mixed|\Roots\Sage\Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return sage('config');
    }
    if (is_array($key)) {
        return sage('config')->set($key);
    }
    return sage('config')->get($key, $default);
}

/**
 * @param string $file
 * @param array $data
 * @return string
 */
function template($file, $data = [])
{
    return sage('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view
 * @param $file
 * @param array $data
 * @return string
 */
function template_path($file, $data = [])
{
    return sage('blade')->compiledPath($file, $data);
}

/**
 * @param $asset
 * @return string
 */
function asset_path($asset)
{
    return sage('assets')->getUri($asset);
}

/**
 * @param string|string[] $templates Possible template files
 * @return array
 */
function filter_templates($templates)
{
    $paths = apply_filters('sage/filter_templates/paths', [
        'views',
        'resources/views'
    ]);
    $paths_pattern = "#^(" . implode('|', $paths) . ")/#";

    return collect($templates)
        ->map(function ($template) use ($paths_pattern) {
            /** Remove .blade.php/.blade/.php from template names */
            $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

            /** Remove partial $paths from the beginning of template names */
            if (strpos($template, '/')) {
                $template = preg_replace($paths_pattern, '', $template);
            }

            return $template;
        })
        ->flatMap(function ($template) use ($paths) {
            return collect($paths)
                ->flatMap(function ($path) use ($template) {
                    return [
                        "{$path}/{$template}.blade.php",
                        "{$path}/{$template}.php",
                    ];
                })
                ->concat([
                    "{$template}.blade.php",
                    "{$template}.php",
                ]);
        })
        ->filter()
        ->unique()
        ->all();
}

/**
 * @param string|string[] $templates Relative path to possible template files
 * @return string Location of the template
 */
function locate_template($templates)
{
    return \locate_template(filter_templates($templates));
}

/**
 * Determine whether to show the sidebar
 * @return bool
 */
function display_sidebar()
{
    static $display;
    isset($display) || $display = apply_filters('sage/display_sidebar', false);
    return $display;
}

/**
 * image filter for feature
 * @return string
 */
function cc_background_image_filter()
{
    return 'linear-gradient(-180deg, rgb(0,0,0) 0%, rgba(0,0,0,0.00) 40%), linear-gradient(rgba(109,114,163,0.80) 0%, rgba(109,114,163,0.80) 100%),linear-gradient(rgba(55,23,34,0.10) 0%, rgba(55,23,34,0.10) 100%)';
}

function get_post_icon_class($post = null)
{
    if ( empty( $post )  ) {
        global $post;
    } else {
        $post = get_post($post);
    }

    $icon_class = '';
    if( !empty( $post ) )
    {
        if($post->post_type == 'artist' || $post->post_type == 'city') {
            $icon_class = 'icon icon-travel-white';
        } else {
            $post_categories = wp_get_post_categories( $post->ID );
            if( !empty ( $post_categories ) ) {
                $category = get_category($post_categories[0]);
                $term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                $icon_class = 'icon icon-'.$term->slug.'-white';
            } else {
                $icon_class = 'icon icon-travel-white';
            }
        }
    } else {
        $icon_class = 'icon icon-travel-white';
    }

    return $icon_class;
}

/**
 * Write to the debug log
 * @param mixed
 */
function write_log( $log )
{
    if ( is_array( $log ) || is_object( $log ) )
    {
        error_log( print_r( $log, true ) );
    }
    else
    {
        error_log( $log );
    }
}

function get_category_type_title($post = null) {
    if ( empty( $post )  ) {
      global $post;
    } else {
      $post = get_post($post);
    }

    $category_type;
    if( $post->post_type == 'city' ) {
      $category_type = 'travel guide';
    } elseif ( $post->post_type == 'artist' ) {
      $category_type = 'artist guide';
    } elseif ($post->post_type == 'location') {
      $location_terms = get_the_terms( $post, 'location_types' );
      $category_type = (!empty($location_terms)) ? $location_terms[0]->name : '';
    } else {
      $post_categories = wp_get_post_categories( $post->ID );
      $category = get_category($post_categories[0]);
      if($category->slug == 'uncategorized') {
        $category_type = 'editorial';
      } else {
        $category_type = $category->slug;
      }
    }
    return $category_type;
  }

  function get_category_type_subject($post = null) {
    if ( empty( $post )  ) {
      global $post;
    } else {
      $post = get_post($post);
    }

    $subject = '';
    if($post->post_type == 'city') {
      $subject = $post->post_title;
    }
    elseif ($post->post_type == 'artist') {
      $artist_city = get_field('artist_city', $post->ID)[0];
      $subject = $artist_city->post_title;
    }
    else {
      $primary_term = get_field('primary_tag', $post->ID);
      if( $primary_term ) {
        $subject = $primary_term->name;
      } else {
        $tag_terms = wp_get_post_terms($post->ID);
        if(!empty($tag_terms)) {
          $first_term = $tag_terms[0];
          $subject = $first_term->name;
        }
      }
    }
    return $subject;
  }

  function get_card_title($post = null) {
    if ( empty( $post )  ) {
      global $post;
    } else {
      $post = get_post($post);
    }

    $title = '';
    if( $post->post_type == 'post' ) {
      $title = $post->post_title;
    } else {
      $title = get_field( 'excerpt_title', $post->ID );
    }

    if ( empty ( $title ) ) {
      $title = get_the_title( $post );
    }
    return $title;
  }

  function get_card_excerpt($post = null, $length = '60') {
    if ( empty( $post )  ) {
      global $post;
    } else {
      $post = get_post($post);
    }

    $excerpt = get_the_excerpt();
    //for some reason &hellip; keeps showing up on empty excerpts, get the post content
    if ($excerpt === '&hellip;') {
      $excerpt = wp_strip_all_tags( $post->post_content );
      write_log($excerpt);
    }

    $line=$excerpt;
    if ( preg_match( '/^.{1,'.$length.'}\b/s', $excerpt, $match ) ) {
        $line=trim( $match[0] );
        $line .= ( strlen( $excerpt ) > $length ) ? '...' : '';
    }
    return strip_tags( $line );
  }

  function get_social_links($post = null) {
    if( empty( $post ) ) {
      global $post;
    } else {
      $post = get_post($post);
    }

    $shares = [];
    //facebook share url
    $shares['facebook'] = get_the_permalink();
    $shares['twitter'] = 'https://twitter.com/intent/tweet?text='.urlencode(get_the_title()).'&url='.urlencode(get_the_permalink());
    $shares['tumblr'] = 'http://www.tumblr.com/widgets/share/tool?canonicalUrl='.urlencode(get_the_permalink());

    return $shares;
  }
