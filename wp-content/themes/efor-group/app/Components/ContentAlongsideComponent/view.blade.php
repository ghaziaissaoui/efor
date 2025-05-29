@php
    $iconLibUrl = \App\asset_path('images/icon-lib.svg');

    if (!empty($data['endbloc-quotation']['content'])) {
        $sectionClass = 'u-margin-b-5 u-padding-b-3';
    } else {
        if ('white' === $data['background']) {
            $sectionClass = '@lg:u-padding-b-6 u-padding-b-3';
        } else {
            $sectionClass = '@lg:u-padding-b-12 u-padding-b-6';
        }
    }

    if ('without' === ($data['bottom_margin'] ?? '')) {
        $sectionClass .= ' u-margin-b-0';
    }
@endphp
<section class="anchor-to @lg:u-padding-t-12 u-padding-t-8 u-block bg-{!! $data['background'] !!} {!! $sectionClass !!}" @if(!empty($data['anchorId'])) data-anchor="{!! $data['anchorId'] !!}" @endif>
    <div class="gs-fluid-container">
        <div class="gs-row">
            <content-alongside-component class="content-alongside-component @md:u-flex u-width-100%">
                <div class="content-alongside-left @md:gs-column-5 @md:gs-pull-1 u-flex-column {!! $data['alignement_vertical'] ?? '' !!}">
                    @if('h2' === $data['title_type'])
                        <h2 class="content-alongside-left__title t-h2 c-{!! $data['global_text_color'] !!}">
                            <span>{!! $data['title']['title_1'] !!}</span>
                            <span class="t-sometimes-times">{!! $data['title']['title_2'] !!}</span>
                        </h2>
                    @else
                        <h2 class="content-alongside-left__title t-h3 c-{!! $data['global_text_color'] !!}">{!! $data['title_simple'] !!}</h2>
                    @endif

                    @if('small' === $data['image_format'])
                        @if(!empty($data['image_small']))
                            <div class="content-alongside-left__img ratio-block ratio-block--50/67 @md:ratio-block--40/49">
                                {!! $data['image_small'] !!}
                            </div>
                        @endif
                    @elseif('large' === $data['image_format'])
                        @if(!empty($data['image_large']))
                            <div class="content-alongside-left__img content-alongside-left__img--big ratio-block ratio-block--89/67 @md:ratio-block--66/49">
                                {!! $data['image_large'] !!}
                            </div>
                        @endif
                    @else
                        @if(!empty($data['image_extra_small']))
                          <div class="content-alongside-left__img content-alongside-left__img--big ratio-block ratio-block--50/63 @md:ratio-block--153/245">
                            {!! $data['image_extra_small'] !!}
                          </div>
                        @endif
                    @endif
                </div>

                <div class="content-alongside-right @md:gs-column-6"> {{-- if block quote + text on right (inversed text bottom) classes : u-flex-column-reverse --}}
                    @if(!empty($data['content']))
                        @foreach($data['content'] as $section)
                            @switch($section['section_type'])
                                @case('title_and_content')
                                    <div class="content-alongside-right__text c-{!! $data['global_text_color'] !!}">
                                        @if(!empty($section['title']))
                                            <p class="t-h4">{!! $section['title'] !!}</p>
                                        @endif
                                        {!! $section['content'] !!}
                                    </div>
                                    @break
                                @case('quote')
                                    <div class="content-alongside-right__quote c-{!! $data['global_text_color'] !!}">
                                        <svg class="u-icon c-gold-secondary">
                                            <use xlink:href="{{ $iconLibUrl }}#icon-double-quote"/>
                                        </svg>
                                        <p class="t-h4 t-sometimes-times c-{!! $data['global_text_color'] !!}">
                                            {!! $section['quote'] !!}
                                        </p>
                                        <p class="author c-gold-secondary">- {!! $section['author'] !!}</p>
                                    </div>
                                    @break
                                @case('accordion')
                                    <div class="content-alongside-right__accordion">
                                        <div class="accordion">
                                            @if(!empty($section['accordion']))
                                                @foreach($section['accordion'] as $level)
                                                    @php
                                                        $index = $loop->index++;
                                                        if ($loop->index < 10) {
                                                            $index = sprintf('0%s', $loop->index);
                                                        }
                                                    @endphp
                                                    <div class="item c-{!! $data['global_text_color'] !!}">
                                                        <div class="item__intro u-flex u-align-items-center">
                                                            <p class="t-h4 u-flex u-align-items-baseline">
                                                              @if(true === $section['display_indexes'])
                                                                <span class="item__index t-base-small">{!! $index !!}</span>
                                                              @endif
                                                                <span class="item__title u-width-100%">{!! $level['accordion_title'] !!}</span>
                                                            </p>
                                                        </div>

                                                        <div class="item__content t-base-medium c-{!! $data['global_text_color'] !!}">
                                                            {!! $level['accordion_content'] !!}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    @break
                            @endswitch
                        @endforeach
                    @endif

                    @if(!empty($data['link']['url']) && !empty($data['link']['title']))
                        <a href="{!! $data['link']['url'] !!}" target="{!! $data['link']['target'] !!}" class="button {!! 'white' === ($data['link_color'] ?? '') ? 'button--white' : '' !!}" style="background: var(--c-{!! $data['link_color'] ?? '' !!}); color:var(--c-{!! $data['link_color_text'] ?? '' !!});">
                            <span>{!! $data['link']['title'] !!}</span>
                            <svg class="u-icon u-icon-24 u-icon--right {!! 'white' !== ($data['link_color'] ?? '') ? 'c-white' : '' !!}">
                                <use xlink:href="{{ $iconLibUrl }}#icon-arrow-right"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </content-alongside-component>
        </div>
    </div>
</section>

@if (!empty($data['endbloc-quotation']['content']))
    <section class="u-margin-b-14">
        <div class="gs-fluid-container">
                <div class="quotation-wrapper u-padding-t-10 u-padding-b-10 @if('inverted' === $data['endbloc-quotation']['color_scheme'] ?? '') bg-black-graphite c-white @endif">
                    <blockquote class="t-sometimes-times t-align-center">
                        {!! $data['endbloc-quotation']['content']!!}
                    </blockquote>
                </div>
        </div>
    </section>
@endif
