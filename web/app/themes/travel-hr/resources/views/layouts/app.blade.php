<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body @php body_class() @endphp>
    @php do_action('get_header') @endphp
    @include('partials.travel-mobile-menu')
    @include('partials.header')
    <div class="body-wrap">
      <div class="wrap container" role="document">
        <div class="content">
          <main class="main">
            @yield('content')
          </main>
          @if (App\display_sidebar())
            <aside class="sidebar">
              @include('partials.sidebar')
            </aside>
          @endif
        </div>
      </div>
      @if( is_single() || is_tax( 'locations_types' ) )
        @include('partials.map')
        <div class="additional-content">
          <div class="container">
            <div class="row mb-4">
              <div class="col-12">
                <h2 class="text-center text-uppercase">More to explore</h2>
              </div>
            </div>
            <div class="row">
              @foreach($additional_posts as $additional_post)
                @include('partials.additional', $additional_post)
              @endforeach
            </div>
          </div>
        </div>
      @endif
    </div>
    @php do_action('get_footer') @endphp
    @include('partials.footer')
    @php wp_footer() @endphp
  </body>
</html>
