{{-- dump($data): All data's available for this view --}}
<div class="gs-fluid-container u-relative">
  <div class="cta-component bg-black-graphite gs-row u-flex-column">
    <h3 class="c-white t-h3">
      {!! $data['titles']['title_1'] ?? '' !!}
      <span class="u-block t-sometimes-times">
        {!! $data['titles']['title_2'] ?? '' !!}
      </span>
    </h3>
    <a href="{!! $data['button']['url'] ?? '' !!}" target="_blank"
      class="button u-margin-t-3 button--white-for-dark-bg"
      style=" background: var(--c-white); color: var(--c-black-graphite); ">
      <span>
        {!! $data['button']['title'] ?? '' !!}
      </span>
      <svg class="u-icon u-icon-24 u-icon--right">
        <use
          xlink:href="http://eforgroup.local/wp-content/themes/efor-group/front/public/images/icon-lib.svg#icon-arrow-right"></use>
      </svg>
    </a>
      {!! $data['image'] !!}
  </div>
</div>
