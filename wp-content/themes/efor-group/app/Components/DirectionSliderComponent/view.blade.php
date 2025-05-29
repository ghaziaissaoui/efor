{{-- dump($data): All data's available for this view --}}
<section class="bg-{!! $data['background'] !!} @lg:u-padding-t-12 u-padding-t-8 u-padding-b-6 @lg:u-padding-b-12 u-block @if('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
    <direction-slider-component class="direction-slider-component u-relative">
        <div class="gs-fluid-container u-initial @md:u-relative">
            <div class="gs-row">
                <div class="u-flex direction-header u-width-100% u-align-items-center">
                    <h2 class="direction-header__title t-h2 t-align-center @md:t-align-left @md:gs-column-7 c-{!! $data['global_text_color'] !!}">
                        {!! $data['title']['title_1'] ?? '' !!}
                        <span class="t-sometimes-times u-margin-l-1 ">{!! $data['title']['title_2'] ?? '' !!}</span>
                    </h2>

                    <div class="direction-header__arrows u-flex @md:gs-column-5">
                        <div class="direction-arrow-prev round-button round-button--black bg-gray-20"></div>
                        <div class="direction-arrow-next round-button round-button--black bg-gray-20"></div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>

        <div class="gs-fluid-container">
            <div class="direction-slider swiper">
                <ul class="swiper-wrapper u-align-items-center">
                    @if(!empty($data['members']))
                        @foreach($data['members'] as $direction)
                            <li class="u-flex swiper-slide">
                                <div class="content">
                                    <div class="ratio-block ratio-block--307/190 @lg:ratio-block--89/53">
                                        {!! $direction['member_image'] ?? '' !!}
                                    </div>
                                    <div class="direction t-align-center c-white">
                                        <p class="direction__name t-h4 @if(strlen($direction['member_title'] ?? '') ?? 0 > 15) direction__name--small @endif" style="--char-count: {!! strlen($direction['member_title'] ?? '') !!}">{!! $direction['member_title'] ?? '' !!}</p>
                                        <p class="direction__job t-base-small">{!! $direction['member_job'] ?? '' !!}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </direction-slider-component>
</section>
