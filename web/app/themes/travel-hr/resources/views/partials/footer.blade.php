<footer class="content-info">
  <div class="container">
    <div class="row hr-row mb-4">
      <div class="col-sm-6 text-center">
        <h4>&copy; Hard Rock Hotels</h4>
      </div>
    </div>
    <div class="row hr-row">
      <div class="col-sm-6">
        @if (has_nav_menu('footer-one'))
          {!! wp_nav_menu(['theme_location' => 'footer-one', 'menu_class' => 'nav']) !!}
        @endif
      </div>
    </div>
    @php dynamic_sidebar('sidebar-footer') @endphp
  </div>
</footer>
