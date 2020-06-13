<div class="full-width bg-img">
  <img class="img-fluid" src="{!! the_post_thumbnail_url('front-page-image') !!}" alt="">
  <div class="overlay">
    <div class="header">
      <h2 class="palmaton">Introducing</h2>
      <h2 class="font-weight-bold text-uppercase">Soundtracks</h2>
      @php the_content() @endphp
    </div>
  </div>
</div>
{!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
