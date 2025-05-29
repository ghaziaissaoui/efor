@php $iconLibUrl = \App\asset_path('images/icon-lib.svg'); @endphp
<section class="gs-fluid-container u-block @if('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
    <div class="gs-row">
        <card-link-component class="card-link-component u-width-100% @md:u-flex u-centered-on-x">
            @foreach(['left_section', 'right_section'] as $section)
                <div class="@md:gs-column-6">
                    <div class="card-link u-flex-column u-height-100% u-justify-content-end {!! ($data[$section]['background'] ?? false) ? 'card-link--opacity' : 'bg-gray-20' !!}" {!! $data[$section]['background_style'] ?? '' !!}>
                        <h2 class="card-link__title t-h3">
                            {!! $data[$section]['title']['title_1'] ?? '' !!}
                            <span class="t-sometimes-times">{!! $data[$section]['title']['title_2'] ?? '' !!}</span>
                        </h2>
                        @if(!empty($data[$section]['content']))
                            <p class="card-link__desc">{!! $data[$section]['content'] !!}</p>
                        @endif
                        <div class="card-link__btn">
                            <a href="{!! $data[$section]['link']['url'] ?? '#' !!}"
                               target="{!! $data[$section]['link']['target'] ?? '' !!}"
                               class="button {!! 'white' === ($data[$section]['link_color'] ?? '') ? 'button--white' : '' !!}" style="background: var(--c-{!! $data[$section]['link_color'] !!}); color: var(--c-{!! $data[$section]['link_color_text'] !!})">
                                <span>{!! $data[$section]['link']['title'] ?? '' !!}</span>
                                <svg class="u-icon u-icon-24 u-icon--right {!! 'white' !== $data[$section]['link_color'] ? 'c-white' : '' !!}">
                                    <use xlink:href="{{ $iconLibUrl }}#icon-arrow-right"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </card-link-component>
    </div>
</section>
