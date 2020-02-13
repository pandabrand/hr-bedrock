<header class="banner">
  <div class="container-fluid">
    <nav class="nav-primary">
      @if (has_nav_menu('home_navigation'))
        {!! wp_nav_menu(['theme_location' => 'home_navigation', 'menu_class' => 'nav']) !!}
      @endif
    </nav>
    <a class="brand" href="{{ home_url('/') }}"><img class="img-fluid" src="@asset('images/hard-rock-hotel-2-logo.png')"></a>
  </div>
</header>
