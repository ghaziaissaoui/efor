
<div class="header-component-base-lang {{ $block_class ?? '' }}">
  @if(!empty($data['languages']))
    @foreach($data['languages'] as $lang)
      <a href="{!! $lang['url'] ?? '' !!}" class="u-inline-block u-margin-r-2 @if($lang['current_lang']) active @endif">{!! $lang['slug'] !!}</a>
    @endforeach
  @endif
</div>
