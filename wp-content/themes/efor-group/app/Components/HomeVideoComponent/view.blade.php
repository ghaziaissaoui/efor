{{-- dump($data): All data's available for this view --}}
<home-video-component data-src="{!! $data['video_src'] !!}"
                      class="home-video-component ratio-block ratio-block--16/9 u-relative">
  <video playsinline muted loop autoplay class="ratio-block__content"></video>
  <div class="u-absolute gs-fluid-container text">
    <h1 class="t-h1 c-white">
      {!! $data['titles']['title_1'] ?? '' !!}
      <span class="t-sometimes-times">
        {!! $data['titles']['title_2'] ?? '' !!}
      </span>
    </h1>
  </div>
</home-video-component>
