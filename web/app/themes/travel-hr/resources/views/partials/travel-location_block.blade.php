<div class="row travel__detail__map__item {!! App::ref_for_object($location) !!}" id="{!! $location->ID !!}" data-city="{!! Single::location_city_object($location) !!}" data-location-name="{!! $location->post_name !!}">
  <div class="col-12">
    <div class="card card__2-1 card__2-1-travel d-flex flex-column">
          <div class="card__image"  style="background-image:{!! App\cc_background_image_filter() !!}, url('{!! Single::large_url( $location ) !!}')">
            <div class="card__category-block">
              <div class="{!! App\get_post_icon_class($location) !!} mr-2"></div>
              <div class="card__category-block__category-details pl-3">
                <div class="card__category-block__category-type">
                  {!! App\get_category_type_title($location) !!}
                </div>
                <div class="card__category-block__category-info">
                  {!! App\get_category_type_subject($location) !!}
                </div>
              </div>
            </div>
            <div class="card__category-line"></div>
            <div class="card__filter"></div>
          </div><!-- card__image -->
          <div class="card__body">
            <div class="card__copy d-flex flex-column">
              <div class="card__title">
                {!! App\get_card_title($location) !!}
              </div>
              <div class="card__text">
                  {!! apply_filters( 'the_content', $location->post_content ) !!}
              </div>
              <div class="card__address">
                {!! Single::address( $location ) !!}
              </div>
                @if( !empty( Single::artist_posts($location) ) )
                  <div class="card_reccomendations">
                    <div class="medium small_text pt-2">Recommended by</div>
                    <div class="d-flex flex-row flex-wrap">
                      @foreach(Single::artist_posts($location) as $artist)
                      @if( $loop->count > 10 && $loop->index == 10)
                        <div class="card_reccomendations__title small_text pr-2">
                            <span class="small_text">, and more.</span>
                         </div>
                        @break
                      @endif
                        <div class="card_reccomendations__title small_text pr-2">
                          <a href=" {!! get_the_permalink($artist->post_id) !!}">{!! get_the_title($artist->post_id) !!}</a>
                        </div>
                      @endforeach
                  </div>
                </div>
              @endif
              <div class="card__links mt-auto d-flex flex-row justify-content-start">
                <div class="card__link travel-card__link mr-4">
                  <a href="{!! App::get_website_for_location($location) !!}" rel="external" target="_blank"><i class="fa fa-window-maximize"></i> website</a>
                </div>
                <div class="card__link travel-card__link mr-4">
                  <a href="https://www.google.com/maps/dir/?api=1&destination={!! Single::latLng( $location )['lat'],',',Single::latLng( $location )['lng'] !!}" rel="external" target="_blank">
                    <i class="fa fa-map"></i> directions
                  </a>
                </div>
                @if( !empty( Single::instagram_url( $location ) ) )
                <div class="card__link travel-card__link mr-4">
                  <a href="{!! Single::instagram_url( $location ) !!}" rel="external" target="_blank">
                    <i class="fa fa-instagram"></i> instagram
                  </a>
                </div>
                @endif
              </div>
            </div>
          </div>
    </div>
  </div>
</div>
