@php $iconLibUrl = \App\asset_path('images/icon-lib.svg') @endphp

{{-- dump($data): All data's available for this view --}}
<section class="gs-fluid-container u-block @if('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif chiffres-component__overflow">
  <chiffres-component class="chiffres-component">
  <svg class="chiffres-component__background u-hidden @lg:u-block" width="1390" height="2186" viewBox="0 0 1390 2186" fill="none" xmlns="http://www.w3.org/2000/svg">
    <g opacity="0.2" clip-path="url(#clip0_5350_33675)">
      <path opacity="0.6" d="M-673.462 1760.32C-26.496 1746.82 1422.35 1583.44 1855.47 1008.98" stroke="#ACA9A9"/>
      <path d="M-674.199 1767.2C102.289 1760.07 1271.53 1292.81 1724.56 643.997" stroke="#C9A778" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="4.66 4.66"/>
      <path opacity="0.6" d="M-672.603 1762.47C247.487 1733.23 1313.07 850.253 1543.22 257.799" stroke="#ACA9A9"/>
    </g>
    <defs>
    <clipPath id="clip0_5350_33675">
      <rect width="3025.74" height="1787.2" fill="white" transform="translate(-1208.63 432.644) rotate(-11.2004)"/>
    </clipPath>
    </defs>
  </svg>
    <div class="gs-row">
      <div class="@lg:gs-column-4 @lg:gs-pull-1 @lg:u-margin-b-0 u-margin-b-7 chiffres-component__left">
        <h2 class="chiffres-component__title t-h2 u-margin-b-3">
          {!! $data['title']['title_1'] ?? '' !!}
          <span class="t-sometimes-times u-block">{!! $data['title']['title_2'] ?? '' !!}</span>
        </h2>
        <p class="chiffres-component__content u-margin-b-3">{!! $data['content'] ?? '' !!}</p>
        @if(!empty($data['link']['url']) && !empty($data['link']['title']))
          <a href="{!! $data['link']['url'] !!}"
             target="{!! $data['link']['target'] ?? '' !!}"
             class="button chiffres-component__button {!! 'white' === ($data['link_color'] ?? '') ? 'button--white' : '' !!}"
             style="background: var(--c-{!! $data['link_color'] ?? '' !!}); color: var(--c-{!! $data['link_color_text'] ?? '' !!}); {!! 'white' === $data['link_color'] ? 'border: 1px solid var(--c-black-graphite)' : '' !!}"
          >
            <span>{!! $data['link']['title'] !!}</span>
            <svg class="u-icon u-icon-24 u-icon--right {!! 'white' !== ($data['link_color'] ?? '') ? 'c-white' : '' !!}">
              <use xlink:href="{{ $iconLibUrl }}#icon-arrow-right"/>
            </svg>
          </a>
        @endif
      </div>
      <div class="@lg:gs-column-7">
        <div class="chiffres-component__cards">
          @if(!empty($data['chiffres']))
            @foreach($data['chiffres'] as $chiffre)
              <div class="chiffre-card @if('white' === $chiffre['background']) bg-gray-20 @else bg-{!! $chiffre['background'] !!} @endif @if('gold' === $chiffre['background'] && $chiffre['text_color']) c-white @else c-{!! $chiffre['text_color'] !!} @endif">
                <p class="chiffre-card__title @if('white' === $chiffre['background']) c-gold @endif">{!! $chiffre['title'] !!}</p>
                <p class="chiffre-card__subtitle">{!! $chiffre['content'] !!}</p>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </chiffres-component>
</section>
