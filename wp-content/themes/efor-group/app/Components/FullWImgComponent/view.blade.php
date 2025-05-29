{{-- dump($data): All data's available for this view --}}
<section class="gs-fluid-container full-w-img-container @if('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
  <full-w-img-component class="full-w-img-component u-width-100%">
    <div class="full-w-img ratio-block ratio-block--14/15 @lg:ratio-block--97/252">
      {!! $data['image'] !!}
    </div>
  </full-w-img-component>
</section>
