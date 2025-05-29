@php $iconLibUrl = \App\asset_path('images/icon-lib.svg') @endphp

{{-- dump($data): All data's available for this view --}}
<filters-component class="filters-component gs-column u-width-100% u-flex u-flex-wrapping u-align-items-center u-margin-b-7">
  <div class="tags gs-column @md:gs-column-7 @lg:gs-column-9 @lg:u-flex u-align-items-center">
    <p class="t-label-medium @lg:u-margin-r-2">{!! pll__('Filtres :') !!}</p>
    @foreach($data['filters'] as $filter)
      <a class="tag u-margin-b-2 @lg:u-margin-b-0 @if($filter['active']) active @endif" href="{!! $filter['link'] !!}">{!! $filter['name'] !!}</a>
    @endforeach
  </div>
  <div class="gs-column @md:gs-column-5 @lg:gs-column-3 u-margin-t-4 @lg:u-margin-t-0">
    <form action="?{!! http_build_query($_GET) !!}">
      <div class="wrapper">
        <input type="text" placeholder="{!! pll__('Recherche') !!}" name="search" value="{!! $data['search'] ?? '' !!}">
        <button type="submit" class="func-button c-black">
          <svg class="u-icon u-icon-24 u-icon--no-fill">
            <use xlink:href="{{ $iconLibUrl }}#icon-search"/>
          </svg>
        </button>
      </div>
      @if(!empty($_GET['content_type']))
          <input type="hidden" name="content_type" value="{!! $_GET['content_type'] !!}">
      @elseif(!empty($_GET['cat']))
          <input type="hidden" name="cat" value="{!! $_GET['cat'] !!}">
      @endif
    </form>
  </div>
</filters-component>
