@php $iconLibUrl = \App\asset_path('images/icon-lib.svg') @endphp

<sidebar-component class="sidebar-component c-{!! $data['color'] ?? '' !!}">
  <a class="sidebar-component__content bg-{!! $data['color'] ?? '' !!}" href="{!! $data['link_url'] ?? '#' !!}">
    <button class="button c-white" disabled>
      <span>{!! $data['link_text'] ?? '' !!}</span>
      <svg class="u-icon u-icon-24 u-icon--right c-white">
        <use xlink:href="{{ $iconLibUrl }}#icon-arrow-right"/>
      </svg>
    </button>
  </a>
</sidebar-component>
