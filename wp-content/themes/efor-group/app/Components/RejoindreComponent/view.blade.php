@php $iconLibUrl = \App\asset_path('images/icon-lib.svg') @endphp

{{-- dump($data): All data's available for this view --}}
<section class="u-block u-block bg-{!! $data['background'] !!} @if('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
  <rejoindre-component class="rejoindre-component">
    <div class="gs-fluid-container">
      <div class="gs-row">

        <div class="@sm:u-block u-hidden image__left rejoindre-image @sm:gs-column-6">
          <div class="ratio-block ratio-block--166/97 @sm:ratio-block--118/133">
            {!! $data['image_left'] ?? '' !!}
          </div>
        </div>

        <div class="content @sm:gs-column-7 @lg:gs-column-5 u-centered-on-x u-align-items-center u-flex t-align-center u-flex-column c-{!! $data['global_text_color'] !!}">
          <h2 class="t-h2  c-{!! $data['global_text_color'] !!}">
            {!! $data['title']['title_1'] ?? '' !!}
            <span class="t-sometimes-times u-block">{!! $data['title']['title_2'] ?? '' !!}</span>
          </h2>
          {!! $data['content'] ?? '' !!}
          @if(!empty($data['link']['url']) && !empty($data['link']['title']))
            <a href="{!! $data['link']['url'] !!}" target="{!! $data['link']['target'] ?? '' !!}" class="button u-fit-content {!! 'white' === ($data['link_color'] ?? '') ? 'button--white' : '' !!}" style="background: var(--c-{!! $data['link_color'] ?? '' !!}); color:var(--c-{!! $data['link_color_text'] ?? '' !!});">
              <span>{!! $data['link']['title'] !!}</span>
              <svg class="u-icon u-icon-24 u-icon--right {!! 'white' !== ($data['link_color'] ?? '') ? 'c-white' : '' !!}">
                <use xlink:href="{{ $iconLibUrl }}#icon-arrow-right"/>
              </svg>
            </a>
          @endif
        </div>

        <div class="image__right rejoindre-image gs-column-9 @sm:gs-column-6">
          <div class="ratio-block ratio-block--4/5 @sm:ratio-block--571/665">
            {!! $data['image_right'] ?? '' !!}
          </div>
        </div>

      </div>
    </div>
  </rejoindre-component>
</section>
