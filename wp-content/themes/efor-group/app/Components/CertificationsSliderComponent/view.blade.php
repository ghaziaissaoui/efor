@php $iconLibUrl = \App\asset_path('images/icon-lib.svg') @endphp
{{-- dump($data): All data's available for this view --}}

<section class="@lg:u-padding-t-12 u-padding-t-8 u-padding-b-6 @lg:u-padding-b-12 @if('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif bg-{!! $data['background'] ?? '' !!}">
  <div class="gs-fluid-container">
    <div class="gs-row">
      <certifications-slider-component class="certifications-slider-component u-width-100% c-{!! $data['global_text_color'] ?? '' !!}">
        <div class="u-flex certif-header">
          <h2 class="certif-header__title t-h2 t-align-center @md:t-align-left @md:gs-column-7">
            {!! $data['title']['title_1'] ?? '' !!}
            <span class="t-sometimes-times u-block">{!! $data['title']['title_2'] ?? '' !!}</span>
          </h2>

          <div class="u-hidden @md:u-flex certif-header__arrows @md:gs-column-5">
            <div class="arrow-prev round-button round-button--black bg-gray-20"></div>
            <div class="arrow-next round-button round-button--black bg-gray-20"></div>
          </div>
        </div>

        <div class="@if('true' === ($data['with_images'] ?? '')) certif-slider @else interventions-slider @endif swiper">
          <ul class="swiper-wrapper">
            @if(!empty($data['slides']))
              @foreach($data['slides'] as $slide)
                <li class="u-flex u-flex-column-reverse @md:u-flex-row swiper-slide">
                  <div class="certif-slider__left @if(!empty($slide['image'])) @md:gs-column-6 @endif @wd:gs-column">
                    <p class="title t-h3">{!! $slide['title'] ?? '' !!}</p>
                    <p class="t-base-medium">{!! $slide['content'] ?? '' !!}</p>
                  </div>
                  @if(!empty($slide['image']))
                    <div class="certif-slider__right @md:gs-column-6 @md:gs-column">
                      <div class="image bg-gray-20">
                        <div class="ratio-block ratio-block--203/280 @lg:ratio-block--405/556">
                          {!! $slide['image'] !!}
                        </div>
                      </div>
                    </div>
                  @endif
                </li>
              @endforeach
            @endif
          </ul>
        </div>

        <div class="u-flex @md:u-hidden certif-header__arrows @md:gs-column-5 u-margin-t-5 u-justify-content-center">
          <div class="arrow-prev round-button round-button--black bg-gray-20"></div>
          <div class="arrow-next round-button round-button--black bg-gray-20"></div>
        </div>

      </certifications-slider-component>
    </div>
  </div>
</section>

