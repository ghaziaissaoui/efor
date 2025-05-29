{{-- dump($data): All data's available for this view --}}
<section class="bg-{!! $data['background'] !!} @lg:u-padding-t-12 u-padding-t-8 u-padding-b-6 @lg:u-padding-b-12 @if('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
  <join-component class="join-component join">
    <div class="gs-fluid-container">
      <div class="gs-flush-row">
        <div class="u-width-100%">
          <h2 class="join__title t-h2 @md:gs-flush-column-8 c-{!! $data['global_text_color'] !!}">
            {!! $data['title']['title_1'] !!}
            <span class="t-sometimes-times u-block">{!! $data['title']['title_2'] !!}</span>
          </h2>
        </div>
      </div>
    </div>

    <div class="gs-full-container join__slider">
      <div class="join-scroll">
        <div class="join-scroll__container u-flex u-flex-nowrap">
          @if(!empty($data['slides']))
            @foreach($data['slides'] as $slide)
              @php
                switch ($slide['layout']) {
                    case 'layout_1':
                    case 'layout_4' :
                        $slideClass = 'first-composition';
                        break;
                    case 'layout_2':
                        $slideClass = 'second-composition';
                      break;
                    case 'layout_3':
                        $slideClass = 'third-composition';
                      break;
                    default:
                        $slideClass = '';
                        break;
                }
              @endphp

              @switch($slide['layout'])
                @case('layout_1')
                @case('layout_4')
                  <div class="join-slide {!! $slideClass !!} u-flex">
                    <div class="join-slide-left @if('layout_1' === $slide['layout']) @md:gs-column-5 @wd:gs-column-4 @else @md:gs-column-8 u-centered-on-x @endif">
                      <div class="header u-flex u-align-items-center">
                        <p class="header__number t-sometimes-times c-gold-secondary">{!! $loop->index + 1 !!}</p>
                        <p class="header__value t-h3 c-{!! $data['global_text_color'] !!}">{!! $slide['title'] !!}</p>
                      </div>
                      <div class="join-slide-left__text t-base-medium c-white">
                        {!! $slide['content'] !!}
                      </div>
                    </div>
                    @if(!empty($slide['media_1']) || !empty($slide['media_2']))
                      <div class="join-slide-right gs-flush-column-6 @md:gs-column-6 @md:gs-push-1 @wd:gs-push-1 @wd:gs-column-7 u-flex">
                        @if(!empty($slide['media_1']))
                          <div class="img__left u-hidden @lg:u-block @md:gs-flush-column-4 u-margin-r-7">
                            <div class="ratio-block @lg:ratio-block--155/132">
                              {!! $slide['media_1'] !!}
                            </div>
                          </div>
                        @endif
                        @if(!empty($slide['media_2']))
                          <div class="img__right @lg:u-block @if(true === $slide['isVideo']) gs-flush-column-11 @md:gs-flush-column-5 @else @md:gs-flush-column-10 @lg:gs-flush-column-6 @endif">
                            @if(false === $slide['isVideo'])
                              <div class="ratio-block ratio-block--418/315 @lg:ratio-block--35/24">
                            @endif
                            {!! $slide['media_2'] !!}
                            @if(false === $slide['isVideo'])
                              </div>
                            @endif
                          </div>
                        @endif
                      </div>
                    @endif
                  </div>
                  @break
                @case('layout_2')
                  <div class="join-slide second-composition u-flex @md:u-flex-column">
                    <div class="join-slide-left gs-column @lg:gs-column @md:u-flex u-align-items-center">
                      <div class="header u-flex u-align-items-center @md:gs-column-5">
                        <p class="header__number t-sometimes-times c-gold-secondary">{!! $loop->index + 1 !!}</p>
                        <p class="header__value t-h3 c-{!! $data['global_text_color'] !!}">{!! $slide['title'] !!}</p>
                      </div>
                      <div class="join-slide-left__text t-base-medium c-{!! $data['global_text_color'] !!} @md:gs-pull-1 @md:gs-column-6">
                        {!! $slide['content'] !!}
                      </div>
                    </div>
                    <div class="join-slide-right @lg:gs-column u-flex-column @md:u-flex-row">
                      <div class="img__left @md:gs-column-7">
                        <div class="ratio-block ratio-block--163/315 @lg:ratio-block--20/53">
                          {!! $slide['media_1'] !!}
                        </div>
                      </div>
                      <div class="img__right @md:gs-column-4">
                        <div class="ratio-block ratio-block--11/15 @lg:ratio-block--12/13">
                          {!! $slide['media_2'] !!}
                        </div>
                      </div>
                    </div>
                  </div>
                  @break
                @case('layout_3')
                  <div class="join-slide third-composition u-flex">
                    <div class="join-slide-left @md:gs-column-5 @lg:gs-column-5">
                      <div class="header u-flex u-align-items-center">
                        <p class="header__number t-sometimes-times c-gold-secondary">{!! $loop->index + 1 !!}</p>
                        <p class="header__value t-h3 c-{!! $data['global_text_color'] !!}">{!! $slide['title'] !!}</p>
                      </div>
                      <div class="join-slide-left__text t-base-medium c-{!! $data['global_text_color'] !!}">
                        {!! $slide['content'] !!}
                      </div>
                    </div>
                    <div class="join-slide-right @if(true === $slide['isVideo']) @md:gs-column-6 @lg:gs-column-6 u-align-self-center @else @md:gs-column-6 @endif">
                      @if(false === $slide['isVideo'])
                        <div class="ratio-block ratio-block--418/315 @lg:ratio-block--35/38">
                      @endif
                      {!! $slide['media_1'] !!}
                      @if(false === $slide['isVideo'])
                        </div>
                      @endif
                    </div>
                  </div>
                  @break
              @endswitch
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </join-component>
</section>

