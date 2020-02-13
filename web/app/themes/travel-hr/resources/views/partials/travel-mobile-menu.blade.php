<div id="mobile-travel-navigate" class="travel__slideout-menu">
  <div class="d-flex flex-row justify-content-end">
    <a href="javascript: void(0);" class="travel__slideout-menu-close"><i class="fa fa-times"></i></a>
  </div>
  <div id="mobile_travel-accordion" class="travel__navigation__accordion">
    <div class="card">
      <div class="card-header" role="tab" id="cityHeader">
        <a href="#cityCollapse" class="accordion-link" id="citiesMenuLink" data-toggle="collapse" data-parent="#mobile_travel-accordion" aria-controls="cityCollapse" aria-expanded="true">Cities</a>
      </div>
      <div id="cityCollapse" class="collapse show" role="tabpanel" aria-labelledby="cityHeader">
        <div class="card-block">
          <div class="dropdown-search">
            <div class="form-group">
              <input class="cc-autocomplete form-control" placeholder="search for a city name" data-post-type="city" />
            </div>
          </div>
          <div class="accordion-selections">
            @foreach( App::posts_for_menu( 'city' ) as $city )
              <a href="{!! get_the_permalink($city->ID) !!}" class="accordion-item {!! App::show_active_for_post( $city ) !!}" rel="nofollow">{!! $city->post_title !!}</a>
            @endforeach
          </div>
          <div>
            <a href="/city" class="accordion-item button button--small button--outline button--width-fit" rel="nofollow">All Cities</a>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header" role="tab" id="artistHeader">
        <a href="#artistCollapse" class="accordion-link collapsed" id="artistsMenuLink" data-toggle="collapse" data-parent="#mobile_travel-accordion" aria-controls="artistCollapse" aria-expanded="false">Artists</a>
      </div>
      <div id="artistCollapse" class="collapse" aria-labelledby="artistsHeader">
        <div class="card-block">
          <div class="dropdown_notice bold ml-4">
            {!! App::dropdown_notice() !!}
          </div>
          <div class="dropdown-search">
            <div class="form-group">
              <input class="cc-autocomplete form-control" placeholder="search for an artist name" data-post-type="artist" />
            </div>
          </div>
          <div class="col-xs-12 accordion-selections">
              @foreach( App::menu_for_artists() as $artist )
                <a href="{!! get_the_permalink($artist->ID); !!}" class="accordion-item {!! App::show_active_for_post( $artist ); !!} " rel="nofollow">{!! $artist->post_title !!}</a>
              @endforeach
          </div>
          <div>
            <a href="/artist" class="accordion-item button button--small button--outline button--width-fit" rel="nofollow">All Artists</a>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header" role="tab" id="catHeader">
        <a href="#catCollapse" class="accordion-link collapsed" id="categoriesMenuLink" data-toggle="collapse" data-parent="#mobile_travel-accordion" aria-controls="CatCollapse" aria-expanded="false">Categories</a>
      </div>
      <div id="catCollapse" class="collapse" role="tabpanel"  aria-labelledby="catHeader">
        <div class="card-block">
          <div class="dropdown-search">
            @if(is_tax('location_types'))
              <div class="form-group">
                Filter By City <select class="city-filter-select custom-select mb-2 mr-sm-2 mb-sm-0" id="inlineFormCustomSelect">
                  <option selected>All Cities...</option>
                  @foreach(App::posts_for_menu( 'city' ) as $city_option)
                    <option {!! App::selected_city_menu( $city_option ) !!} value="{!! $city_option->ID !!}">{!! $city_option->post_title !!}</option>
                  @endforeach
                </select>
              </div>
          @elseif (in_array(get_post_type(), ['artist','city']))
            <div class="dropdown_notice font-weight-bold ml-4">
              <!-- @php
                //echo $post->post_title;
                //if(get_post_type() == 'artist') {
                  //echo ' : ', $subject;
                //}
              @endphp -->
            </div>
          @endif
          </div>
          <div class="col-xs-12 accordion-selections">
              <!-- $active_term = get_queried_object();
              $locations_cats = get_terms($args); -->
              @foreach( App::posts_for_menu( 'location_type' ) as $term )
                <a href="@php echo add_query_arg($cat_query_params, esc_url( get_term_link( $term ) )); @endphp" rel="nofollow" class="accordion-item{!! show_active_for_post( $term ) !!}">{!! $term->name !!}</a>
              @endforeach
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
