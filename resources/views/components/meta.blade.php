<!-- =====================
     SEO & Meta Tags
    ===================== -->
@php
    $metaTitle = isset($product) && $product->meta_title
        ? $product->meta_title
        : (isset($product)
            ? $product->name
            : ($title ?? setting('site_name', config('app.name'))));

    $metaDescription = isset($product) && $product->meta_description
        ? $product->meta_description
        : (isset($product)
            ? ($product->short_description ?? \Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 160))
            : (setting('meta_description') ?: 'Best E-commerce website'));

    $metaKeywords = isset($product) && $product->meta_keywords
        ? $product->meta_keywords
        : (setting('meta_keywords') ?: 'ecommerce, shop, online store');

    $metaAuthor = setting('meta_author') ?: setting('site_name') ?: config('app.name');

    // Determine OG Image — must be an absolute URL for crawlers
    if (isset($product) && $product->images->count() > 0) {
        $primaryImage = $product->images->where('is_primary', true)->first()
            ?? $product->images->first();
        $ogImage = url(Storage::url($primaryImage->image_path));
    } else {
        $settingImage = setting('og_image');
        $ogImage = $settingImage ? url($settingImage) : asset('default-og.png');
    }

    $ogUrl    = setting('og_url') ?: url()->current();
    $ogType   = isset($product) ? 'product' : 'website';
    $fbAppId  = setting('fb_app_id') ?? '';
    $language = setting('meta_language') ?: 'en';
@endphp
<meta name="description" content="{{ $metaDescription }}">
<meta name="keywords" content="{{ $metaKeywords }}">
<meta name="author" content="{{ $metaAuthor }}">
<meta name="language" content="{{ $language }}">

<!-- =====================
     Open Graph Tags
    ===================== -->
<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:url" content="{{ $ogUrl }}">
<meta property="og:type" content="{{ $ogType }}">
@if($fbAppId)<meta property="fb:app_id" content="{{ $fbAppId }}">@endif

<!-- =====================
     Twitter Card Tags
    ===================== -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:image" content="{{ $ogImage }}">
<meta name="twitter:url" content="{{ $ogUrl }}">
