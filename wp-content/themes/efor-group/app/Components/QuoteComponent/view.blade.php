{{-- dump($data): All data's available for this view --}}
{{-- Custom content displayed on single talent or when displayed inside talent slider modal --}}
@if(is_singular('talent') || wp_doing_ajax())
  <quote-component class="quote-component">
    <div class="quote">
      <div class="quote__container bg-gray-20">
        <div class="quote__content">
          {!! $data['content'] !!}
          <h2 class="quote__author t-h4">
            <span>{!! $data['title']['title_1'] !!}</span>
            <span class="t-sometimes-times">{!! $data['title']['title_2'] !!}</span>
          </h2>
        </div>
      </div>
    </div>
  </quote-component>
@else
<section class="gs-fluid-container @if('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
  <div class="gs-row">
    <quote-component class="quote-component">
      <div class="quote @md:gs-column-8 @md:gs-push-2 @md:gs-pull-2">
        <div class="quote__container bg-gray-20">
          <div class="quote__content">
            {!! $data['content'] !!}
            <h2 class="quote__author t-h4">
              <span>{!! $data['title']['title_1'] !!}</span>
              <span class="t-sometimes-times">{!! $data['title']['title_2'] !!}</span>
            </h2>
          </div>
        </div>
      </div>
    </quote-component>
  </div>
</section>
@endif
