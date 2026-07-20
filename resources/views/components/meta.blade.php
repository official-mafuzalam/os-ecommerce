<!-- =====================
     SEO & Meta Tags
    ===================== -->
@php
    $metaTitle = isset($product) && $product->meta_title ? $product->meta_title : (isset($product) ? $product->name : ($title ?? setting('site_name', 'Octosync Software Ltd')));
    $metaDescription = isset($product) && $product->meta_description ? $product->meta_description : (isset($product) ? ($product->short_description ?? \Illuminate\Support\Str::limit(strip_tags($product->description), 150)) : setting('meta_description', 'Best E-commerce website'));
    $metaKeywords = isset($product) && $product->meta_keywords ? $product->meta_keywords : setting('meta_keywords', 'software, solutions, it');
    
    // Determine OG Image
    $ogImage = asset('default-og.png');
    if (isset($product) && $product->images->count() > 0) {
        $ogImage = Storage::url($product->images->where('is_primary', true)->first()?->image_path ?? $product->images->first()->image_path);
    } else {
        $ogImage = setting('og_image', asset('default-og.png'));
    }
@endphp
<meta name="description" content="{{ $metaDescription }}">
<meta name="keywords" content="{{ $metaKeywords }}">
<meta name="author" content="{{ setting('meta_author', setting('site_name', 'Octosync Software Ltd')) }}">
<meta name="language" content="{{ setting('meta_language', 'en') }}">

<!-- =====================
     Open Graph Tags
    ===================== -->
<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:url" content="{{ setting('og_url', url()->current()) }}">
<meta property="og:type" content="{{ isset($product) ? 'product' : 'website' }}">
<meta property="fb:app_id" content="{{ setting('fb_app_id') }}">

<!-- =====================
     Twitter Card Tags
    ===================== -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:image" content="{{ $ogImage }}">
