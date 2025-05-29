@php
$label = $label ?? 'Label';
$loadingLabel = $loadingLabel ?? '';
$buttonClass = $buttonClass ?? 'button';
$wrapperClass = $wrapperClass ?? '';
$params = $params ?? [];
@endphp

<click-fetch
class="{!! $wrapperClass !!}"
data-action="{!! $action !!}"
data-loading-label="{!! $loadingLabel !!}"
data-params="{!! htmlspecialchars(json_encode($params, JSON_THROW_ON_ERROR), ENT_QUOTES, 'UTF-8') !!}">
  <button type="button" class="{!! $buttonClass !!}">
    <span>{!! $label !!}</span>
  </button>
</click-fetch>
