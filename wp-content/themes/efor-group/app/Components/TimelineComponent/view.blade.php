<section class="gs-fluid-container">
    <timeline-component class="timeline-component">
        @if (!empty($data['title']['title_1']) || !empty($data['title']['title_2']))
        <section class="timeline-header">
            <h2 class=" timeline-header__title t-h1 @lg:t-align-center c-black-graphite">
                @if (!empty($data['title']['title_1']))
                {{ $data['title']['title_1'] }}
                @endif

                @if (!empty($data['title']['title_2']))
                <span class="t-sometimes-times @lg:u-block">{{ $data['title']['title_2'] }}</span>
                @endif
            </h2>
        </section>
        @endif

        @if (!empty($data['contents']))
        <section class="timeline-contents">

            @foreach ($data['contents'] as $content)
            <div class="timeline-content u-flex u-flex-column @lg:u-flex-row u-align-items-center u-justify-content-space-between">
                <div class="@lg:gs-column-6 t-sometimes-times t-h1 u-margin-b-3 @lg:u-margin-b-0">
                    @if (!empty($content['year']))
                    <p class="timeline-content__year">{{ $content['year'] }}</p>
                    @endif
                </div>

                <div class="@lg:gs-column-5">
                    @if (!empty($content['content_title']))
                    <h3 class="t-h5 u-margin-b-3 @lg:u-margin-b-4">{{ $content['content_title'] }}</h3>
                    @endif

                    @if (!empty($content['content_description']))
                    <div class="timeline-content__description">
                        {!! $content['content_description'] !!}
                    </div>
                    @endif
                </div>
            </div>
            @endforeach

            <div class="timeline-progressbar">
                <div class="timeline-progressbar-container">
                    <span class="timeline-progressbar__fill"></span>
                </div>
            </div>
        </section>
        @endif
    </timeline-component>
</section>

