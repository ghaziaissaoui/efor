@php $iconLibUrl = \App\asset_path('images/icon-lib.svg') @endphp

{{-- dump($data): All data's available for this view --}}

{{-- stand alone is used when the component is added directly as a gutenberg block but this bloc can be integrated in ContactComponent--}}
@if(!empty($data['stand_alone']) && true === $data['stand_alone'])
<section class="gs-fluid-container @if('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
    <div class="gs-row">
@endif
        <img-landscape-btn-component class="img-landscape-btn-component @md:gs-column-10 @md:gs-push-1 @md:gs-pull-1">
            <div class="img-landscape-btn-component__container">
                <a class="button c-{!! $data['link_color_text'] ?? '' !!} bg-{!! $data['link_color'] ?? '' !!} @if('white' === ($data['link_color'] ?? '')) button--white @endif button--small" href="{!! $data['link']['url'] ?? '#' !!}" target="{!! $data['link']['target'] ?? '' !!}">
                    <span>{!! $data['link']['title'] ?? '' !!}</span>
                    <svg class="u-icon u-icon-24 u-icon--right @if('white' !== ($data['link_color'] ?? '')) c-white @endif">
                        <use xlink:href="{{ $iconLibUrl }}#icon-arrow-right"/>
                    </svg>
                </a>
                <div class="ratio-block ratio-block--48/67 @lg:ratio-block--31/106">
                    {!! $data['image'] ?? '' !!}
                </div>
            </div>
        </img-landscape-btn-component>
@if(!empty($data['stand_alone']) && true === $data['stand_alone'])
    </div>
</section>
@endif
