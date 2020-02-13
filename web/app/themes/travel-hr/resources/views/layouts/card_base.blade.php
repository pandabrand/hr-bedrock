<a href="{!! the_permalink() !!}" class="block__link">
  <div class="card__image"  style="background-image:{!! App\cc_background_image_filter() !!}, url('{!! the_post_thumbnail_url('large-feature') !!}')">
    <div class="card__category-block">
      <div class="{!! App\get_post_icon_class() !!}?> mr-2"></div>
      <div class="card__category-block__category-details pl-3">
        <div class="card__category-block__category-type">
          {!! App\get_category_type_title() !!}
        </div>
        <div class="card__category-block__category-info">
          {!! App\get_category_type_subject() !!}
        </div>
      </div>
    </div>
    <div class="card__category-line"></div>
    <div class="card__filter"></div>
    <div class="card__body">
      <div class="card__copy">
        <div class="card__title">
          {!! App\get_card_title() !!}
        </div>
        <div class="card__text">
          {!! App\get_card_excerpt() !!}
        </div>
      </div>
    </div>
  </div>
</a>
