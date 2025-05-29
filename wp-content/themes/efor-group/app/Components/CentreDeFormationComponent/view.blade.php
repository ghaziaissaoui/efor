@php $iconLibUrl = \App\asset_path('images/icon-lib.svg') @endphp
{{-- dump($data): All data's available for this view --}}
<section>
  <div class="u-absolute bg-map">
    <div class="ratio-block ratio-block">
      <svg class="ratio-block__content u-hidden @sm:u-block">
        <use xlink:href="{{ $iconLibUrl }}#bg-map--desktop"/>
      </svg>

      <svg class="ratio-block__content @sm:u-hidden">
        <use xlink:href="{{ $iconLibUrl }}#bg-map--mobile"/>
      </svg>
    </div>
  </div>

  <div class="gs-fluid-container">
      <centre-de-formation-component class="centre-de-formation-component u-block">
        <div class="u-flex-column u-centered-on-x t-align-center">
          <h2 class="u-width-100% hero-component__title t-h2 u-margin-b-5 @lg:u-margin-b-9">
            {!! $data['title']['title_1'] ?? '' !!}
            <span class="t-sometimes-times u-block">{!! $data['title']['title_2'] ?? '' !!}</span>
          </h2>

          @if(!empty($data['cards']))
            <div class="cards gs-row u-flex-column @lg:u-flex-row u-margin-b-5 @lg:u-margin-b-9">
              @foreach($data['cards'] as $card)
                <div class="card @lg:gs-column-3">
                  <div class="card-wrap bg-gold">
                    <p class="t-header-medium c-white t-align-center">{!! $card['title'] !!}</p>
                  </div>
                </div>
              @endforeach
            </div>
          @endif

          @if(!empty($data['link']['url']))
            <a href="{!! $data['link']['url'] !!}" target="{!! $data['link']['target'] !!}" class="button u-fit-content c-gold bg-black-graphite u-block u-centered-on-x">
              <span>{!! $data['link']['title'] !!}</span>
              <svg class="u-icon u-icon-24 u-icon--right {!! 'white' !== ($data['link_color'] ?? '') ? 'c-white' : '' !!}">
                <use xlink:href="{{ $iconLibUrl }}#icon-arrow-right"/>
              </svg>
            </a>
          @endif
        </div>
      </centre-de-formation-component>
  </div>
</section>
