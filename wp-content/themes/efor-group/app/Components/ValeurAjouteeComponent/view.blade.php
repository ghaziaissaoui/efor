{{-- dump($data): All data's available for this view --}}
<section class="bg-{!! $data['background'] !!} @if('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
  <div class="gs-fluid-container">
    <valeur-ajoutee-component class="valeur-ajoutee-component u-block c-{!! $data['global_text_color'] !!}">
      <div class="t-align-center">
        <h2 class="hero-component__title t-h2 c-white u-margin-b-6">
          {!! $data['title']['title_1'] ?? '' !!}
          <span class="t-sometimes-times u-block">{!! $data['title']['title_2'] ?? '' !!}</span>
        </h2>
        <div class="valeur-ajoutee-component__content t-base-medium">
          {!! $data['content'] ?? '' !!}
        </div>
      </div>

      @if(!empty($data['cards']))
        <div class="u-flex cards u-margin-t-12">
          @foreach($data['cards'] as $card)
            <div class="card">
              <div class="ratio-block ratio-block--1/1 u-margin-b-2 @lg:u-margin-b-5">
                {!! $card['logo'] ?? '' !!}
              </div>
              @if(!empty($card['title']))
                <h3 class="t-h3 u-margin-b-2 @lg:u-margin-b-4">{!! $card['title'] !!}</h3>
              @endif
              <div class="t-base-medium">
                {!! $card['description'] ?? '' !!}
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </valeur-ajoutee-component>
  </div>
</section>

