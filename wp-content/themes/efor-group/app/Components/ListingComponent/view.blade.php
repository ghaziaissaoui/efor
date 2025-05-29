@php $iconLibUrl = \App\asset_path('images/icon-lib.svg') @endphp
{{-- dump($data): All data's available for this view --}}
<listing-component
  class="listing-component u-width-100%"
  data-paged="1"
  data-cpt="{!! $data['post_types'] !!}"
  data-size="{!! $data['numberPost'] !!}"
  data-url="{!! $data['url'] !!}"
  data-cat="{!! $data['cat'] ?? ''!!}"
  >
  <div class="listing-content u-flex u-flex-wrapping">
    @include('ListingComponent.partials.card-loop')
  </div>
  @if($data['hasNext'])
    <button class="button u-centered-on-x u-flex bg-gold arrow load-more">
      <span>{!! pll__('Voir plus de résultats') !!}</span>
      <svg class="u-block u-icon u-icon-24 u-icon--right c-white">
        <use xlink:href="{{ $iconLibUrl }}#icon-plus"/>
      </svg>
    </button>
  @endif
</listing-component>
