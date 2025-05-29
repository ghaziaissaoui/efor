{{-- dump($data): All data's available for this view --}}
<section class="bg-black-graphite u-padding-t-6 @lg:u-padding-t-13 u-padding-b-6 @lg:u-padding-b-13 scroll-mobile-graphique">
  <div class="gs-fluid-container">
    <div class="gs-row">
      <graphique-component
        class="graphique-component u-block u-width-100%"
        data-years='{!! $data['years'] ?? '' !!}'
        data-column="{!!$data['column'] ?? '' !!}"
        data-curve="{!!$data['curve'] ?? '' !!}"
        data-curve_colors='{!!$data['future'] ?? '' !!}'
        data-tooltip_label="{!! $data['tooltip'] !!}"
        data-y_right_axis_label="{!! $data['legend_column'] ?? '' !!}"
        data-y_left_axis_label="{!! $data['legend_curve'] ?? pll__('Nombre de collaborateurs') !!}"
      >
        <h2 class="hero-component__title t-h1 c-white u-margin-b-6 @lg:u-margin-b-13 t-align-center u-centered-on-x">
          {!! $data['title']['title_1'] ?? '' !!}
          <span class="t-sometimes-times u-block">{!! $data['title']['title_2'] ?? '' !!}</span>
        </h2>
        <div class="u-width-100%">
          <canvas id="myChart" class="u-width-100%"></canvas>
        </div>
        <script defer src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      </graphique-component>
    </div>
  </div>
</section>

