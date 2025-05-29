{{--
  Template Name: Template Contenu
--}}

@extends('layouts.app')
@section('content')
  <div class="gs-fluid-container">
    <div class="gs-row">
      <div class="@md:gs-column-8 u-centered-on-x rich-text">
        {!! $content !!}
      </div>
    </div>
  </div>
@endsection
