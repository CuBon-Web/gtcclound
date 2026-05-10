@extends('layouts.main.master')
@push('resource-hints')
    @if (isset($banner[0]) && !empty($banner[0]->image))
        @php $lcpBannerUrl = url('' . $banner[0]->image); @endphp
        <link rel="preload" as="image" href="{{ $lcpBannerUrl }}" fetchpriority="high">
    @endif
@endpush
@section('title')
    {{ $setting->company }}
@endsection
@section('description')
    {{ $setting->webname }}
@endsection
@section('image')
    {{ url('' . $banner[0]->image) }}
@endsection
@section('schema')
    @php
        $cleanText = function ($value) {
            $text = strip_tags((string) $value);
            return trim(preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $text));
        };
        $removeEmpty = function ($value) {
            return !is_null($value) && $value !== '';
        };
        $toAbsoluteUrl = function ($path) {
            $value = trim((string) $path);
            if ($value === '') {
                return null;
            }
            if (preg_match('/^https?:\/\//i', $value)) {
                return $value;
            }
            return url($value);
        };

        $jsonFlags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
        $siteUrl = url('/');
        $currentUrl = url()->current();
        $siteName = $cleanText($setting->webname ?? ($setting->company ?? config('app.name', 'Website')));
        $companyName = $cleanText($setting->company ?? $siteName);
        $pageDescription = $cleanText($setting->webname ?? $companyName);
        $logoUrl = !empty($setting->logo)
            ? $toAbsoluteUrl($setting->logo)
            : (!empty($banner[0]->image)
                ? $toAbsoluteUrl($banner[0]->image)
                : null);
        $pageImage = !empty($banner[0]->image) ? $toAbsoluteUrl($banner[0]->image) : $logoUrl;

        $sameAs = array_values(
            array_filter(
                array_map($toAbsoluteUrl, [
                    $setting->facebook ?? null,
                    $setting->youtube ?? null,
                    $setting->instagram ?? null,
                    $setting->tiktok ?? null,
                    $setting->twitter ?? null,
                    $setting->linkedin ?? null,
                ]),
            ),
        );

        $schemaGraph = [
            [
                '@type' => 'WebSite',
                '@id' => $siteUrl . '#website',
                'url' => $siteUrl,
                'name' => $siteName,
                'inLanguage' => 'vi-VN',
                'publisher' => [
                    '@id' => $siteUrl . '#organization',
                ],
                'potentialAction' => [
                    '@type' => 'SearchAction',
                    'target' => [
                        '@type' => 'EntryPoint',
                        'urlTemplate' => $siteUrl . '/?s={search_term_string}',
                    ],
                    'query-input' => 'required name=search_term_string',
                ],
            ],
            array_filter(
                [
                    '@type' => 'Organization',
                    '@id' => $siteUrl . '#organization',
                    'name' => $companyName,
                    'url' => $siteUrl,
                    'logo' => $logoUrl
                        ? [
                            '@type' => 'ImageObject',
                            'url' => $logoUrl,
                        ]
                        : null,
                    'telephone' => $cleanText($setting->phone1 ?? ''),
                    'email' => $cleanText($setting->email ?? ''),
                    'address' => !empty($setting->address1)
                        ? [
                            '@type' => 'PostalAddress',
                            'streetAddress' => $cleanText($setting->address1),
                            'addressCountry' => 'VN',
                        ]
                        : null,
                    'sameAs' => !empty($sameAs) ? $sameAs : null,
                ],
                $removeEmpty,
            ),
            [
                '@type' => 'BreadcrumbList',
                '@id' => $currentUrl . '#breadcrumb',
                'itemListElement' => [
                    [
                        '@type' => 'ListItem',
                        'position' => 1,
                        'name' => 'Trang chủ',
                        'item' => route('home'),
                    ],
                ],
            ],
            array_filter(
                [
                    '@type' => 'WebPage',
                    '@id' => $currentUrl . '#webpage',
                    'url' => $currentUrl,
                    'name' => $companyName,
                    'description' => $pageDescription,
                    'inLanguage' => 'vi-VN',
                    'isPartOf' => [
                        '@id' => $siteUrl . '#website',
                    ],
                    'about' => [
                        '@id' => $siteUrl . '#organization',
                    ],
                    'primaryImageOfPage' => $pageImage
                        ? [
                            '@type' => 'ImageObject',
                            'url' => $pageImage,
                        ]
                        : null,
                    'breadcrumb' => [
                        '@id' => $currentUrl . '#breadcrumb',
                    ],
                ],
                $removeEmpty,
            ),
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@graph' => $schemaGraph], $jsonFlags) !!}</script>
@endsection
@section('css')
    <style>
        .telecom-why {
            position: relative;
            background: #ffffff;
            padding: 90px 0;
            overflow: hidden;
            isolation: isolate;
        }
        .telecom-why__bg {
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 15% 20%, rgba(254, 209, 1, 0.16), transparent 55%),
                radial-gradient(circle at 85% 85%, rgba(254, 209, 1, 0.12), transparent 55%),
                linear-gradient(transparent 0, transparent calc(100% - 1px), rgba(254, 209, 1, 0.08) 100%),
                radial-gradient(rgba(254, 209, 1, 0.14) 1px, transparent 1px);
            background-size: auto, auto, 100% 80px, 28px 28px;
            -webkit-mask-image: radial-gradient(circle at center, #000 35%, transparent 80%);
                    mask-image: radial-gradient(circle at center, #000 35%, transparent 80%);
            z-index: -1;
        }

        .telecom-why .title-area .sub-title.telecom-why__sub {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 18px;
            border-radius: 999px;
            background: rgba(254, 209, 1, 0.16);
            color: #111827;
            border: 1px solid rgba(254, 209, 1, 0.45);
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 14px;
        }
        .telecom-why__pulse {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #fed101;
            box-shadow: 0 0 0 0 rgba(254, 209, 1, 0.58);
            animation: telecom-pulse 1.6s ease-out infinite;
        }
        @keyframes telecom-pulse {
            0% { box-shadow: 0 0 0 0 rgba(254, 209, 1, 0.58); }
            70% { box-shadow: 0 0 0 14px rgba(254, 209, 1, 0); }
            100% { box-shadow: 0 0 0 0 rgba(254, 209, 1, 0); }
        }
        .telecom-why__title {
            color: #0a1f44;
            font-weight: 700;
            line-height: 1.25;
            margin-bottom: 14px;
        }
        .telecom-why__lead {
            color: #5a6a85;
            max-width: 720px;
            margin: 0 auto;
        }

        .telecom-feature {
            position: relative;
            height: 100%;
            padding: 32px 28px;
            border-radius: 18px;
            background: #ffffff;
            border: 1px solid #e6ecf5;
            box-shadow: 0 8px 24px rgba(10, 31, 68, 0.04);
            overflow: hidden;
            transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
        }
        .telecom-feature::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(254, 209, 1, 0.12), rgba(255, 246, 184, 0.18));
            opacity: 0;
            transition: opacity 0.35s ease;
            z-index: 0;
        }
        .telecom-feature::after {
            content: "";
            position: absolute;
            top: -40px;
            right: -40px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(254, 209, 1, 0.35), transparent 70%);
            opacity: 0;
            transition: opacity 0.4s ease, transform 0.4s ease;
            z-index: 0;
        }
        .telecom-feature > * {
            position: relative;
            z-index: 1;
        }
        .telecom-feature:hover {
            transform: translateY(-6px);
            border-color: rgba(254, 209, 1, 0.75);
            box-shadow: 0 22px 44px rgba(254, 209, 1, 0.2);
        }
        .telecom-feature:hover::before { opacity: 1; }
        .telecom-feature:hover::after {
            opacity: 1;
            transform: scale(1.05);
        }

        .telecom-feature__icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            border-radius: 16px;
            font-size: 26px;
            color: #111827;
            background: linear-gradient(135deg, #fed101 0%, #ffe867 58%, #fff6b8 100%);
            box-shadow: 0 12px 28px rgba(254, 209, 1, 0.34);
            margin-bottom: 18px;
            transition: transform 0.35s ease;
        }
        .telecom-feature:hover .telecom-feature__icon {
            transform: rotate(-6deg) scale(1.05);
        }
        .telecom-feature__title {
            color: #0a1f44;
            font-size: 19px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .telecom-feature__desc {
            color: #5a6a85;
            font-size: 15px;
            line-height: 1.65;
            margin: 0;
        }

        @media (max-width: 991.98px) {
            .telecom-why { padding: 60px 0; }
            .telecom-feature { padding: 26px 22px; }
        }

        /* Tránh CLS khi slick khởi tạo hero */
        #hero .hero-slider-wrap-2 {
            min-height: 520px;
            min-height: min(580px, 82svh);
        }
    </style>
