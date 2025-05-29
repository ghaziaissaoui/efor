@php $iconLibUrl = \App\asset_path('images/icon-lib.svg') @endphp

<footer-component class="footer-component t-neutral-links">
    <div class="gs-fluid-container">
        <section class="footer-component-header">
            @if (!empty($data['title'][0]) || !empty($data['title'][1]))
                <p class="footer-component-header__title @lg:gs-column-5 t-h2 u-padding-0">
                    @if (!empty($data['title'][0])) {!! $data['title'][0] !!} @endif
                    @if (!empty($data['title'][1])) <span class="t-sometimes-times u-block"> {!! $data['title'][1] !!} </span> @endif
                </p>
            @endif

            <div class="footer-component-header__buttons">
                @foreach ($data['ctas'] as $cta)
                    @if (!empty($cta['footer_cta_page'] && !empty($cta['footer_cta_text'])))
                        <a href="{!! $cta['footer_cta_page'] !!}" target="_blank" class="button @if ($loop->even) button--white-for-dark-bg @else button--green-for-dark-bg @endif" style="@if ($loop->odd) background: var(--c-green); color: var(--c-white); @else background: var(--c-white); color: var(--c-black-graphite); @endif">
                            <span>{!! $cta['footer_cta_text'] !!}</span>
                            <svg class="u-icon u-icon-24 u-icon--right">
                                <use xlink:href="{!! $iconLibUrl !!}#icon-arrow-right"/>
                            </svg>
                        </a>
                    @endif
                @endforeach
            </div>
        </section>

        <section class="footer-component-nav @lg:u-flex u-justify-content-space-between">
            @foreach ($data['menus'] as $menu)
                <nav class="@lg:gs-column-3 u-padding-l-0 u-padding-r-0 footer-component-nav__menu" aria-label="{!! $menu['name'] !!}">
                    <div @if (1 > count($menu['items'])) class="u-hidden @lg:u-block" @endif>
                        <p class="t-base-medium u-margin-b-3 collapsible-item js-menu-collapse-{!! $loop->index !!} u-flex u-justify-content-space-between @lg:u-block">
                            <span> {!! $menu['name'] !!} </span>
                            <svg class="u-icon u-icon-24 u-icon--right u-icon--no-fill @lg:u-hidden">
                                <use xlink:href="{!! $iconLibUrl !!}#icon-chevron-down"/>
                            </svg>
                        </p>
                        <div class="collapsible collapsible--stop" data-toggled-by=".js-menu-collapse-{!! $loop->index !!}">
                            @if (!empty($menu['expertise']))
                                <h4 class="footer-component-nav__menu-expertise-title collapsible-item js-menu-collapse-expertise u-flex u-justify-content-space-between @lg:u-block">
                                    <span> {!! $menu['expertise']['name'] !!} </span>
                                    <svg class="u-icon u-icon-24 u-icon--right u-icon--no-fill">
                                        <use xlink:href="{!! $iconLibUrl !!}#icon-chevron-down"/>
                                    </svg>
                                </h4>
                                <ul class="collapsible footer-component-nav__menu-expertise-nav" data-toggled-by=".js-menu-collapse-expertise">
                                    @foreach ($menu['expertise']['items'] as $item)
                                        <li class="u-margin-b-2 @if($loop->last) @lg:u-margin-b-0  @endif"> <a href="{!! $item['link'] !!}" title="{!! $item['title'] !!}" class="c-gray-40 ">{!! $item['title'] !!}</a> </li>
                                    @endforeach
                                </ul>
                            @endif

                            <ul>
                                @foreach ($menu['items'] as $item)
                                    <li class="@if (!$loop->last) u-margin-b-2 @else u-margin-b-4 @lg:u-margin-b-0 @endif" > <a href="{!! $item['link'] !!}" title="{!! $item['title'] !!}" class="c-gray-40 ">{!! $item['title'] !!}</a> </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </nav>
            @endforeach

            <nav class="footer-component-nav__social" aria-label="social medias">
                <p class="t-base-medium u-margin-b-3"> {!! $data['social_medias']['name'] !!} </p>
                <ul>
                    @foreach ($data['social_medias']['items'] as $item)
                        <li @if (!$loop->last) class="u-margin-b-2" @endif>
                            <a href="{!! $item['link'] !!}" title="{!! $item['title'] !!}" target="_blank" class="c-gray-40 u-flex u-justify-content-space-between u-align-items-center @lg:u-justify-content-start">
                                <div class="u-flex u-align-items-center">
                                    {!! $item['icon'] !!}
                                    <span class="">{!! $item['title'] !!}</span>
                                </div>
                                <svg class="footer-component-nav__social-arrow u-icon--no-fill u-icon u-icon-34 u-icon--right">
                                    <use xlink:href="{!! $iconLibUrl !!}#icon-arrow-right-thin"/>
                                </svg>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </section>

        <section class="footer-component-mentions @lg:u-flex u-justify-content-space-between u-align-items-center">

            <nav class="footer-component-mentions__nav" aria-label="legal mentions">
                <ul class="u-flex-column @md:u-flex-row">
                    @foreach ($data['menu_legal'] as $item)
                        <li>
                            <a href="{!! $item['link'] !!}" title="{!! $item['title'] !!}" class="c-gray-40"> {!! $item['title'] !!} </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

          <a href="{{ home_url() }}" title="{{ pll__('Efor - Accueil') }}" aria-label="{{ pll__('Efor - Accueil') }}">
            <svg class="u-block u-margin-auto u-icon u-icon-85 c-gold-secondary @lg:u-margin-0">
              <use xlink:href="{!! $iconLibUrl !!}#logo-efor"/>
            </svg>
          </a>
        </section>
    </div>
</footer-component>
