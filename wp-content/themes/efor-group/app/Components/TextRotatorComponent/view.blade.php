<section class="gs-fluid-container @if('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
    <div class="gs-row">
        <text-rotator-component class="text-rotator-component u-width-100%">
            <div class="@lg:u-flex u-justify-content-space-between">
                <div class="@lg:gs-column-6 @wd:gs-column-7">
                    <div class="swiper textRotator">
                        <div class="swiper-wrapper">
                            @foreach ($data['titles'] as $title)
                                <div class="swiper-slide">
                                    <div class="text-rotator-component__title t-h1">
                                        {{ $title['text_rotator_title'] }}
                                        @if($data['display_number'])
                                        <span class="text-rotator-component__number">@if($loop->index < 10) 0{{ $loop->index + 1 }} @else {{ $loop->index + 1 }} @endif</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="@lg:gs-column-6 @wd:gs-column-5">{!! $data['text_rotator_content'] !!}</div>
            </div>
        </text-rotator-component>
    </div>
</section>

