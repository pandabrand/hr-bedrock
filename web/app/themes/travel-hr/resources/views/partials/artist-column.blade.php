<div class="col-md-3 artist-column">
  <a href="{{$link}}" rel="bookmark">{!! $image !!}</a>
  <div class="title"><a href="{{$link}}" rel="bookmark">Meet {{$name}}</a></div>
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
