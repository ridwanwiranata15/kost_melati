<?php

namespace App\Support;

final class SeoMeta
{
    public const SITE_NAME = 'Kos El Sholeha';
    public const BUSINESS_NAME = 'Kos El Sholeha Indah';
    public const PRIMARY_KEYWORD = 'kos terdekat IAIN Curup';

    public const ADDRESS_STREET = 'Jalan Hegel Blok A No.03, Dusun Curup';
    public const ADDRESS_LOCALITY = 'Curup Utara';
    public const ADDRESS_REGION = 'Bengkulu';
    public const ADDRESS_POSTAL_CODE = '39119';
    public const ADDRESS_COUNTRY = 'ID';

    public const PHONE_PRIMARY = '085273599597';
    public const PHONE_SECONDARY = '085267399374';
    public const PHONE_THIRD = '082176253810';

    public static function baseUrl(): string
    {
        return rtrim((string) config('app.url'), '/');
    }

    public static function canonicalUrl(string $path = '/'): string
    {
        $path = '/' . ltrim($path, '/');

        return self::baseUrl() . $path;
    }

    public static function homeTitle(): string
    {
        return 'Kos Terdekat IAIN Curup | Kos El Sholeha Indah Curup';
    }

    public static function homeDescription(): string
    {
        return 'Kos terdekat IAIN Curup hanya sekitar 5 menit dari kampus. Kos El Sholeha Indah menyediakan kamar nyaman, WiFi, CCTV 24 jam, fasilitas lengkap, dan lingkungan tenang untuk mahasiswa.';
    }

    public static function keywords(): string
    {
        return implode(', ', [
            'kos terdekat IAIN Curup',
            'kos dekat IAIN Curup',
            'kost dekat IAIN Curup',
            'kos mahasiswa IAIN Curup',
            'kos putri Curup',
            'kos Curup Utara',
            'kos Rejang Lebong',
            'kost murah dekat IAIN Curup',
            'kos nyaman di Curup',
            'Kost El Sholeha Curup',
        ]);
    }

    public static function defaultImage(): string
    {
        return self::canonicalUrl('/images/og-kos-el-sholeha.jpg');
    }

    public static function localBusinessSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'LodgingBusiness',
            '@id' => self::canonicalUrl('/#localbusiness'),
            'name' => self::BUSINESS_NAME,
            'alternateName' => [
                'Kos El Sholeha',
                'Kos El Sholeha Curup',
                'Kos dekat IAIN Curup',
            ],
            'description' => self::homeDescription(),
            'url' => self::canonicalUrl('/'),
            'hasMap' => 'https://maps.app.goo.gl/PK14jifsM6aMJ4Mc7',
            'telephone' => self::PHONE_PRIMARY,
            'priceRange' => 'Rp500.000 - Rp5.000.000',
            'image' => [
                self::defaultImage(),
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => self::ADDRESS_STREET,
                'addressLocality' => self::ADDRESS_LOCALITY,
                'addressRegion' => self::ADDRESS_REGION,
                'postalCode' => self::ADDRESS_POSTAL_CODE,
                'addressCountry' => self::ADDRESS_COUNTRY,
            ],
            'areaServed' => [
                [
                    '@type' => 'Place',
                    'name' => 'IAIN Curup',
                ],
                [
                    '@type' => 'Place',
                    'name' => 'Curup Utara',
                ],
                [
                    '@type' => 'Place',
                    'name' => 'Kabupaten Rejang Lebong',
                ],
            ],
            'amenityFeature' => [
                [
                    '@type' => 'LocationFeatureSpecification',
                    'name' => 'WiFi',
                    'value' => true,
                ],
                [
                    '@type' => 'LocationFeatureSpecification',
                    'name' => 'CCTV 24 Jam',
                    'value' => true,
                ],
                [
                    '@type' => 'LocationFeatureSpecification',
                    'name' => 'Kamar mandi pribadi',
                    'value' => true,
                ],
                [
                    '@type' => 'LocationFeatureSpecification',
                    'name' => 'Area parkir',
                    'value' => true,
                ],
            ],
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => [
                        'Monday',
                        'Tuesday',
                        'Wednesday',
                        'Thursday',
                        'Friday',
                        'Saturday',
                        'Sunday',
                    ],
                    'opens' => '00:00',
                    'closes' => '23:59',
                ],
            ],
        ];
    }

    public static function webSiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => self::canonicalUrl('/#website'),
            'url' => self::canonicalUrl('/'),
            'name' => self::SITE_NAME,
            'description' => self::homeDescription(),
            'inLanguage' => 'id-ID',
            'publisher' => [
                '@id' => self::canonicalUrl('/#localbusiness'),
            ],
        ];
    }

    public static function faqSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => [
                [
                    '@type' => 'Question',
                    'name' => 'Apakah Kos El Sholeha dekat dengan IAIN Curup?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Ya, Kos El Sholeha berada dekat dengan IAIN Curup dan dapat menjadi pilihan kos strategis untuk mahasiswa yang ingin tinggal dekat kampus.',
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Berapa harga kos di Kos El Sholeha?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Harga kos mulai dari Rp 500.000 per bulan. Paket 1 tahun tersedia dengan harga Rp 5.000.000.',
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Fasilitas apa saja yang tersedia?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Fasilitas yang tersedia meliputi WiFi, CCTV 24 jam, kamar mandi pribadi, dapur pribadi per kamar, area parkir, dan furnitur kamar.',
                    ],
                ],
            ],
        ];
    }

    public static function toJsonLd(array $schema): string
    {
        return json_encode(
            $schema,
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );
    }
}
