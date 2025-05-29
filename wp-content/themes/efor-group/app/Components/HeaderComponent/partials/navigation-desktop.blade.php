{{-- Desktop version - Navigation --}}
<div class="header-component-content --desktop u-hidden @lg:u-block">
  @foreach ($data['menus'] as $menu)
    <nav class="header-component-nav-menu @if (!empty($menu['expertise'])) u-flex @endif" aria-label="{!! $menu['name'] ?? '' !!}" data-menu-name="{!! $menu['name'] ?? '' !!}">
      <ul>
        @if (!empty($menu['expertise']))
          <li class="header-component-nav-menu__link u-margin-b-2" data-submenu-name="{!! $menu['expertise']['name'] ?? '' !!}">
            <span>{!! $menu['expertise']['name'] ?? '' !!}</span>
          </li>
        @endif
        @if (1 < count($menu['items']))
          @foreach ($menu['items'] as $item)
            <li class="header-component-nav-menu__link @if (!$loop->last) u-margin-b-2 @else u-margin-b-4 @lg:u-margin-b-0 @endif" >
              <a href="{!! $item['link'] ?? '' !!}" class="t-link-fx">{!! $item['title'] ?? '' !!}</a>
            </li>
          @endforeach
        @endif
      </ul>
      @if (!empty($menu['expertise']))
        <ul class="header-component-nav-menu__submenu" data-submenu-name="{!! $menu['expertise']['name'] ?? '' !!}">
          @foreach ($menu['expertise']['items'] as $item)
            <li class="u-margin-b-2"> <a href="{!! $item['link'] ?? '' !!}" class="t-link-fx">{!! $item['title'] ?? '' !!}</a> </li>
          @endforeach
        </ul>
      @endif
    </nav>
  @endforeach
</div>
