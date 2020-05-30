<header class="banner">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center w-100">
      <a class="brand" href="{{ home_url('/') }}"><img class="img-fluid" src="@asset('images/HRHotel_low-white.png')"></a>

      <nav class="nav-primary navbar navbar-expand-md navbar-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-home-menu" aria-controls="menu-home-menu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="fa fa-bars fa-2x"></span>
        </button>
        @if (has_nav_menu('home_navigation'))
          {!! wp_nav_menu(['theme_location' => 'home_navigation', 'menu_class' => 'nav collapse navbar-collapse', 'id' => 'navbarToggler']) !!}
        @endif
      </nav>
    </div>
  </div>
</header>
