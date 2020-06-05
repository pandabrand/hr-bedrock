<header class="banner">
  <div class="container">
    <nav class="nav-primary navbar navbar-expand-md">
      <a class="navbar-brand brand" href="https://www.hardrockhotels.com/"><img class="img-fluid" src="@asset('images/HRHotel_low-white.png')"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
        <span class="fa fa-bars fa-2x"></span>
      </button>

      <div id="navbarToggle" class="navbar-collapse collapse">
        @if (has_nav_menu('home_navigation'))
        {!! wp_nav_menu(['theme_location' => 'home_navigation', 'menu_class' => 'navbar-nav', 'container_class' => 'nav-wrap ml-md-auto p-3 p-md-0']) !!}
        @endif
      </div>
    </nav>
  </div>
</header>
