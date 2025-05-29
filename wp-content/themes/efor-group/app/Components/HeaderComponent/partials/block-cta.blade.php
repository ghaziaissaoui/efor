<a href="{{ $data['cta_link'] }}" class="button {{ $block_class ?? '' }}" style="background: var(--c-black-graphite); color: var(--c-gold);">
    <span>{{ $data['cta_title'] }}</span>
    <svg class="u-block u-icon u-icon-24 u-icon--right c-white">
        <use xlink:href="{{ $iconLibUrl }}#icon-arrow-right"/>
    </svg>
</a>
