@if(!empty($flexibleContent))
  {!! $flexibleContent !!}
@else
  {!! the_content() !!}
@endif