@endsection
@section('js')
@endsection
@section('content')
    <div class="themeholy-hero-wrapper hero-2" id="hero">
        <div class="hero-slider-wrap-2">
            <div class="hero-slider-2 number-dots themeholy-carousel" id="heroSlide1" data-fade="true" data-slide-show="1"
                data-md-slide-show="1" data-arrows="true">
                @foreach ($banner as $item)
                    <div class="themeholy-hero-slide">
                        @if ($loop->first)
                            <div class="themeholy-hero-bg background-image"
                                style="background-image:url('{{ url($item->image) }}');">
                            @else
                                <div class="themeholy-hero-bg" data-bg-src="{{ url($item->image) }}">
                        @endif
                            <div class="hero-shape"><img
                                    src="/frontend/img/hero_shape_2.png"
                                    alt=""
                                    decoding="async"
                                    @if ($loop->first) fetchpriority="high" @endif></div>
                        </div>
                        <div class="container">
                            <div class="hero-style2">
                                <h1 class="hero-title">{!! $item->title !!}</h1>
                                @if (!empty($item->description))
                                    <p class="hero-text">{{ $item->description }}</p>
                                @endif
                                    <div class="btn-group mt-30">
                                        <a href="{{ $item->link }}" class="themeholy-btn blue-btn">Chi tiết<span
                                                class="icon"><i class="fa-sharp fa-regular fa-paper-plane"></i></span></a>
                                    </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="hero-indicator-wrapp">
            <div class="hero-indicator" data-asnavfor=".hero-slider-2">
                @foreach ($banner as $item)
                    <a class="indicatior-btn @if ($loop->first) active @endif"><img src="{{ url($item->image) }}"
                            alt="{{ $setting->company }}"
                            @if ($loop->first) fetchpriority="high" decoding="async" @else loading="lazy" decoding="async" @endif></a>
                @endforeach
            </div>
        </div>
    </div>
    @if (!empty($gioithieu))
        @php
            $aboutTitle = languageName($gioithieu->title);
            $aboutImagePath = $gioithieu->image ?: '';
            $decoded = json_decode($aboutImagePath, true);
            if (is_array($decoded) && isset($decoded[0])) {
                $aboutImagePath = $decoded[0];
            }
            $aboutImage = $aboutImagePath
                ? url('' . ltrim($aboutImagePath, '/'))
                : '/frontend/img/normal/about_2.png';
            $aboutUrl = route('aboutUs');
        @endphp
        <div class="bg-bottom-center space-bottom"
            data-bg-src="/frontend/img/about_bg_1.png" data-bg-lazy>
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-xxl-7">
                        <div class="img-box3 style2">
                            <div class="img1">
                                <img src="{{ $aboutImage }}" alt="{{ $aboutTitle ?: 'Về chúng tôi' }}" loading="lazy" decoding="async">
                            </div>
                            <div class="about-counter1">
                                <h3 class="counter-title"><span class="counter-number">10</span>+</h3>
                                <span class="counter-text">Kinh nghiệm</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-xxl-5" style="margin: auto;">
                        <div class="title-area mb-30">
                            <span class="sub-title">
                                <img src="/frontend/img/title_left.svg"
                                    alt="shape" loading="lazy" decoding="async"> Về chúng tôi
                            </span>
                            <h2 class="sec-title">{{ $setting->company }}</h2>
                        </div>
                        <div class="mb-30 line_8">{!! languageName($gioithieu->content) !!}</div>
                        
                        <div class="btn-group style2">
                            <a href="{{ $aboutUrl }}" class="themeholy-btn">
                                Đọc tiếp<i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <section class="service-sec space" id="service-sec">
        <div class="container">
            <div class="title-area mt-n1 text-center">
                <span class="sub-title"><img src="/frontend/img/title_left.svg"
                        alt="shape" loading="lazy" decoding="async">Service</span>
                <h2 class="sec-title">Dịch vụ của chúng tôi</h2>
            </div>
            <div class="row slider-shadow themeholy-carousel" data-slide-show="3" data-xl-slide-show="3"
                data-lg-slide-show="3" data-md-slide-show="2" data-sm-slide-show="1" data-xs-slide-show="1"
                data-arrows="true">
                @forelse ($servicehome as $item)
                    <div class="col-md-6 col-lg-4 col-xl-4">
                        <div class="service-card"
                            data-href="{{ route('serviceList', ['slug' => $item->slug]) }}"
                            role="link"
                            tabindex="0"
                            style="cursor:pointer;"
                            onclick="if (this.dataset.href && this.dataset.href !== '#') window.location.href = this.dataset.href;"
                            onkeydown="if ((event.key === 'Enter' || event.key === ' ') && this.dataset.href && this.dataset.href !== '#') { event.preventDefault(); window.location.href = this.dataset.href; }">
                            <div class="service-card_img">
                                <a href="{{ route('serviceList', ['slug' => $item->slug]) }}">
                                    <img src="{{ url($item->image) }}" alt="{{ $item->name }}" loading="lazy" decoding="async">
                                </a>
                            </div>
                            <div class="service-card_wrapper">
                                <div class="service-card_content"
                                    data-bg-src="/frontend/img/pattern_1_1.svg" data-bg-lazy>
                                 
                                    <h3 class="service-card_title">
                                        <a href="{{ route('serviceList', ['slug' => $item->slug]) }}">{{ languageName($item->name) }}</a>
                                    </h3>
                                    <p class="service-card_desc line_3">{!! languageName($item->description) !!}</p>
                                </div>
                                <div class="share-option">
                                    <div class="share-link"><i class="fa-sharp fa-regular fa-arrow-up"></i></div>
                                    <div class="team-social2">
                                        <div class="icon-team-list">
                                            <a href="{{ route('serviceList', ['slug' => $item->slug]) }}" class="ser-icon">
                                                <i class="fa-sharp fa-regular fa-arrow-up"></i>
                                                <p class="ser-title">Chi tiết</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Nội dung đang cập nhật...</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <section class="space featured-product-sec overflow-hidden">
        <div class="container">
            <div class="title-area text-center">
                <span class="sub-title">
                    <img src="/frontend/img/title_left.svg" alt="shape" loading="lazy" decoding="async">
                    Sản phẩm nổi bật
                </span>
                <h2 class="sec-title">Khám phá thiết bị của chúng tôi</h2>
            </div>

            @if ($homePro->count() > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="themeholy-carousel"
                            data-slide-show="4"
                            data-xl-slide-show="4"
                            data-ml-slide-show="4"
                            data-lg-slide-show="3"
                            data-md-slide-show="2"
                            data-arrows="true"
                            data-dots="false"
                            data-autoplay="true"
                            data-autoplay-speed="6000"
                            data-prev-arrow="far fa-arrow-left"
                            data-next-arrow="far fa-arrow-right">
                            @foreach ($homePro as $pro)
                                
                                <div class="px-2">
                                    @include('layouts.product.item',['pro'=>$pro])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <p class="text-center mb-0">Chưa có sản phẩm nổi bật.</p>
            @endif
        </div>
    </section>
    <section class="overflow-hidden space process-sec bg-smoke space background-image"
        style="background-image: url(&quot;/frontend/img/map.png&quot;);">
        <div class="container">
            <div class="process-line"><img src="/frontend/img/line-3.svg"
                    alt="" loading="lazy" decoding="async"></div>
            <div class="title-area text-center">
                <span class="sub-title"><img
                        src="/frontend/img/title_left.svg"
                        alt="shape" loading="lazy" decoding="async">Working Process</span>
                <h2 class="sec-title">Quy trình làm việc</h2>
            </div>
            <div class="row gy-30 align-item-center">
                @foreach ($processSteps as $item)
                    <div class="col-md-6 col-lg-6 col-xl-3 col-6">
                        <div class="process-card">
                            <div class="process-card_icon">
                                <img src="{{ $item->icon ?: '/frontend/img/process_1_1.svg' }}"
                                    alt="{{ $item->title }}" loading="lazy" decoding="async">
                                <div class="process-card_number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                            </div>
                            <h2 class="process-card_title box-title">{{ $item->title }}</h2>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="telecom-why space overflow-hidden">
        <div class="telecom-why__bg" aria-hidden="true"></div>
        <div class="container position-relative">
            <div class="title-area text-center mb-50">
                <span class="sub-title telecom-why__sub">
                    <span class="telecom-why__pulse"></span>
                    Vì sao chọn chúng tôi
                </span>
                <h2 class="sec-title telecom-why__title">Giải pháp GTC Clound chuyên nghiệp – Linh hoạt – Bảo mật</h2>
                <p class="telecom-why__lead">Hạ tầng đặt tại Data Center Tier 3 (FPT, VNPT), tích hợp đầy đủ API/Webservice và hỗ trợ kỹ thuật 24/7 – sẵn sàng đồng hành cùng doanh nghiệp của bạn.</p>
            </div>
            <div class="row g-4">
                @foreach ($whyChooseUs as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="telecom-feature">
                            <div class="telecom-feature__icon">
                                <i class="{{ $item->icon ?: 'fa-solid fa-circle-check' }}"></i>
                            </div>
                            <h3 class="telecom-feature__title">{{ $item->title }}</h3>
                            <p class="telecom-feature__desc">{{ $item->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="testi-sec" data-bg-src="/frontend/img/testimonial_bg_2.jpg" data-bg-lazy>
        <div class="container">
            <div class="row">
                <div class="col-xl-4">
                    <div class="title-area">
                        <span class="sub-title text-black"><img
                                src="/frontend/img/title_left.svg"
                                alt="shape" loading="lazy" decoding="async">Testimonial</span>
                        <h2 class="sec-title text-white">Khách hàng nói gì về chúng tôi</h2>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="row testi-slide slider-shadow themeholy-carousel" data-slide-show="2"
                        data-lg-slide-show="2" data-sm-slide-show="1" data-xs-slide-show="1">
                        @forelse ($ReviewCus as $item)
                            @php
                                $customerName = languageName($item->name);
                                $customerPosition = languageName($item->position);
                                $customerContent = languageName($item->content);
                                $customerAvatar = $item->avatar
                                    ?: '/frontend/img/testi_2_1.jpg';
                            @endphp
                            <div class="col-md-6 col-lg-4">
                                <div class="testi-card">
                                    <div class="testi-card_overlay"
                                        data-bg-src="/frontend/img/testi_shape.png" data-bg-lazy>
                                    </div>
                                    <div class="testi-card_wrapper">
                                        <div class="testi-icon">
                                            <div class="star-icon">
                                                <a href="javascript:void(0)"><i class="fa-solid fa-star"></i></a>
                                                <a href="javascript:void(0)"><i class="fa-solid fa-star"></i></a>
                                                <a href="javascript:void(0)"><i class="fa-solid fa-star"></i></a>
                                                <a href="javascript:void(0)"><i class="fa-solid fa-star"></i></a>
                                                <a href="javascript:void(0)"><i class="fa-solid fa-star"></i></a>
                                            </div>
                                        </div>
                                        <div class="testi-quote"><img
                                                src="/frontend/img/quote.svg"
                                                alt="" loading="lazy" decoding="async"></div>
                                    </div>
                                    <p class="testi-card_text">“{{ $customerContent }}”</p>
                                    <div class="testi-card_profile">
                                        <div class="testi-card_img">
                                            <img src="{{ $customerAvatar }}" alt="{{ $customerName ?: 'Khách hàng' }}" loading="lazy" decoding="async">
                                        </div>
                                        <div class="testi-card_info">
                                            <h3 class="testi-card_name">{{ $customerName }}</h3>
                                            <span class="testi-card_desig">{{ $customerPosition }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-white mb-0">Nội dung đang cập nhật...</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="space" id="blog-sec">
        <div class="container">
            <div class="title-area text-center">
                <span class="sub-title"><img
                        src="/frontend/img/title_left.svg"
                        alt="shape" loading="lazy" decoding="async">News</span>
                <h2 class="sec-title">Tin tức cập nhật</h2>
            </div>
            <div class="row slider-shadow themeholy-carousel" id="blogSlide1" data-slide-show="3" data-lg-slide-show="2"
                data-md-slide-show="2" data-sm-slide-show="1" data-arrows="true">
                @forelse ($hotnews as $item)
                    @php
                        $blogUrl = route('detailBlog', ['slug' => $item->slug]);
                        $blogTitle = languageName($item->title);
                    @endphp
                    <div class="col-md-6 col-xl-4">
                        <div class="blog-card style2">
                            <div class="blog-img">
                                <a href="{{ $blogUrl }}">
                                    <img src="{{ url('' . $item->image) }}" alt="{{ $blogTitle }}" loading="lazy" decoding="async">
                                </a>
                                <div class="blog-card_wrapper">
                                    <span class="blog-card_date">{{ date_format($item->created_at, 'd') }}</span>
                                    <span class="blog-card_month">{{ date_format($item->created_at, 'M') }}</span>
                                </div>
                            </div>
                            <div class="blog-card-content">
                                <div class="blog-meta">
                                    <a href="{{ $blogUrl }}" tabindex="-1">
                                        <i class="fa-regular fa-user"></i>By-Admin
                                    </a>
                                </div>
                                <h3 class="box-title">
                                    <a href="{{ $blogUrl }}" tabindex="-1">{{ $blogTitle }}</a>
                                </h3>
                                <p class="blog-card_text line_2">{!! languageName($item->description) !!}</p>
                                <a href="{{ $blogUrl }}" class="half-line-btn" tabindex="-1">
                                    Xem thêm<i class="fa-solid fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="mb-0">Nội dung đang cập nhật...</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <div class="integration-sec space-bottom">
        <div class="container">
            @foreach ($integrationLogoGroups as $groupKey => $groupLabel)
                @php $logos = $integrationLogos[$groupKey] ?? collect(); @endphp
                @if ($logos->count() > 0)
                    <div class="integration-block">
                        <div class="integration-block__head">
                            <span class="integration-block__line"></span>
                            <h3 class="integration-block__title">{{ mb_strtoupper($groupLabel, 'UTF-8') }}</h3>
                            <span class="integration-block__line"></span>
                        </div>
                        <div class="row themeholy-carousel"
                            data-slide-show="5" data-lg-slide-show="4"
                            data-md-slide-show="3" data-sm-slide-show="3" data-xs-slide-show="2"
                            data-autoplay="true" data-autoplay-speed="5000">
                            @foreach ($logos as $logo)
                                <div class="col-auto">
                                    <div class="brand-box">
                                        @if ($logo->link)
                                            <a href="{{ $logo->link }}" target="_blank" rel="noopener nofollow">
                                                <img src="{{ $logo->image }}" alt="{{ $logo->name }}" loading="lazy" decoding="async">
                                            </a>
                                        @else
                                            <img src="{{ $logo->image }}" alt="{{ $logo->name }}" loading="lazy" decoding="async">
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
