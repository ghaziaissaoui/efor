{{-- dump($data): All data's available for this view --}}
<section class="gs-fluid-container u-relative u-overflow-hidden">
  <svg class="chiffre-component__background u-hidden @lg:u-block" width="1440" height="2322" viewBox="0 0 1440 2322" fill="none" xmlns="http://www.w3.org/2000/svg">
    <g opacity="0.4" clip-path="url(#clip0_6249_45015)">
      <path opacity="0.6" d="M-304.15 1859.7C312.052 1662.1 1654 1092 1905.14 417.817" stroke="#ACA9A9"/>
      <path d="M-302.892 1866.5C439.261 1638.05 1426.5 856.5 1675.5 105.378" stroke="#C9A778" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="4.66 4.66"/>
      <path opacity="0.6" d="M-302.712 1861.52C570.759 1570.88 1340 420.5 1391.48 -213" stroke="#ACA9A9"/>
    </g>
    <defs>
      <clipPath id="clip0_6249_45015">
        <rect width="3025.74" height="1787.2" fill="white" transform="translate(-1196 740) rotate(-27.7842)"/>
      </clipPath>
    </defs>
  </svg>
  <chiffre-component class="chiffre-component">
    <div class="gs-row c-gold">
      <div class="@lg:gs-column-6 chiffre-component__number u-margin-b-5 @lg:u-margin-b-0">
        <div class="@lg:t-align-right">
          {!! $data['chiffre'] ?? '' !!}
        </div>
      </div>
      <div class="@lg:gs-column-4 @lg:gs-pull-2 u-flex-column u-justify-content-center">
        <div class="chiffre-component__content u-block">
          <p class="c-gold t-h5 u-margin-b-2 @lg:u-margin-b-3">{!! $data['title'] ?? '' !!}</p>
          {!! $data['content'] !!}
        </div>
      </div>
    </div>
  </chiffre-component>
</section>
