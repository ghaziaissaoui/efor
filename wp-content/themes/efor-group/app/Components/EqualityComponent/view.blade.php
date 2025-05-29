{{-- dump($data): All data's available for this view --}}

<section class="@lg:u-padding-t-12 u-padding-t-8 u-block bg-{!! $data['background'] !!} @if('without' === ($data['bottom_margin'] ?? '')) equality-component--no-margin @endif @if('without' === ($data['bottom_padding'] ?? '')) u-padding-b-0 @else u-padding-b-6 @lg:u-padding-b-12 @endif">
    <equality-component class="equality-component">
        <div class="gs-fluid-container">
            <div class="gs-row">
                <h2 class="equality__title t-h2 t-align-center @md:gs-column-6 @md:gs-pull-3 @md:gs-push-3 c-{!! $data['global_text_color'] !!}">
                    {!! $data['title']['title_1'] ?? '' !!}
                    <span class="t-sometimes-times u-block">{!! $data['title']['title_2'] ?? '' !!}</span>
                </h2>
            </div>
        </div>
        <div class="gs-full-container equality__images">
            <div class="image gs-row u-flex u-justify-content-space-between u-align-items-center">
                <div class="image__left gs-column-6">
                    <div class="ratio-block ratio-block--166/97 @lg:ratio-block--118/133">
                        {!! $data['image_left'] ?? '' !!}
                    </div>
                </div>

                <div class="image__right gs-column-6">
                    <div class="ratio-block ratio-block--174/97 @lg:ratio-block--571/665">
                        {!! $data['image_right'] ?? '' !!}
                    </div>
                </div>
            </div>
        </div>
    </equality-component>
</section>
