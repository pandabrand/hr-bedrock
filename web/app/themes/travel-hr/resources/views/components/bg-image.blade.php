<section class="c-bg-image {{$class ?? ''}} js-bg-image">
  <img src="{{ wp_get_attachment_image_src($image, 'full')[0] }}" style="display:none" sizes="100vw" srcset="{{ wp_get_attachment_image_srcset($image, 'full') }}">
  {!! $slot !!}
</section>
