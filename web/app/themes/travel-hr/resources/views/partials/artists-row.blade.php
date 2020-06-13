@if( $artists )
  <div class="container">
    <div class="row">
      <div class="d-flex flex-column center mx-auto my-5">
        <h2 class="palmaton text-center">Choose</h2>
        <h2 class="text-center text-uppercase font-weight-bold">Your Music Concierge</h2>
        <a href="/city" class="btn btn-secondary text-uppercase mx-auto">See All Guides</a>
      </div>
    </div>
    <div class="row justify-content-between">
      @foreach( $artists as $artist )
      @include( 'partials.artist-column', $artist )
      @endforeach
    </div>
  </div>
@endif
