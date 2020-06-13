<div class="card__image"  style="background-image:{!! App\cc_background_image_filter() !!}, url('{!! get_the_post_thumbnail_url( $full_post, 'large-feature') !!}')">
  <div class="card__category-block">
    <div class="{!! App\get_post_icon_class() !!}?> mr-2"></div>
    <div class="card__category-block__category-details pl-3">
      <div class="card__category-block__category-type">
        {!! App\get_category_type_title($full_post) !!}
      </div>
      <div class="card__category-block__category-info">
        {!! App\get_category_type_subject($full_post) !!}
      </div>
    </div>
  </div>
  <div class="card__category-line"></div>
  <div class="card__filter"></div>
</div>
<div class="card__body">
  <div class="card__copy">
    <div class="card__title">
      {!! App\get_card_title($full_post) !!}
    </div>
    <div class="card__text">
      {!! $summary !!}
    </div>
    <div class="card__link"><a href="{!! $link !!}" class="card__link">Explore <span class="fa fa-chevron-right"></span></a></div>
  </div>
</div>
