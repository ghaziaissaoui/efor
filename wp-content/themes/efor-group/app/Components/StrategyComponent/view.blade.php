<section class="gs-fluid-container u-block @if ('without' === ($data['bottom_margin'] ?? '')) u-margin-b-0 @endif">
    <div class="gs-row">
        <strategy-component class="strategy-component u-width-100%">
            @if (!empty($data['title_component']))
                <h3 class="strategy-component__title t-h3 t-align-center @md:gs-column-8 @md:gs-push-2 @md:gs-pull-2">
                    {!! $data['title_component'] !!}
                </h3>
            @endif
            <div class="strategy-component__container @md:u-flex @md:u-flex-wrapping">
                @if (!empty($data['items']))
                    @foreach ($data['items'] as $item)
                        @if ($loop->last && $loop->count % 2)
                            <a class="anchor item u-relative @md:gs-column u-block" href="#{!! $item['anchorId'] !!}">
                                <div
                                    class="ratio-block ratio-block--127/335 @md:ratio-block--1/7 image--scale @if (!empty($item['title_anchor'])) --bg-filter @endif">
                                    {!! $item['image_anchor_large'] ?? '' !!}
                                </div>
                                <p class="t-h4 c-white">{!! $item['title_anchor'] ?? '' !!}</p>
                            </a>
                        @else
                            <a class="anchor item u-relative @md:gs-column-6 u-block" href="#{!! $item['anchorId'] !!}">
                                <div
                                    class="ratio-block ratio-block--127/335 @md:ratio-block--18/61 image--scale @if (!empty($item['title_anchor'])) --bg-filter @endif">
                                    {!! $item['image_anchor_small'] ?? '' !!}
                                </div>
                                <p class="t-h4 c-white">{!! $item['title_anchor'] ?? '' !!}</p>
                            </a>
                        @endif
                    @endforeach
                @endif
            </div>
        </strategy-component>
    </div>
</section>
@if (!empty($data['items']))
    @foreach ($data['items'] as $item)
        {!! $item['image'] ?? '' !!}
        {!! $item['section'] !!}
    @endforeach
@endif
