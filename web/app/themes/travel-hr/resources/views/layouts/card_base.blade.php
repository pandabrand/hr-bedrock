<div class="card__image"  style="background-image:{!! App\cc_background_image_filter() !!}, url('{!! the_post_thumbnail_url('large-feature') !!}')">
  <div class="card__category-block">
    <div class="card__category-block__category-details pl-3">
      <div class="card__category-block__category-type">
        {!! App\get_category_type_title() !!}
      </div>
      <div class="card__category-block__category-info">
        {!! App\get_category_type_subject() !!}
      </div>
    </div>
  </div>
  <div class="card__filter"></div>
</div>
<div class="card__body">
  <div class="card__copy">
    <div class="card__title">
      {!! App\get_card_title() !!}
    </div>
    <div class="card__text">
      {!! App\get_card_excerpt() !!}
    </div>
    <div class="card__link"><a href="{!! the_permalink() !!}" class="card__link">Explore <span class="fa fa-chevron-right"></span></a></div>
  </div>
</div>
