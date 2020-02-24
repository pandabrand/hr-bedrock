<header class="banner">
  <div class="container-fluid temp-padding">
    <div class="hr-nav">
      <a class="brand" href="{{ home_url('/') }}"><img class="img-fluid" src="@asset('images/HRHotel_low-white.png')"></a>
      <a href="https://www.hardrockhotels.com/stay-like-a-legend-promotion" class="btn btn-outline-light btn-lg btn-front-line">Book Now</a>
    </div>

    <nav class="nav-primary navbar-expand-md">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      @if (has_nav_menu('home_navigation'))
        {!! wp_nav_menu(['theme_location' => 'home_navigation', 'menu_class' => 'nav collapse navbar-collapse', 'id' => 'navbarToggler']) !!}
      @endif
    </nav>
  </div>
</header>
