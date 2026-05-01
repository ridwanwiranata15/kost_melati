@php
    use App\Support\SeoMeta;

    $seoTitle = $seoTitle ?? SeoMeta::homeTitle();
    $seoDescription = $seoDescription ?? SeoMeta::homeDescription();
    $seoKeywords = $seoKeywords ?? SeoMeta::keywords();
    $canonicalUrl = $canonicalUrl ?? SeoMeta::canonicalUrl(request()->path() === '/' ? '/' : request()->path());
    $seoImage = $seoImage ?? SeoMeta::defaultImage();
@endphp

<title>{{ $seoTitle }}</title>

<meta name="description" content="{{ $seoDescription }}">
<meta name="keywords" content="{{ $seoKeywords }}">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="author" content="{{ \App\Support\SeoMeta::BUSINESS_NAME }}">
<meta name="language" content="id-ID">
<link rel="canonical" href="{{ $canonicalUrl }}">

<meta property="og:locale" content="id_ID">
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ \App\Support\SeoMeta::SITE_NAME }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:image" content="{{ $seoImage }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
<meta name="twitter:image" content="{{ $seoImage }}">

<script type="application/ld+json">
{!! SeoMeta::toJsonLd(SeoMeta::webSiteSchema()) !!}
</script>

<script type="application/ld+json">
{!! SeoMeta::toJsonLd(SeoMeta::localBusinessSchema()) !!}
</script>

<script type="application/ld+json">
{!! SeoMeta::toJsonLd(SeoMeta::faqSchema()) !!}
</script>
