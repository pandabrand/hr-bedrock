<?php

namespace App;

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
});

/**
 * Template Hierarchy should search for .blade.php files
 */
collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment', 'embed'
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__.'\\filter_templates');
});

/**
 * Render page using Blade
 */
add_filter('template_include', function ($template) {
    collect(['get_header', 'wp_head'])->each(function ($tag) {
        ob_start();
        do_action($tag);
        $output = ob_get_clean();
        remove_all_actions($tag);
        add_action($tag, function () use ($output) {
            echo $output;
        });
    });
    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        return apply_filters("sage/template/{$class}/data", $data, $template);
    }, []);
    if ($template) {
        echo template($template, $data);
        return get_stylesheet_directory().'/index.php';
    }
    return $template;
}, PHP_INT_MAX);

/**
 * Render comments.blade.php
 */
add_filter('comments_template', function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );

    $data = collect(get_body_class())->reduce(function ($data, $class) use ($comments_template) {
        return apply_filters("sage/template/{$class}/data", $data, $comments_template);
    }, []);

    $theme_template = locate_template(["views/{$comments_template}", $comments_template]);

    if ($theme_template) {
        echo template($theme_template, $data);
        return get_stylesheet_directory().'/index.php';
    }

    return $comments_template;
}, 100);

add_action( 'pre_get_posts', function ( $query ) {
  if ( !is_admin() && $query->is_main_query() && is_tax( 'location_types') )  {
    $query->set( 'posts_per_page', -1 );
    $query->set( 'nopaging', true );
    $query->set( 'orderby', 'meta_value' );
    $query->set( 'meta_key', 'location_city');
    $query->set( 'order', 'asc' );
    $cat_city = get_query_var('cat_city');
    if($cat_city) {
      $meta_query = array(
        array(
          'key' => 'location_city',
          'value' => '"'.$cat_city.'"',
          'compare' => 'LIKE'
        )
      );
      $query->set('meta_query', $meta_query);
    }
  } elseif( !is_admin() && $query->is_main_query() && is_post_type_archive( ['city', 'artist'] ) ) {
    $query->set( 'posts_per_page', 12 );
    $query->set( 'orderby', 'title' );
    $query->set( 'order', 'asc' );
//   } elseif( !is_admin() && $query->is_main_query() && $query->is_home() ) {
//     $idObj = get_category_by_slug('reserved');
//     $id = $idObj->term_id;
//     $query->set('category__not_in', [$id]);
  } elseif( !is_admin() && is_search() ) {
    $idObj = get_category_by_slug('reserved');
    $id = $idObj->term_id;
    $query->set('category__not_in', [$id]);
  }

  if ( !is_admin() && $query->is_main_query() && is_post_type_archive() ) {
  }
});

add_filter( 'get_the_archive_title', function ($title) {
    // Split the title into parts so we can wrap them with spans.
    $title_parts = explode( ': ', $title, 2 );

    // Glue it back together again.
    if ( ! empty( $title_parts[1] ) ) {
        $title = wp_kses(
            $title_parts[1],
            array(
                'span' => array(
                'class' => array(),
                ),
            )
        );
        $title = '<span class="screen-reader-text">' . esc_html( $title_parts[0] ) . ': </span>' . $title;
    }

    return $title;
});
