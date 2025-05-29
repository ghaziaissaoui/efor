{{-- dump($data): All data's available for this view --}}
<section class="gs-fluid-container u-block @if('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
  <card-focus-component class="card-focus-component bg-{!! $data['background'] !!} u-block @md:u-flex">
    <h2 class="card-focus-component__title t-h3 @md:gs-column-5 c-{!! $data['global_text_color'] !!}">
      {!! $data['title'] !!}
    </h2>

    <p class="card-focus-component__text t-base-medium @md:gs-column-7 c-{!! $data['global_text_color'] !!}">
      {!! $data['content'] !!}
    </p>
  </card-focus-component>
</section>
