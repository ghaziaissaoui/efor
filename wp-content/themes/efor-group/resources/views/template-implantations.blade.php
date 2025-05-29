{{--
  Template Name: Template Implantations
--}}
@php $iconLibUrl = \App\asset_path('images/icon-lib.svg') @endphp

@extends('layouts.app')
@section('content')
  <section class="gs-fluid-container">
    <div class="gs-row">
      <div class="map @md:u-flex u-width-100%">
        <div class="map-left @md:gs-column-5">
          <div class="u-hidden @md:u-block">
            <h1 class="map-left__title t-h2 t-align-center @md:t-align-left">
              {!! $title['title_1'] ?? '' !!}
              <div class="t-sometimes-times">{!! $title['title_2'] ?? '' !!}</div>
            </h1>

            <div class="t-base-medium t-align-center @md:t-align-left">{!! $content ?? '' !!}</div>
          </div>
          <span class="filter_span u-block t-label-medium c-black">Filtre :</span>
          <ul class="continent_list u-flex u-align-items-center u-margin-b-2">

            @foreach($implantations as $key => $continent)
              <li class="tab-btn u-margin-r-1 {!! $loop->index === 0 ? 'active' : '' !!}" data-tab="{!! $key !!}" data-coords='{!! $continent['coords'] !!}'>
                {!! $continent['name'] !!}
              </li>
            @endforeach
          </ul>

          @if(!empty($implantations))
            @foreach($implantations as $name => $continent)
              <div class="tab-content @md:gs-flush-column-11 {!! $loop->index === 0 ? 'active' : '' !!}"
                   id="{!! $name !!}">
                <div class="content-accordion">
                  <div class="accordion">
                    @foreach($continent as $key => $country)
                      @if(is_array($country))
                        <div class="u-flex-column u-align-items-center u-justify-content-space-between">
                          <div class="accordion-toggle u-flex u-width-100% u-align-item-center u-justify-content-space-between">
                            <h2 class="t-header-small">{!! $key !!}</h2>
                            <svg class="u-icon u-icon-24 u-icon--no-fill c-black-graphite">
                              <use xlink:href="{{ $iconLibUrl }}#icon-chevron-down"/>
                            </svg>
                          </div>
                          <div class="accordion-content item">

                            @if(is_array($country))
                              @if(isset(array_values($country)[0][0]['id']))
                              {{-- Country has regions --}}
                              <div class="accordion nested">
                                @foreach($country as $regionName => $region)
                                  <div class="accordion-toggle u-flex u-align-items-center u-justify-content-space-between">
                                    <h2 class="t-base-medium">{!! $regionName !!}</h2>
                                    <svg class="u-icon u-icon-24 u-icon--no-fill c-black-graphite">
                                      <use xlink:href="{{ $iconLibUrl }}#icon-chevron-down"/>
                                    </svg>
                                  </div>
                                <div class="accordion-content swiper map-slider-accordion">
                                  <div class="swiper-wrapper">
                                    @foreach($region as $implantation)
                                      @include('partials.cards.implantation', ['implantation' => $implantation])
                                    @endforeach
                                  </div>

                                </div>
                                @endforeach
                              </div>
                            @else
                                {{-- Implantations directly under the country --}}
                                @foreach($country as $implantation)
                                  @include('partials.cards.implantation', ['implantation' => $implantation])
                                @endforeach
                               @endif
                            @endif
                          </div>
                        </div>
                      @endif
                    @endforeach
                  </div>
                </div>
              </div>
            @endforeach
          @endif

        </div>

        <div class="@md:u-hidden u-block">
          <h1 class="map-left__title t-h2 t-align-center @md:t-align-left">
            {!! $title['title_1'] ?? '' !!}
            <div class="t-sometimes-times">{!! $title['title_2'] ?? '' !!}</div>
          </h1>

          <div class="t-base-medium t-align-center @md:t-align-left">{!! $content ?? '' !!}</div>
        </div>

        <div class="map-right @md:gs-column-7">
          {!! $map ?? '' !!}
        </div>

      </div>
    </div>
  </section>
  {!! $the_content !!}

@endsection
