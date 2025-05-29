{!! $data['header'] !!}
<div class="gs-fluid-container content-talent rich-text">
  <div class="gs-row">
    <div class="@md:gs-column-10 @md:gs-push-1 @md:gs-pull-1">
      <p class="content-talent__name t-h2">
        <span>{!! $data['title']['title_1'] !!}</span>
        <span class="t-sometimes-times">{!! $data['title']['title_2'] !!}</span>
      </p>
      @if(!empty($data['job']))
        <p class="content-talent__job c-gold-secondary t-header-medium">{!! $data['job'] !!}</p>
      @endif
      {!! $data['content'] !!}
    </div>
  </div>
</div>
