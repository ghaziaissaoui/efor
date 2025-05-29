{{-- dump($data): All data's available for this view --}}
@php $iconLibUrl = \App\asset_path('images/icon-lib.svg') @endphp


<section class="gs-fluid-container u-block @if ('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
    <carousel-component class="carousel-component">
        <div class="gs-row">
            <div class="u-flex carousel-header u-align-items-center u-width-100%">
                <h2 class="carousel-header__title t-h2 t-align-center @lg:t-align-left @lg:gs-column-7">
                    {!! $data['title'] ?? '' !!}
                </h2>

                <div class="carousel-header__arrows u-flex @lg:gs-column-5">
                    <div class="carousel-arrow-prev round-button round-button--black bg-gray-20"></div>
                    <div class="carousel-swiper-pagination u-flex u-justify-content-center"></div>
                    <div class="carousel-arrow-next round-button round-button--black bg-gray-20"></div>
                </div>
            </div>
        </div>

        <div class="carousel-slider swiper">
            <div
                class="carousel-slider__arrows u-hidden @lg:u-flex u-justify-content-space-between u-align-items-center">
                <div class="carousel-arrow-prev">
                    <svg class="u-icon u-icon-32 c-white">
                        <use xlink:href="{{ $iconLibUrl }}#icon-arrow-right" />
                    </svg>
                </div>
                <div class="carousel-arrow-next">
                    <svg class="u-icon u-icon-32 c-white">
                        <use xlink:href="{{ $iconLibUrl }}#icon-arrow-right" />
                    </svg>
                </div>
            </div>
            <div class="swiper-wrapper">
                @if (!empty($data['gallery']))
                    @foreach ($data['gallery'] as $card)
                        <div class="swiper-slide carousel-slider__img">
                            <div class="ratio-block ratio-block--46/67 @lg:ratio-block--16/9">
                                {!! $card['image'] ?? '' !!}
                            </div>
                            <p class="carousel-slider__caption t-base-medium t-align-center">{!! $card['caption'] ?? '' !!}</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </carousel-component>
</section>
