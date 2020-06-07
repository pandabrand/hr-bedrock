      <div class="billboard-overlay">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="billboard__post-type-info">
                <div class="page-header">
                  <h1>{!! get_the_title() !!}</h1>
                </div>
                @include('partials.artists-row', $artists)
              </div>
            </div>
          </div>
        </div>
      </div>
