<div class="header-component-container--mobile @lg:u-hidden">
    <div class="header-component-base">
        <div class="header-component-base-left u-flex u-align-items-center">
            <a href="{{ home_url() }}" title="{{ pll__('Efor - Accueil') }}" aria-label="{{ pll__('Efor - Accueil') }}">
                <svg class="header-component-base__logo u-icon u-icon-50 c-gold-secondary u-margin-r-8">
                    <use xlink:href="{{ $iconLibUrl }}#logo-efor"/>
                </svg>
            </a>
        </div>

        <div class="header-component-base-right u-flex u-align-items-center">
            <button type="button" class="func-button --nav-close">
                <svg class="u-icon u-icon-24 u-icon--no-fill">
                    <use xlink:href="{{ $iconLibUrl }}#icon-close"/>
                </svg>
            </button>
        </div>
    </div>
    {{-- Mobile version - Navigation --}}
    <div class="header-component-content --mobile u-scrollable-on-y u-padding-b-0 u-border-b-0">
        <div class="header-component-nav u-fill-space @lg:u-hidden">
            @foreach ($data['menus'] as $menu)
                <nav class="header-component-nav-menu" aria-label="{{ $menu['name'] }}">
                    @if (1 >= count($menu['items']))
                        <a href="{!! $menu['items'][0]['link'] !!}" class="t-h4 @lg:u-hidden c-black-graphite">{!! $menu['name'] !!}</a>
                    @endif

                    <div @if (1 >= count($menu['items'])) class="u-hidden @lg:u-block" @endif>
                        <div class="header-component-nav-menu__title t-h4 u-margin-b-4 collapsible-item js-header-collapse-{!! $loop->index !!} u-flex u-justify-content-space-between u-align-items-center @lg:u-block">
                            <span> {!! $menu['name'] !!} </span>

                            <svg class="u-icon u-icon-24 u-icon--right u-icon--no-fill @lg:u-hidden">
                                <use xlink:href="{!! $iconLibUrl !!}#icon-chevron-down"/>
                            </svg>
                        </div>
                        <div class="collapsible collapsible--stop" data-toggled-by=".js-header-collapse-{!! $loop->index !!}">
                            @if (!empty($menu['expertise']))
                                <div class="header-component-nav-menu__expertise u-margin-b-2 collapsible-item js-header-collapse-expertise u-flex u-justify-content-space-between @lg:u-block">
                                    <span> {!! $menu['expertise']['name'] !!} </span>
                                    <svg class="u-icon u-icon-24 u-icon--right u-icon--no-fill @lg:u-hidden">
                                        <use xlink:href="{!! $iconLibUrl !!}#icon-chevron-down"/>
                                    </svg>
                                </div>
                                <ul class="collapsible header-component-nav-menu__expertise-nav" data-toggled-by=".js-header-collapse-expertise">
                                    @foreach ($menu['expertise']['items'] as $item)
                                        <li class="u-margin-b-2"> <a href="{!! $item['link'] !!}">{!! $item['title'] !!}</a> </li>
                                    @endforeach
                                </ul>
                            @endif

                            <ul>
                                @foreach ($menu['items'] as $item)
                                    <li class="@if (!$loop->last) u-margin-b-2 @else u-margin-b-4 @lg:u-margin-b-0 @endif"><a href="{!! $item['link'] !!}">{!! $item['title'] !!}</a> </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </nav>
            @endforeach
        </div>

        <div class="u-flex u-justify-content-space-between u-align-items-center @lg:u-hidden">
            @include('HeaderComponent.partials.block-cta')
            @include('HeaderComponent.partials.block-lang')
        </div>
    </div>
</div>
