<div class="container-fluid travel travel__navigation">
  <div class="menu">
    <button class="d-md-none btn travel__navigation__button travel__navigation__button--browse" type="button"><span class="fas fa-window-maximize"></span> Browse</button>
    <nav class="d-none d-md-block">
      <ul>
        <li class="dropdown">
          <a href="#" id="cities-dropdown" class="dropdown-toggle" data-display="static" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cities</a>
          <div class="dropdown-menu" aria-labelledby="cities-dropdown">
            <div class="container">
              <div class="col-12 dropdown-search">
                <div class="form-group">
                  <input class="cc-autocomplete form-control" placeholder="search for a city name" data-post-type="city" />
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  @include('partials.map-dropdown', [$dropdown = 'city'])
                </div>
              </div>
            </div>
          </div>
        </li>
        <li class="dropdown">
          <a href="#" id="artists-dropdown" class="dropdown-toggle" data-display="static" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Artists</a>
          <div class="dropdown-menu" aria-labelledby="artists-dropdown">
            <div class="container">
              <div class="col-12 dropdown-search">
                <div class="form-group">
                  <input class="cc-autocomplete form-control" placeholder="search for a artists name" data-post-type="artist" />
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  @include('partials.map-dropdown', [$dropdown = 'artist'])
                </div>
              </div>
            </div>
          </div>
        </li>
        <li class="dropdown">
          <a href="#" id="categories-dropdown" class="dropdown-toggle" data-display="static" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categories</a>
          <div class="dropdown-menu" aria-labelledby="categories-dropdown">
            <div class="container">
              <div class="row">
                <div class="col-md-6">
                  @include('partials.map-dropdown', [$dropdown = 'location_types'])
                </div>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </nav>
    <button class="btn travel__navigation__button travel__navigation__button--near-me" type="button"><i class="fas fa-crosshairs"></i>Near Me</button>
  </div>
</div>
