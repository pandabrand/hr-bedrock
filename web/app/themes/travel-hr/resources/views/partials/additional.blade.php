<div class="col-md-3 col-sm-6 col-xs-12">
  <div class="card card__1-1">
      <div class="card__image"  style="background-image:{!! App\cc_background_image_filter() !!}, url('{!! $image !!}')">
        <div class="card__category-block">
          <div class="{!! $icon_class !!}?> mr-2"></div>
          <div class="card__category-block__category-details pl-3">
            <div class="card__category-block__category-type">
              {!! $category_type_title !!}
            </div>
            <div class="card__category-block__category-info">
              {!! $subject !!}
            </div>
          </div>
        </div>
        <div class="card__category-line"></div>
        <div class="card__filter"></div>
      </div>
      <div class="card__body">
        <div class="card__copy">
          <div class="card__title">
            {!! $title !!}
          </div>
          <div class="card__text">
            {!! $excerpt !!}
          </div>
          <div class="card__link">
            <a href="{!! $link !!}" class="block__link">Explore <span class="fa fa-chevron-right"></span></a>
          </div>
        </div>
      </div>
  </div>
</div>
