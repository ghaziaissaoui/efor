{{-- dump($data): All data's available for this view --}}
<section @if('inverted' === ($data['color_scheme'] ?? '')) class="bg-black-graphite c-white @lg:u-padding-t-12 u-padding-t-8 u-padding-b-6 @lg:u-padding-b-12" @endif>
  <div class="gs-fluid-container @if('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
    <div class="gs-row">
      <storytelling-component class="storytelling-component">
        <div class="storytelling @md:gs-column-10 @md:gs-push-1 @md:gs-pull-1">
          @if($data['title']) <h2 class="storytelling__title @lg:t-align-center t-h3">{{ $data['title'] }}</h2> @endif
          <div class="storytelling__text t-h5">
            {!! $data['content'] !!}
          </div>
        </div>
      </storytelling-component>
    </div>
  </div>
</section>

