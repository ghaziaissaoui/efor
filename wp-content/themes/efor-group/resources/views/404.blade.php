@php $iconLibUrl = \App\asset_path('images/icon-lib.svg') @endphp

@extends('layouts.app')

@section('content')
  <div class="gs-fluid-container">
    <div class="gs-row u-margin-t-10">
      <div class="u-flex u-flex-column u-width-100%">
        <h1 class="t-h1">{!! pll__('Page introuvable') !!}</h1>
        <a class="button u-margin-t-8 t-align-center u-centered-on-x" href="{!! home_url() !!}" style="background: var(--c-black-graphite); color: var(--c-gold);">
          <span>{!! pll__('Retourner à l\'accueil') !!}</span>
          <svg class="u-block u-icon u-icon-24 u-icon--right c-white">
            <use xlink:href="{{ $iconLibUrl }}#icon-arrow-right"/>
          </svg>
        </a>
      </div>
    </div>
  </div>
@endsection
