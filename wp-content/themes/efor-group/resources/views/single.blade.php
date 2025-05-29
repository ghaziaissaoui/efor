@extends('layouts.app')
@section('content')
  {!! $header !!}
  <div class="gs-fluid-container content-single rich-text">
    <div class="gs-row u-margin-b-12 @lg:u-margin-b-16">
      <div class="@md:gs-column-8 @md:gs-push-2 @md:gs-pull-2">
      {!! $content !!}
      </div>
    </div>
  </div>
  {!! $card_link ?? '' !!}
  {!! $actus ?? '' !!}
@endsection
