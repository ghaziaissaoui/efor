{{-- dump($data): All data's available for this view --}}
<section class="bg-{!! $data['background'] !!} @lg:u-padding-t-12 u-padding-t-8 u-padding-b-6 @lg:u-padding-b-12 u-block @if('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
  <talents-slider-component class="talents-slider-component u-relative">
    <div class="gs-fluid-container u-initial @md:u-relative">
      <div class="gs-row">
        <div class="u-flex talents-header u-width-100% u-align-items-center">
          <h2 class=" talents-header__title t-h2 t-align-center @md:t-align-left @md:gs-column-7 c-{!! $data['global_text_color'] !!}">
            <span>{!! $data['title']['title_1'] !!}</span>
            <span class="t-sometimes-times">{!! $data['title']['title_2'] !!}</span>
          </h2>

          <div class="talents-header__arrows u-flex @md:gs-column-5">
            <div class="talents-arrow-prev round-button round-button--black bg-gray-20"></div>
            <div class="talents-arrow-next round-button round-button--black bg-gray-20"></div>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </div>

    <div class="gs-full-container">
      <div class="talents-slider swiper">
        <ul class="swiper-wrapper u-align-items-center">
          @if(!empty($data['talents']))
            @foreach($data['talents'] as $talent)
              <li class="u-flex swiper-slide" id="{!! $talent['id'] !!}" data-url="{!! $talent['permalink'] !!}">

                  <div class="swiper-image">
                    {!! $talent['image'] !!}
                    <div class="content">
                      <div class="talent t-align-center c-white">
                        <p class="talent__name t-h4 @if(strlen($talent['title']) ?? 0 > 15) talent__name--small @endif" style="--char-count: {!! strlen($talent['title']) !!}">{!! $talent['title'] !!}</p>
                        <p class="talent__job t-base-small">{!! $talent['job'] !!}</p>
                      </div>
                      <div class="round-button bg-white talents-modal-button"></div>
                    </div>
                  </div>
              </li>
            @endforeach
          @endif
        </ul>
      </div>
    </div>
  </talents-slider-component>
</section>


<div class="modal u-block" id="Talents-modal">
  <div class="modal__scrollbox u-y-scrollable">
    <div class="modal__dialog">
      <div class="modal__content text"></div>
    </div>
  </div>
</div>
