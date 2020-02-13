<ul>
  @foreach( \App::posts_for_menu( $dropdown ) as $dropdown_item )
    @if($dropdown == 'location_types')
      <li><a href="{!! get_term_link( $dropdown_item ) !!}" class="dropdown-item">{!! $dropdown_item->name !!}</a></li>
    @else
      <li><a href="{!! get_the_permalink($dropdown_item->ID) !!}" class="dropdown-item">{!! $dropdown_item->post_title !!}</a></li>
    @endif
  @endforeach
  <li><a class="btn btn-primary btn-heavy" href="/{!! $dropdown !!}">All {!! \App::title_for_type( $dropdown ) !!}</a></li>
</ul>
