<section class="@lg:u-padding-t-12 u-padding-t-8 u-padding-b-6 @lg:u-padding-b-12 u-block bg-black-graphite @if('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
    <expert-component class="expert-component">
        <div class="gs-fluid-container">
            <div class="gs-row">
                @if (!empty($data['experts_title_default']))
                    <h2 class="expert-component__title t-h2 t-align-center @lg:gs-column-8 u-centered-on-x">{{ $data['experts_title_default'] }} <span class="t-sometimes-times u-block">{{ $data['experts_title_secondary'] ?? '' }}</span></h2>
                @endif
                <section class="expert-component-block-container @md:gs-column-10 @md:gs-push-1 @md:gs-pull-1">
                    <div class="expert-component-block-content">
                        @foreach ($data['experts'] as $expert)
                            <article class="expert-component-block u-width-100% @if($loop->index == 0) expert-component-block--big @md:u-flex @else expert-component-block--small @md:gs-flush-column-5 u-flex-column @endif">
                                @if (!empty($expert['image']))
                                    <div class="expert-component-block__image-container ratio-block @if($loop->index == 0) @md:gs-flush-column-5 ratio-block--97/63 @md:ratio-block--1/1 @else ratio-block--5/3 @endif">
                                        {!! $expert['image'] !!}
                                    </div>
                                @endif
                                <div class="@if($loop->index == 0) @md:gs-flush-column-5 @endif @md:u-flex u-flex-column u-justify-content-center">
                                    @if (!empty($expert['title']))
                                        <h3 class="expert-component-block__title t-h3">{{ $expert['title'] }}</h3>
                                    @endif

                                    @if (!empty($expert['subtitle']))
                                        <p class="expert-component-block__subtitle t-h5 c-gold-secondary">{{ $expert['subtitle'] }}</p>
                                    @endif

                                    @if (!empty($expert['description']))
                                        <p class="expert-component-block__description">{{ $expert['description'] }}</p>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </expert-component>
</section>

