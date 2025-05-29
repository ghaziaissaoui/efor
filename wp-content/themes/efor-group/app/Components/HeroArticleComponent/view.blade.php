@php $iconLibUrl = \App\asset_path('images/icon-lib.svg') @endphp

@if('sided' === $data['heroType'])
  <section class="gs-fluid-container--left u-margin-t-8 @lg:u-margin-t-10">
    @if(!empty($data['back_button']))
      <a class="back-button u-flex u-align-items-center c-black-graphite" href="{!! $data['back_button'] !!}">
        <svg class="u-icon u-icon-24 u-icon--left u-icon--no-fill">
          <use xlink:href="{{ $iconLibUrl }}#icon-chevron-down"/>
        </svg>
        <span class="t-link-fx">{!! pll__('Retour') !!}</span>
      </a>
    @endif
    <hero-article-component class="hero-article-component @md:u-flex-row u-align-items-center">
      <div class="hero-article-component__text @md:gs-column-6">
        <div class="tag bg-gray-30 u-align-self-start">{!! $data['category'] ?? '' !!}</div>
        <h1 class="hero-component__title t-h3">{!! $data['title'] ?? '' !!}</h1>
        <p class="c-gray-40 t-base-small">{!! $data['published_date'] ?? '' !!}</p>
      </div>

      <div class="hero-article-component__img @md:gs-flush-column-fill-space">
        <div class="ratio-block ratio-block--14/15 @lg:ratio-block--9/11">
          {!! $data['image'] !!}
        </div>
      </div>
    </hero-article-component>
  </section>
@else
  <section class="gs-fluid-container">
    @if(!empty($data['back_button']))
      <div class="@md:gs-column-8 @md:gs-pull-2 @md:gs-push-2 u-margin-t-5">
        <a class="back-button u-flex u-align-items-center c-black-graphite" href="{!! $data['back_button'] !!} ">
          <svg class="u-icon u-icon-24 u-icon--left u-icon--no-fill">
            <use xlink:href="{{ $iconLibUrl }}#icon-chevron-down"/>
          </svg>
          <span class="t-link-fx">{!! pll__('Retour') !!}</span>
        </a>
      </div>
    @endif
    <div class="gs-row">
      <hero-article-component class="hero-article-component u-margin-t-6 @lg:u-margin-t-12 @md:u-flex-row u-align-items-center u-width-100%">
        <div class="hero-article-component__text @md:gs-column-8 @md:gs-pull-2 @md:gs-push-2">
          <div class="tag bg-gray-30 u-align-self-start">{!! $data['category'] ?? '' !!}</div>
          <h1 class="hero-component__title t-h2">{!! $data['title'] ?? '' !!}</h1>
          <p class="c-gray-40 t-base-small">{!! $data['published_date'] ?? '' !!}</p>
        </div>
      </hero-article-component>
    </div>
  </section>
  {!! $data['image'] ?? '' !!}
@endif
