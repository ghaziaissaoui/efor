<div class="card-redirect">
  <div class="ratio-block ratio-block--440/313 @lg:ratio-block--143/131">
    {!! $card['img'] ?? '' !!}
  </div>
  <div class="card-redirect__content u-width-100%">
    <p class="t-h4 c-white t-align-left">
    {!! $card['title']['title_1'] ?? '' !!}
    <span class="t-sometimes-times">{!! $card['title']['title_2'] ?? '' !!}</span>
    </p>
    <a class="button button--white button--sized u-margin-t-4" style="background: var(--c-white); color: var(--c-black-graphite);" href="{!! $card['link']['url'] ?? '#' !!}" target="{!! $card['link']['target'] ?? '' !!}">
      <span>{!! $card['link']['title'] ?? '' !!}</span>
      <svg class="u-icon u-icon-24 u-icon--right">
        <use xlink:href="{{ $iconLibUrl }}#icon-arrow-right"/>
      </svg>
    </a>
  </div>
</div>
