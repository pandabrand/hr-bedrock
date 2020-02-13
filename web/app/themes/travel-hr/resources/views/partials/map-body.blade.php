<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="billboard">
        <div class="billboard__image" style="background-image:@php echo App\cc_background_image_filter() @endphp, url('{!! the_post_thumbnail_url('editorial-feature') !!}')"></div>
      </div>
      <div class="billboard-overlay">
        <div class="container">
          <div class="row">
            <div class="col-md-12 line-left">
              <div class="billboard__category_line">
                <div class="billboard__category-block">
                  <div class="@php echo App\get_post_icon_class() @endphp mr-2"></div>
                  <div class="billboard__category-block__category-details pl-3">
                    <div class="billboard__category-block__category-type">
                      {!! App::title_for_type( get_post_type() ) !!} guide:
                    </div>
                    <div class="billboard__category-block__category-info">
                        @if( get_post_type() == 'artist' )
                          {!! get_field('artist_city')[0]->post_title !!}
                        @elseif ( get_post_type() == 'city' )
                          {!! get_the_title() !!}
                        @else
                          {!! Archive::getTermName() !!}
                        @endif
                    </div>
                  </div>
                </div>
              </div>
              <div class="billboard__category">
                <div class="billboard__title h1 ml-3">
                  @if ( get_post_type() == 'artist' || get_post_type() == 'city' )
                    {!! get_the_title() !!}
                  @else
                    The Best {!! Archive::getTermName() !!}s
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
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
