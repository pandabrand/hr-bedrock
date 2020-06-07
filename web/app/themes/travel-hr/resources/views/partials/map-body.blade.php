<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      @include ('partials.billboard__image')
      @if( 'artist' == get_post_type() )
      @include('partials.billboard__overlay')
      @elseif( 'city' == get_post_type() )
      @include('partials.billboard__overlay-city')
      @endif
    </div>
  </div>
</div>
<div class="container article-height">
  <div class="row">
    <div class="col-md-12">
      <div class="map-summary">
        @if ( get_post_type() == 'artist' || get_post_type() == 'city' )
          {!! the_content() !!}
        @else
          {!! term_description() !!}
        @endif
      </div>
    </div>
  </div>
  <div class="row cc-row travel travel__detail__map__row">
    <div class="col-sm-12 col-md-6 order-md-last">
      @include('partials.travel-map_block')
    </div>
    <div class="col-sm-12 col-md-6 order-md-first">
      <div class="travel__detail__map__list--wrapper">
        <div class="travel__detail__map__list">
          @if ( get_post_type() == 'artist' || get_post_type() == 'city' )
            @if( !empty( $locations ) )
              @foreach( $locations as $location_arr )
                @include( 'partials.travel-location_block', [ $location = Single::location_for_array($location_arr)] )
              @endforeach
            @endif
          @else
            @while( have_posts()) @php the_post() @endphp
              @include( 'partials.travel-location-tax_block' )
            @endwhile
          @endif
        </div>
      </div>
    </div>
  </div>

</div>
