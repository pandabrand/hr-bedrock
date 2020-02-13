<div class="col-md-2 artist-column">
  {!! $image !!}
  <div class="title">Meet {{$name}}</div>
  <div class="summary">{{$summary}}</div>
  <div><a href="{{$link}}" rel="bookmark">Learn More</a></div>
  <div class="locations">
    <ul>
      @foreach( $locations as $location )
        <li>{{$location['location'][0]->post_title}}</li>
      @endforeach
    </ul>
  </div>
</div>
