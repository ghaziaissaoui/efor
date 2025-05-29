<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body @php body_class() @endphp>
    @php do_action('get_header') @endphp
    @if($app['background']['enabled'])
      @if(1 === $app['background']['composition'])
        <div class="background-lines"></div>
      @else
        <div class="background-lines-2"></div>
      @endif
    @endif
    {!! $app['sidebar'] !!}
    {!! $app['header'] !!}
    <div class="wrap" role="document">
        <main class="main" role="main">@yield('content')</main>
        @if (App\display_sidebar())
          <aside class="sidebar">
            @include('partials.sidebar')
          </aside>
        @endif
    </div>
    <div class="transition transition-rtl c-{!! $app['transitionColor'] !!}"></div>
    @php do_action('get_footer') @endphp
    {!! $app['footer'] !!}
    @php wp_footer() @endphp
  </body>
</html>
