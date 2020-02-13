<header class="banner">
  <div class="container">
    <a class="brand" href="{{ home_url('/') }}"><img class="img-fluid" src="@asset('images/hard-rock-hotel-2-logo.png')"></a>
    <nav class="nav-primary">
      @if (has_nav_menu('home_navigation'))
        {!! wp_nav_menu(['theme_location' => 'home_navigation', 'menu_class' => 'nav']) !!}
      @endif
    </nav>
  </div>
</header>
