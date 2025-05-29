{{-- dump($data): All data's available for this view --}}

<section class="gs-full-container u-block @if('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
  <expand-video-component class="expand-video-component youtube-autoplay u-block" @if(!empty($data['youtube'])) data-youtube-full-video-id="{!! $data['youtube'] !!}" @endif>
    <div @if(!empty($data['youtube'])) data-video="youtube.com" @endif>
      <div class="expand-video u-centered-on-x">
        <div class="ratio-block ratio-block--9/16 @md:ratio-block--16/9">
          @if(!empty($data['youtube']))
            <div class="youtube-full-video__insertion-point ratio-block__content"></div>
          @else
            <video muted loop autoplay playsinline="" src="{!! $data['video'] !!}" class="ratio-block__content"></video>
          @endif
        </div>
      </div>
    </div>
  </expand-video-component>
</section>

