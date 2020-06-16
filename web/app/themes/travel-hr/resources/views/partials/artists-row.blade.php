@if( $artists )
  <div class="container">
    <div class="row">
      <div class="d-flex flex-column center mx-auto my-5">
        @if( is_front_page( ) )
          <div class="two-line-header">
            <h2 class="palmaton text-center">Choose</h2>
            <h2 class="text-center text-uppercase font-weight-bold">Your Music Concierge</h2>
          </div>
          <a href="/artist" class="btn btn-secondary text-uppercase mx-auto">See All Guides</a>
        @elseif( 'city' == get_post_type() )
          <h2 class="palmaton text-center">Area Guides</h2>
          <h2 class="text-center text-uppercase font-weight-bold">Curated By Local Artists</h2>
        @endif
      </div>
    </div>
    <div class="row justify-content-between">
      @foreach( $artists as $artist )
        @include( 'partials.artist-column', $artist )
      @endforeach
    </div>
  </div>
@endif
