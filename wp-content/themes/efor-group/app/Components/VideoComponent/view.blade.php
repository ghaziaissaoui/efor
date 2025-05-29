@php $iconLibUrl = \App\asset_path('images/icon-lib.svg'); @endphp

{{-- dump($data): All data's available for this view --}}
<video-component class="video-component">
  @if($data['isYoutube'])
    <div data-video="youtube.com">
      <div class="{!! $data['classes'] ?? '' !!} video-item" data-youtube-preview-video-id="{{ $data['youtube_id'] }}">
        <div class="ratio-block {!! $data['ratios'] !!} youtube-preview-loop youtube-full-video"
             data-youtube-full-video-id="{{ $data['youtube_id'] }}">
          <div class="youtube-preview-loop__insertion-point"></div>
          @if(!empty($data['preview']))
            <div class="cover-image youtube-preview-loop__cover-image">
              {!! $data['preview'] !!}
            </div>
            <svg class="icon u-icon u-icon-72 u-absolute">
              <use xlink:href="{{ $iconLibUrl }}#icon-play"/>
            </svg>
          @endif
          <div class="loader"></div>
          <div class="youtube-full-video__insertion-point"></div>
        </div>
      </div>
    </div>
  @else
    <div class="{!! $data['classes'] ?? '' !!} video-item">
      <div class="ratio-block {!! $data['ratios'] !!} video-preview">
        @if(!empty($data['preview']))
          <div class="cover-image video-preview__cover-image">
            {!! $data['preview'] !!}
          </div>
        @endif
        <svg class="icon u-icon u-icon-72 u-absolute">
            <use xlink:href="{{ $iconLibUrl }}#icon-play"/>
        </svg>
          <div class="video-preview__cover-image u-block" style="background-image:url('{!! $data['bg_preview'] ?? '' !!}');"></div>
          <video src="{!! $data['video_url'] !!}" class="ratio-block__content" controls @if($data['autoplay']) autoplay @endif></video>
          <div class="loader"></div>
      </div>
    </div>
  @endif
</video-component>
