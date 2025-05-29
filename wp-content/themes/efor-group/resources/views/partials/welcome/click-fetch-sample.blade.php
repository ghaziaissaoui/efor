<div class="gs-container u-margin-b-10">
  <h2 class="t-header-large">ClickFetch</h2>
  <p class="u-margin-b-10 t-base-medium c-gray-60">See <code>front/abstract/click-fetch</code> and <code>resources/views/partials/ajax-button.blade.php</code></p>

  <div class="u-flex u-padding-3 u-border-1 u-margin-b-3 c-gray-30 @lg:u-padding-5 @lg:u-margin-b-5">
    <h3 class="t-header-medium u-margin-b-3 c-black @lg:u-margin-b-0">Ajax request </h3>
    <div class="u-flex u-h-spaced-3 u-margin-b-3 c-black @lg:u-margin-b-0 @lg:u-margin-l-5 @lg:u-margin-r-5">
      @include('partials.ajax-button', [
          'action' => 'demo-request',
          'label' => 'Demo ajax request w/ partial',
          'loadingLabel' => 'custom waiting message',
          'wrapperClass' => 'u-padding-2 bg-yellow',
          'params' => ['message' => 'Request executed']
      ])
    </div>
    <div class="dummy__output bodycopy t-base-medium c-black">
      <p>PHP logic available in <code>app\Ajax\DemoRequest.php</code></p>
      <p class="u-padding-1 u-padding-l-2 ajax-output bg-black c-white">Output</p>
    </div>
  </div>

  <div class="u-flex u-padding-3 u-border-1 u-margin-b-3 c-gray-30 @lg:u-padding-5 @lg:u-margin-b-5">
    <h3 class="t-header-medium u-margin-b-3 c-black @lg:u-margin-b-0">Ajax request </h3>
    <div class="u-flex u-h-spaced-3 u-margin-b-3 c-black @lg:u-margin-b-0 @lg:u-margin-l-5 @lg:u-margin-r-5">
      @include('partials.ajax-button', [
          'action' => 'demo-request-error',
          'label' => 'Demo ajax request w/ error',
          'buttonClass' => 'button hover:bg-yellow hover:c-black'
      ])
    </div>
    <div class="dummy__output bodycopy t-base-medium c-black">
      <p>PHP logic available in <code>app\Ajax\DemoRequest.php</code></p>
      <p class="u-padding-1 u-padding-l-2 ajax-output bg-black c-white">Output</p>
    </div>
  </div>
</div>
