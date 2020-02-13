@if( $artists )
  <div class="container">
    <div class="row justify-content-between">
      @foreach( $artists as $artist )
        @include( 'partials.artist-column', $artist )
      @endforeach
    </div>
  </div>
@endif
