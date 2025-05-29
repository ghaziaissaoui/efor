{{-- dump($data): All data's available for this view --}}

<hero-talent-component class="hero-talent-component u-block">
    <div class="hero-talent">
      <div class="ratio-block ratio-block--4/3 @lg:ratio-block--25/48">
        @if(!empty($data['img']))
          {!! $data['img'] !!}
        @endif
      </div>
      @if(!empty($data['tags']))
        <div class="tags u-flex u-width-100 u-justify-content-space-between">
          @foreach($data['tags'] as $tag)
            <div class="tag bg-white">{!! $tag !!}</div>
          @endforeach
        </div>
      @endif
    </div>
  </hero-talent-component>


