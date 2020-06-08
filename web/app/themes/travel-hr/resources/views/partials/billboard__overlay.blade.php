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
                        @if( get_post_type() == 'artist' || get_post_type() == 'vibe-manager' )
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
                  @if ( get_post_type() == 'artist' || get_post_type() == 'city' || get_post_type() == 'vibe-manager' )
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
