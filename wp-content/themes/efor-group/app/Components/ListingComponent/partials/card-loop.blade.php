@if(!empty($data['posts']))
  @foreach($data['posts'] as $card)

    <div class="card @if('redirect' !== $card['post_type']) image--scale @endif @md:gs-column-4 u-margin-b-3 @md:u-margin-b-5">
      @switch($card['post_type'])
        @case('talent')
          @include('partials.cards.talent-card', ['isH2' => true])
          @break
        @case('page')
          @include('partials.cards.page-card', ['isH2' => 'h2'])
          @break
        @case('redirect')
          @include('partials.cards.redirect-card', ['isH2' => 'h2'])
          @break
        @default
          @include('partials.cards.post-card', ['isH2' => 'h2'])
          @break
      @endswitch
    </div>
  @endforeach
@else
  <p class="u-centered-on-x t-weight-500 u-margin-t-5">{!! pll__('Aucun résultat associé à votre recherche') !!}</p>
@endif
