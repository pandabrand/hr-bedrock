<div class="billboard">
  <div class="billboard__image {{ get_post_type() }}" style="background-image:@php echo App\cc_background_image_filter() @endphp, url('{!! Single::get_city_background_image() !!}')"></div>
</div>
