<section class="header-component-search">
    <div class="gs-fluid-container">
        <form action="{!! esc_url(home_url('/')) !!}" method="get" aria-labelledby="{{pll__('Formulaire de recherche')}}" class="header-component-search-form form u-fill-space">
            <input type="text" name="s" id="search" class="header-component-search-form__input u-width-100% t-base-small bg-gray-30" placeholder="{{ pll__('Rechercher') }}">
            <button type="submit" class="func-button c-white" title="{{ pll__('Soumettre la recherche') }}" aria-label="{{ pll__('Soumettre la recherche') }}">
                <svg class="u-icon u-icon-24 u-icon--no-fill">
                    <use xlink:href="{{ $iconLibUrl }}#icon-search"/>
                </svg>
            </button>
        </form>
        <button type="button" class="func-button --search-close">
            <svg class="u-icon u-icon-24 u-icon--no-fill">
                <use xlink:href="{{ $iconLibUrl }}#icon-close"/>
            </svg>
        </button>
    </div>
</section>
