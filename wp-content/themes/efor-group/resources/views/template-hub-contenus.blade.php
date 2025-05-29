{{--
  Template Name: Hub Contenu
--}}

@extends('layouts.app')
@section('content')
  <div class="gs-fluid-container search-page u-padding-t-6 u-padding-b-6 @lg:u-padding-t-16 @lg:u-padding-b-16">
    <div class="gs-row u-flex u-justify-content-center u-margin-b-6 @lg:u-margin-b-11">
      @if(!empty($title['title_1']) || !empty($title['title_2']))
        <h1 class="t-h1 c-black-graphite @md:u-block u-align-self-end t-align-center">
          {!! $title['title_1'] ?? '' !!}
          <span class="t-sometimes-times u-block">{!! $title['title_2'] ?? '' !!}</span>
        </h1>
      @endif
    </div>
    <div class="gs-row">
      {!! $filters !!}
    </div>
    <div class="gs-row">
      {!! $listing !!}
    </div>
  </div>
@endsection
