<a href="{!! $card['permalink'] !!}" class="card__img u-block">
    <div class="ratio-block ratio-block--2/3 @lg:ratio-block--127/200">
        {!! $card['image'] !!}
    </div>
    <button disabled class="button button--white" style="background: var(--c-white); color: var(--c-black-graphite);">
        <span>{!! pll__('Découvrir le témoignage') !!}</span>
        <svg class="u-icon u-icon-24 u-icon--right">
            <use xlink:href="{{ $iconLibUrl }}#icon-arrow-right" />
        </svg>
    </button>
</a>

<div class="u-flex u-align-items-center u-justify-content-space-between">
    @if (!empty($card['tag']))
        <a href="{!! $card['tag']['link'] ?? '' !!}" class="card__tag tag bg-gray-30">{!! $card['tag']['name'] ?? '' !!}</a>
    @endif
    <p class="card__date">{!! $card['published_date'] !!}</p>
</div>

<a href="{!! $card['permalink'] !!}" class="card__text u-block">
    @if (!empty($isH2))
        <h2 class="card__title t-h6">{!! $card['title'] !!}</h2>
    @else
        <h3 class="card__title t-h6">{!! $card['title'] !!}</h3>
    @endif
    <p class="card__desc t-base-small">{!! $card['excerpt'] !!}</p>
</a>
