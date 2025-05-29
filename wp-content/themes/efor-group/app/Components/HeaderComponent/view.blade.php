@php $iconLibUrl = \App\asset_path('images/icon-lib.svg') @endphp

<header-component
    class="header-component t-neutral-links c-black-graphite @if(true === $data['header_transparent']) header-component--transparent @endif"
    data-navlinks=".header-component-base-nav__link"
    data-nav-menu=".--desktop .header-component-nav-menu"
    data-nav-menu-links=".header-component-nav-menu__link"
    data-nav-submenu=".header-component-nav-menu__submenu"
    data-burger=".header-component-base-burger"
    data-close=".--nav-close"
    data-search-btn=".header-component-base-search"
    data-search-elmt=".header-component-search">

    <div class="gs-fluid-container">
        <div class="header-component-container">
            @include('HeaderComponent.partials.navigation-base')
            @include('HeaderComponent.partials.navigation-desktop')
            @include('HeaderComponent.partials.navigation-mobile')
        </div>
    </div>
    @include('HeaderComponent.partials.search')
</header-component>
