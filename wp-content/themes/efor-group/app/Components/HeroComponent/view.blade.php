@php $iconLibUrl = \App\asset_path('images/icon-lib.svg') @endphp

{{-- dump($data): All data's available for this view --}}

@php
    if ('sided' === $data['hero_type']) {
        $class = 'gs-fluid-container--left';
    } elseif ('full_image' === $data['hero_type']) {
        $class = 'gs-full-container full__image';
    } else {
        $class = 'gs-fluid-container';
    }
@endphp
<section class="{!! $class !!} @if ('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
    @if ($data['hero_type'] === 'no_image')
        <div class="gs-row">
    @endif
    <hero-component class="hero-component {!! $data['hero_type'] === 'sided' ? 'u-flex-column @md:u-flex-row' : '' !!} {!! $data['hero_type'] === 'no_image' ? 'u-width-100%' : '' !!} {!! $data['hero_type'] === 'full_image' ? 'hero-component__full u-block' : '' !!}">
        @if ('full_image' === $data['hero_type'])
            <div class="hero-component__full-img">
                <div class="ratio-block ratio-block--70/67 @md:ratio-block--9/17">
                    {!! $data['image_full'] ?? '' !!}
                </div>
                <h1 class="hero-component__title t-h1 c-white @lg:gs-flush-column-6 @lg:u-hidden">
                    {!! $data['title']['title_1'] ?? '' !!}
                    <span class="t-sometimes-times u-block">{!! $data['title']['title_2'] ?? '' !!}</span>
                </h1>
            </div>
            <div class="hero-component__full-footer @lg:u-flex-row u-justify-content-space-between">
                <h1
                    class="hero-component__title t-h1 c-white @lg:gs-flush-column-6 u-hidden @lg:u-block u-align-self-end">
                    {!! $data['title']['title_1'] ?? '' !!}
                    <span class="t-sometimes-times u-block">{!! $data['title']['title_2'] ?? '' !!}</span>
                </h1>

                @if (!empty($data['content']) || !empty($data['baseline']))
                    <div class="full-footer-right @lg:gs-flush-column-6">
                        @if ('content' === $data['content_type'])
                            <p class="hero-component__desc t-align-center t-base-medium {!! $data['hero_type'] === 'no_image' ? '' : '@lg:t-align-left' !!}">
                                {!! $data['content'] ?? '' !!}
                            </p>
                        @else
                            <p
                                class="hero-component__baseline t-sometimes-times t-h4 t-align-center {!! $data['hero_type'] === 'no_image' ? '' : '@lg:t-align-left' !!}">
                                {!! $data['baseline'] ?? '' !!}
                            </p>
                        @endif
                        <div class="hero-component__buttons @lg:u-flex-row t-align-center {!! $data['hero_type'] === 'no_image' ? '' : '@lg:t-align-left' !!}">
                            @if (!empty($data['link_1']['url']) && !empty($data['link_1']['title']))
                                <a href="{!! $data['link_1']['url'] ?? '#' !!}" target="{!! $data['link_1']['target'] ?? '' !!}"
                                    class="button {!! 'white' === $data['link_1_color'] ? 'button--white' : '' !!}"
                                    style="background: var(--c-{!! $data['link_1_color'] !!}); color: var(--c-{!! $data['link_1_color_text'] !!}); {!! 'white' === $data['link_1_color'] ? 'border: 1px solid var(--c-black-graphite)' : '' !!}">
                                    <span>{!! $data['link_1']['title'] ?? '' !!}</span>
                                    <svg class="u-icon u-icon-24 u-icon--right {!! 'white' !== $data['link_1_color'] ? 'c-white' : '' !!}">
                                        @if (isset($data['link_1_icon']) && true === $data['link_1_icon'])
                                            <use xlink:href="{{ $iconLibUrl }}#icon-download" />
                                        @else
                                            <use xlink:href="{{ $iconLibUrl }}#icon-arrow-right" />
                                        @endif
                                    </svg>
                                </a>
                            @endif
                            @if (!empty($data['link_2']['url']) && !empty($data['link_2']['title']))
                                <a href="{!! $data['link_2']['url'] ?? '' !!}" target="{!! $data['link_2']['target'] ?? '' !!}"
                                    class="button {!! 'white' === $data['link_2_color'] ? 'button--white' : '' !!}"
                                    style="background: var(--c-{!! $data['link_2_color'] !!}); color:var(--c-{!! $data['link_2_color_text'] !!});">
                                    <span>{!! $data['link_2']['title'] ?? '' !!}</span>
                                    <svg class="u-icon u-icon-24 u-icon--right {!! 'white' !== $data['link_2_color'] ? 'c-white' : '' !!}">
                                        @if (isset($data['link_2_icon']) && true === $data['link_2_icon'])
                                            <use xlink:href="{{ $iconLibUrl }}#icon-download" />
                                        @else
                                            <use xlink:href="{{ $iconLibUrl }}#icon-arrow-right" />
                                        @endif
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @else
            <div class="hero-component__text {!! $data['hero_type'] !== 'sided' ? '@md:gs-column-6 @md:gs-push-3 @md:gs-pull-3' : '@md:gs-flush-column-5' !!}">
                <{!! $data['title']['title_type_html'] !!} class="hero-component__title t-h1 t-align-center {!! $data['hero_type'] === 'no_image' ? '' : '@lg:t-align-left' !!}">
                    {!! $data['title']['title_1'] ?? '' !!}
                    <div class="t-sometimes-times">{!! $data['title']['title_2'] ?? '' !!}</div>
                    </{!! $data['title']['title_type_html'] !!}>

                    @if ('content' === $data['content_type'])
                        <p class="hero-component__desc t-align-center t-base-medium {!! $data['hero_type'] === 'no_image' ? '' : '@lg:t-align-left' !!}">
                            {!! $data['content'] ?? '' !!}
                        </p>
                    @else
                        <p
                            class="hero-component__baseline t-align-center t-sometimes-times t-h4 {!! $data['hero_type'] === 'no_image' ? '' : '@lg:t-align-left' !!}">
                            {!! $data['baseline'] ?? '' !!}
                        </p>
                    @endif
                    <div class="hero-component__buttons @lg:u-flex-row t-align-center {!! $data['hero_type'] === 'no_image' ? 'u-justify-content-center' : '@lg:t-align-left' !!}">
                        @if (!empty($data['link_1']['url']) && !empty($data['link_1']['title']))
                            <a href="{!! $data['link_1']['url'] ?? '#' !!}" target="{!! $data['link_1']['target'] ?? '' !!}"
                                class="button {!! 'white' === $data['link_1_color'] ? 'button--white' : '' !!}"
                                style="background: var(--c-{!! $data['link_1_color'] !!}); color: var(--c-{!! $data['link_1_color_text'] !!})">
                                <span>{!! $data['link_1']['title'] ?? '' !!}</span>
                                <svg class="u-icon u-icon-24 u-icon--right {!! 'white' !== $data['link_1_color'] ? 'c-white' : '' !!}">
                                    @if (isset($data['link_1_icon']) && true === $data['link_1_icon'])
                                        <use xlink:href="{{ $iconLibUrl }}#icon-download" />
                                    @else
                                        <use xlink:href="{{ $iconLibUrl }}#icon-arrow-right" />
                                    @endif
                                </svg>
                            </a>
                        @endif
                        @if (!empty($data['link_2']['url']) && !empty($data['link_2']['title']))
                            <a href="{!! $data['link_2']['url'] ?? '#' !!}" target="{!! $data['link_2']['target'] ?? '' !!}"
                                class="button {!! 'white' === $data['link_2_color'] ? 'button--white' : '' !!}"
                                style="background: var(--c-{!! $data['link_2_color'] !!}); color:var(--c-{!! $data['link_2_color_text'] !!});">
                                <span>{!! $data['link_2']['title'] ?? '' !!}</span>
                                <svg class="u-icon u-icon-24 u-icon--right {!! 'white' !== $data['link_2_color'] ? 'c-white' : '' !!}">
                                    @if (isset($data['link_2_icon']) && true === $data['link_2_icon'])
                                        <use xlink:href="{{ $iconLibUrl }}#icon-download" />
                                    @else
                                        <use xlink:href="{{ $iconLibUrl }}#icon-arrow-right" />
                                    @endif
                                </svg>
                            </a>
                        @endif
                    </div>
            </div>
            @if ($data['hero_type'] === 'sided')
                <div class="hero-component__img @md:gs-flush-column-fill-space">
                    <div class="ratio-block ratio-block--14/15 @lg:ratio-block--9/11">
                        {!! $data['image_small'] ?? '' !!}
                    </div>
                </div>
            @endif
        @endif
    </hero-component>
    @if ($data['hero_type'] === 'no_image')
        </div>
    @endif
</section>
