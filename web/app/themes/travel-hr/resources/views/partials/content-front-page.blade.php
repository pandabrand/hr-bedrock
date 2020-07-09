<div class="full-width bg-img" style="background:url({!! the_post_thumbnail_url('front-page-image') !!}) center;">
  <div class="overlay">
    <div class="header">
      <h2 class="palmaton">Introducing Soundtracks</h2>
      <h2 class="font-weight-bold text-uppercase">by Hard Rock</h2>
      <div class="d-none d-md-block">  @php the_content() @endphp </div>
    </div>
  </div>
</div>
<div class="d-block d-md-none text-center mt-3">  @php the_content() @endphp </div>
{!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
