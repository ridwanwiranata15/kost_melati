{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @php
        $baseUrl = rtrim(config('app.url'), '/');
        $today = now()->toDateString();

        $urls = [
            [
                'loc' => $baseUrl . '/',
                'lastmod' => $today,
                'changefreq' => 'weekly',
                'priority' => '1.0',
            ],
            [
                'loc' => $baseUrl . '/kos-terdekat-iain-curup',
                'lastmod' => $today,
                'changefreq' => 'weekly',
                'priority' => '1.0',
            ],
        ];
    @endphp

    @foreach ($urls as $url)
        <url>
            <loc>{{ $url['loc'] }}</loc>
            <lastmod>{{ $url['lastmod'] }}</lastmod>
            <changefreq>{{ $url['changefreq'] }}</changefreq>
            <priority>{{ $url['priority'] }}</priority>
        </url>
    @endforeach
</urlset>
