<script>
    window.dataLayer = window.dataLayer || [];
    @if (session()->has('analytics_events'))
        @foreach (session()->get('analytics_events') as $event)

            console.log('Analytics Events:', @json(session()->get('analytics_events')));
            // GTM Push
            window.dataLayer.push({
                'ecommerce': null
            });
            window.dataLayer.push({
                'event': '{{ $event['gtm_name'] }}',
                'event_id': '{{ $event['event_id'] }}',
                'ecommerce': {
                    'currency': '{{ $event['params']['currency'] ?? 'BDT' }}',
                    'value': {{ $event['params']['value'] ?? 0 }},
                    'items': @json($event['params']['items'] ?? [])
                }
            });

            // FB Pixel Push
            fbq('track', '{{ $event['fb_name'] }}', {
                value: {{ $event['params']['value'] ?? 0 }},
                currency: '{{ $event['params']['currency'] ?? 'BDT' }}',
                content_ids: @json($event['params']['content_ids'] ?? []),
                content_type: 'product',
                num_items: {{ $event['params']['num_items'] ?? 0 }}
            }, {
                eventID: '{{ $event['event_id'] }}'
            });
        @endforeach
        @php session()->forget('analytics_events'); @endphp
    @endif
</script>
