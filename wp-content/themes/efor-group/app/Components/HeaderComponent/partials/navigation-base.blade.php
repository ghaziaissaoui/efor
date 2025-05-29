<div class="header-component-base {{ $block_class ?? '' }}">
    <div class="header-component-base-left u-flex u-align-items-center">
        <a href="{{ home_url() }}" title="{{ pll__('Efor - Accueil') }}" aria-label="{{ pll__('Efor - Accueil') }}">
            <svg class="header-component-base__logo u-icon u-icon-50 c-gold-secondary u-margin-r-8">
                <use xlink:href="{{ $iconLibUrl }}#logo-efor"/>
            </svg>
        </a>
        <nav class="header-component-base-nav u-hidden @lg:u-block">
            <ul class="header-component-base-nav__links">
                @foreach ($data['menus'] as $menu)
                    @if (1 < count($menu['items']))
                        <li class="header-component-base-nav__link" data-menu-name="{{ $menu['name'] }}">
                            <span>{{ $menu['name'] }}</span>
                        </li>
                    @else
                        <li class="header-component-base-nav__link">
                            <a href="{{ $menu['items'][0]['link'] }}" class="t-link-fx">{{ $menu['name'] }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>

    <div class="header-component-base-right u-flex u-align-items-center">
        @include('HeaderComponent.partials.block-lang', ['block_class' => 'u-hidden @lg:u-block'])

        <button type="button" class="header-component-base-search func-button" title="{{ pll__('Rechercher') }}" aria-label="{{ pll__('Rechercher') }}">
            <svg class="u-icon u-icon-24 u-icon--no-fill">
                <use xlink:href="{{ $iconLibUrl }}#icon-search"/>
            </svg>
        </button>

        @include('HeaderComponent.partials.block-cta', ['block_class' => 'u-hidden @lg:u-flex'])

        <button type="button" class="header-component-base-burger func-button @lg:u-hidden">
            <span class="header-component-base-burger__bar"></span>
            <span class="header-component-base-burger__bar"></span>
        </button>
    </div>
</div>
