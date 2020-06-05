@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  <div id="content" class="container">
    <div class="row">
      @if (!have_posts())
      <div class="alert alert-warning">
        {{ __('Sorry, no results were found.', 'sage') }}
      </div>
      {!! get_search_form(false) !!}
      @endif

      @while (have_posts()) @php the_post() @endphp
      @include('partials.content-'.get_post_type())
      @endwhile

      <div class="col-sm-12">
        <div class="row cc-row archive__navigation-row space-around">
        </div>
      </div>
    </div>
  </div>
@endsection
