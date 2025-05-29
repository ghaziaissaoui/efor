@php $iconLibUrl = \App\asset_path('images/icon-lib.svg') @endphp

{{-- dump($data): All data's available for this view --}}
<contact-page-component class="contact-page-component u-flex u-flex-wrapping u-width-100% u-margin-t-12 @lg:u-margin-t-10">
  <div class="@lg:gs-column-6">
    <h1 class="contact-page-component__title t-h1 @lg:gs-flush-column-8 t-align-center @lg:t-align-left">
      {!! $data['title']['title_1'] ?? '' !!}
      <span class="t-sometimes-times u-block">{!! $data['title']['title_2'] ?? '' !!}</span>
    </h1>
    <div class="contact-page-component__text">
      {!! $data['content'] !!}
    </div>
    <div class="ratio-block ratio-block--50/67 @lg:ratio-block--80/117">
      {!! $data['image'] !!}
    </div>
  </div>

  <div class="contact-form @lg:gs-column-6 u-margin-t-10 @lg:u-margin-t-0">
    {!! $data['form'] !!}
  </div>
</contact-page-component>
