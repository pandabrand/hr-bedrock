<header class="banner">
  <div class="container temp-padding">
    <div class="hr-nav">
      <a class="brand" href="{{ home_url('/') }}"><img class="img-fluid" src="@asset('images/HRHotel_low-white.png')"></a>
      <a href="https://www.hardrockhotels.com/stay-like-a-legend-promotion" class="btn btn-primary inverse temp-line">Book Now</a>
    </div>

    <nav class="nav-primary">
      @if (has_nav_menu('home_navigation'))
        {!! wp_nav_menu(['theme_location' => 'home_navigation', 'menu_class' => 'nav']) !!}
      @endif
    </nav>
  </div>
</header>
