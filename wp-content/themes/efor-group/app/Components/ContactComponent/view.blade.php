@php $iconLibUrl = \App\asset_path('images/icon-lib.svg') @endphp

{{-- dump($data): All data's available for this view --}}
<section class="gs-fluid-container" id="contact">
  <div class="gs-row">
    <contact-component class="contact-component @md:gs-column-10 @md:gs-push-1 @md:gs-pull-1 @if('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
      <div class="contact-header">
        <h2 class="contact-header__title t-h2 t-align-center">{!! $data['title']['title_1'] ?? '' !!} <span
                  class="t-sometimes-times u-block">{!! $data['title']['title_2'] ?? '' !!}</span></h2>
        {!! $data['img_landscape_btn'] ?? '' !!}
      </div>
      <div class="contact-form">
          <div class="gs-row">
            <p class="contact-form__title t-h6 u-margin-t-5 u-margin-b-5 @lg:u-margin-t-5 @md:t-align-center @md:gs-column-6 @md:gs-push-3 @md:gs-push-3 u-centered-on-x">{!! $data['form_title'] !!}</p>
          </div>
          {!! $data['form_id'] !!}
        </div>
    </contact-component>
  </div>
</section>
