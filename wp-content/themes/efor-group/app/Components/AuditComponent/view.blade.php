{{-- dump($data): All data's available for this view --}}
<section class="bg-{!! $data['background'] !!}">
  <div class="gs-fluid-container">
    <audit-component class="audit-component u-block c-{!! $data['global_text_color'] !!}">
      <div class="gs-row u-margin-b-8 @md:u-margin-b-10">
        <div class="@md:gs-column-6">
          @if(!empty($data['left_image']))
            <div class="ratio-block ratio-block--203/280 @lg:ratio-block--405/556">
              {!! $data['left_image'] !!}
            </div>
          @endif
        </div>
        <div class="@md:gs-column-6 u-centered-on-y audit-component__text--right">
          <h3 class="t-h3 u-margin-b-3 @md:u-margin-b-4">{!! $data['title_1'] ?? '' !!}</h3>
          {!! $data['content_1'] ?? '' !!}
        </div>
      </div>
      <div class="gs-row u-flex-column-reverse @md:u-flex-row">
        <div class="@md:gs-column-6 u-centered-on-y audit-component__text--left">
          <h3 class="t-h3 u-margin-b-3 @md:u-margin-b-4">{!! $data['title_2'] ?? '' !!}</h3>
          {!! $data['content_2'] ?? '' !!}
        </div>
        <div class="@md:gs-column-6">
          @if(!empty($data['right_image']))
            <div class="ratio-block ratio-block--203/280 @lg:ratio-block--405/556">
              {!! $data['right_image'] !!}
            </div>
          @endif
        </div>
      </div>
    </audit-component>
  </div>
</section>
