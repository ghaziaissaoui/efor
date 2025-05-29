@extends('layouts.app')
@section('content')
    {!! $data['header'] !!}
    <div class="gs-fluid-container content-talent">
        <div class="gs-row">
            <div class="@md:gs-column-8 @md:gs-push-2 @md:gs-pull-2">
                @if(!empty($data['title']['title_1']) || !empty($data['title']['title_2']))
                <h1 class="content-talent__name">
                    @if(!empty($data['title']['title_1'])) {!! $data['title']['title_1'] !!} @endif
                    @if(!empty($data['title']['title_2'])) <span class="t-sometimes-times">{!! $data['title']['title_2'] !!}</span> @endif
                </h1>
                @endif
                @if(!empty($data['job']))
                    <p class="content-talent__job c-gold-secondary t-header-medium">{!! $data['job'] !!}</p>
                @endif
                @if(!empty($data['content']))
                <div class="rich-text">
                    {!! $data['content'] !!}
                </div>
                @endif
            </div>
        </div>

        @if(!empty($data['contact_title']['title_1']) || !empty($data['contact_title']['title_2']))
        <h2 class="contact-header__title t-h2 t-align-center u-margin-t-12">
            @if(!empty($data['contact_title']['title_1'])) {{ $data['contact_title']['title_1'] }} @endif
            @if(!empty($data['contact_title']['title_2'])) <span class="t-sometimes-times u-block">{{ $data['contact_title']['title_2'] }}</span> @endif
        </h2>
        @endif
        @if(!empty($data['contact']))
        {!! $data['contact'] !!}
        @endif
    </div>
@endsection
