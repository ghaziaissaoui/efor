@php $iconLibUrl = \App\asset_path('images/icon-lib.svg') @endphp

{{-- dump($data): All data's available for this view --}}
<section class="bg-white u-relative @if('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
   <card-actu-component class="card-actu-component gs-fluid-container u-block">
       <div class="gs-row">
           <div class="card-actu-header u-flex @md:u-flex-row u-align-items-center u-width-100%">
               <div class="u-flex-column @md:gs-column-5">
                   <h2 class="card-actu-header__title t-h3">{!! $data['title'] ?? '' !!}</h2>
                   <p class="card-actu-header__subtitle t-base-medium">{!! $data['content'] ?? '' !!}</p>
               </div>

               <div class="card-actu-header__btn @md:gs-column-fill-space @md:t-align-right">
                   <a href="{!! $data['link'] ?? '#' !!}" class="button" style="background: var(--c-black-graphite); color: var(--c-gold);">
                       <span>{!! $data['link_text'] ?? '' !!}</span>
                       <svg class="u-icon u-icon-24 u-icon--right c-white">
                           <use xlink:href="{{ $iconLibUrl }}#icon-arrow-right"/>
                       </svg>
                   </a>
               </div>
           </div>


           <div class="card-actu-list swiper card-actu-list__slider u-width-100%">
               <ul class="swiper-wrapper">
                   @if(!empty($data['listing']))
                       @foreach($data['listing'] as $card)
                           <li class="swiper-slide card @md:gs-column-4">
                             @include('partials.cards.post-card')
                           </li>
                       @endforeach
                   @endif
               </ul>
           </div>
       </div>
   </card-actu-component>
</section>

