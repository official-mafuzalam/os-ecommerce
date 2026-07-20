<!-- Google Tag Manager -->
@if (setting('google_tag_manager_id'))
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', '{{ setting('google_tag_manager_id') }}');
    </script>
@endif

<!-- Facebook Pixel -->
@if (setting('fb_pixel_id'))
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ setting('fb_pixel_id') }}');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id={{ setting('fb_pixel_id') }}&ev=PageView&noscript=1" />
    </noscript>
@endif

<!-- Structured Data -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "{{ setting('site_theme', 'fashion') === 'natural' ? 'HealthAndBeautyStore' : 'FashionStore' }}",
    "name": "{{ setting('site_name', 'OS Ecommerce') }}",
    "image": "{{ setting('og_image', asset('assets/logo/logo.png')) }}",
    "@id": "{{ url('/') }}",
    "url": "{{ url('/') }}",
    "telephone": "{{ setting('site_phone', '') }}",
    "priceRange": "৳৳ - ৳৳৳৳",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "{{ setting('site_address', '') }}",
        "addressLocality": "{{ setting('site_city', 'Dhaka') }}",
        "addressRegion": "{{ setting('site_state', '') }}",
        "postalCode": "{{ setting('site_postal_code', '') }}",
        "addressCountry": "{{ setting('site_country', 'BD') }}"
    },
    "description": "{{ setting('meta_description', setting('site_theme', 'fashion') === 'natural' ? 'Natural health, wellness and nutrition products for conscious living.' : 'Premium E-commerce Destination') }}",
    "openingHours": "Mo-Sa 10:00-20:00",
    "sameAs": [
        @if(setting('facebook_url'))"{{ setting('facebook_url') }}",@endif
        @if(setting('instagram_url'))"{{ setting('instagram_url') }}",@endif
        @if(setting('twitter_url'))"{{ setting('twitter_url') }}"@endif
    ]
}
</script>
@include('layouts.public.tracking-scripts')
