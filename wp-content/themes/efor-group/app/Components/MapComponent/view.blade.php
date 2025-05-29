{{-- dump($data): All data's available for this view --}}
<map-component
  class="map-component"
  data-coordinates="@json($data['implantations'])"
  data-api_key="{!! $data['maptiler_key'] !!}"
  data-map_id="{!! $data['maptiler_map_id'] !!}"
>
  <div class="ratio-block map-sticky ratio-block--450/331 @lg:ratio-block--150/143">
    <div id="map" class="ratio-block__content"></div>
  </div>

  <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
          integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
          crossorigin="">
  </script>

  <link href="https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.css" rel='stylesheet' />
  <script src="https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.js"></script>
  <script src="https://unpkg.com/@maplibre/maplibre-gl-leaflet@0.0.17/leaflet-maplibre-gl.js"></script>
</map-component>
