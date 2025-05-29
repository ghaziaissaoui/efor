{{-- dump($data): All data's available for this view --}}
<div class="expertises-component__overflow">
  <section class="gs-fluid-container @if('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
    <expertises-component class="expertises-component u-block">
      <svg class="expertises-component__background" width="1109" height="1126" viewBox="0 0 1109 1126" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M975.116 1.25222C645.709 41.182 -95.2959 172.709 -424.066 379.377" stroke="#514A41" stroke-opacity="0.2"/>
        <path d="M975.116 1.25196C645.709 41.1817 -79.5602 316.6 -408.33 523.268" stroke="#514A41" stroke-opacity="0.2" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="5.39 5.39"/>
        <path d="M975.114 1.24491C645.708 41.1747 -127.156 438.671 -374.404 734.679" stroke="#514A41" stroke-opacity="0.2"/>
        <path d="M975.114 1.24606C645.708 41.1758 -124.247 738.214 -295.62 1125.55" stroke="#514A41" stroke-opacity="0.2"/>
      </svg>
      <div class="gs-row">
        <div class="expertises-component__text @lg:gs-column-4 u-margin-b-5 @lg:u-margin-b-0">
          <h2 class="hero-component__title t-h2 u-margin-b-5">
            {!! $data['title']['title_1'] ?? '' !!}
            <span class="t-sometimes-times u-block">{!! $data['title']['title_2'] ?? '' !!}</span>
          </h2>
          {!! $data['content'] !!}
        </div>
        <div class="@lg:gs-column-8">
          @if(!empty($data['expertises']))
            <div class="expertises-component__grid">
              @foreach($data['expertises'] as $expertise)
                <a href="{!! $expertise['lien']['url'] ?? '' !!}" target="{!! $expertise['lien']['target'] ?? '' !!}" class="u-relative @lg:gs-column-3 expertise-card bg-{!! $expertise['color'] !!} c-{!! $expertise['text_color'] !!}">
                  <div class="expertise-card__content @lg:u-absolute">
                    <div class="ratio-block @lg:u-margin-b-2">
                      {!! $expertise['icon'] ?? '' !!}
                    </div>
                    <p class="u-block t-align-center">{!! $expertise['lien']['title'] ?? '' !!}</p>
                    <svg class="expertise-card__arrow c-{!! $expertise['text_color'] !!}  u-block @lg:u-hidden" width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M5 12.4121H19M12.1112 5.5L19.1112 12.5L12.1112 19.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </div>
                  <div class="expertise-card__hover">
                    <button class="button u-relative u-padding-r-6 u-padding-l-3 u-padding-t-1 u-padding-b-1 c-black bg-white expertise-card__hover__button">{!! pll__('En savoir plus') !!}</button>
                  </div>
                </a>
              @endforeach
            </div>
          @endif
        </div>
      </div>
    </expertises-component>
  </section>
</div>

