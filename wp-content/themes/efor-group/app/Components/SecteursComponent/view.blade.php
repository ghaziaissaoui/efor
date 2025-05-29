@php $iconLibUrl = \App\asset_path('images/icon-lib.svg') @endphp

{{-- dump($data): All data's available for this view --}}
<section>
  <secteurs-component class="secteurs-component">
    <div class="ratio-block ratio-block--70/67 @lg:ratio-block--9/17">
      {!! $data['image'] !!}
    </div>
    <div class="wrapper t-align-center c-white">
      <h2 class="hero-component__title t-h2 u-margin-b-3 @lg:u-margin-b-6">
        {!! $data['title']['title_1'] ?? '' !!}
        <span class="t-sometimes-times u-block">{!! $data['title']['title_2'] ?? '' !!}</span>
      </h2>
      {!! $data['content'] !!}
      @if(!empty($data['link']['url']) && !empty($data['link']['title']))
        <a href="{!! $data['link']['url'] !!}"
           target="{!! $data['link']['target'] ?? '' !!}"
           class="button u-margin-t-3 @lg:u-margin-t-6 {!! 'white' === ($data['link_color'] ?? '') ? 'button--white' : '' !!}"
           style="background: var(--c-{!! $data['link_color'] ?? '' !!}); color: var(--c-{!! $data['link_color_text'] ?? '' !!}); {!! 'white' === ($data['link_color'] ?? '') ? 'border: 1px solid var(--c-black-graphite)' : '' !!}"
        >
          <span>{!! $data['link']['title'] !!}</span>
          <svg class="u-icon u-icon-24 u-icon--right {!! 'white' !== ($data['link_color'] ?? '') ? 'c-white' : '' !!}">
            <use xlink:href="{{ $iconLibUrl }}#icon-arrow-right"/>
          </svg>
        </a>
      @endif
    </div>
  </secteurs-component>
</section>
