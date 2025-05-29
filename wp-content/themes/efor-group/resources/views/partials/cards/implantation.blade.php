<div class="implantation u-v-tail-spaced-3 bg-gray-20 swiper-slide" data-id="{!! $implantation['id'] !!}">
  <div class="implantation__container u-v-tail-spaced-3">
    <div>
      <h3 class="t-header-medium c-gold-secondary implantation-title">{!! $implantation['title'] ?? '' !!}</h3>
      <p class="implantation__subtitle">{!! $implantation['subtitle'] ?? '' !!}</p>
    </div>

    <div>
      <p class="t-base-medium">{!! $implantation['phone'] ?? '' !!}</p>
      <p class="t-base-medium c-gold-secondary implantations__email">{!! $implantation['mail'] ?? '' !!}</p>
    </div>

    <p class="t-base-medium">{!! $implantation['address']['address'] ?? '' !!}</p>
  </div>
</div>
