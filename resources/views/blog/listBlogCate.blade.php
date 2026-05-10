@extends('layouts.main.master')
@section('title')
{{$title_page}} 
@endsection
@section('description')
{{$title_page}} 
@endsection
@section('image')
{{url(''.$banner[0]->image)}}
@endsection
@section('schema')
@php
    $cleanText = function ($value) {
        $text = (string) $value;
        // Remove zero-width chars that usually appear from copy/paste.
        return preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $text);
    };
    $jsonFlags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
    $currentUrl = url()->current();
    $homeUrl = route('home');
    $siteUrl = url('/');
    $categoryUrl = route('listCateBlog', ['slug' => $cate_name]);
    $pageTitle = $cleanText($title_page);
    $siteName = $cleanText($setting->webname ?? $setting->company ?? $title_page);
    $publisherName = $cleanText($setting->company ?? $siteName);
    $publisherLogo = !empty($setting->logo)
        ? url($setting->logo)
        : (!empty($banner[0]->image) ? url($banner[0]->image) : null);

    $itemListElements = [];
    foreach ($blog as $index => $item) {
        $postUrl = route('detailBlog', ['slug' => $item->slug]);
        $postImage = !empty($item->image) ? url($item->image) : null;
        $itemListElements[] = [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'url' => $postUrl,
            'item' => array_filter([
                '@type' => 'BlogPosting',
                'headline' => $cleanText(languageName($item->title)),
                'description' => $cleanText(strip_tags(languageName($item->description))),
                'datePublished' => optional($item->created_at)->toIso8601String(),
                'image' => $postImage,
                'mainEntityOfPage' => $postUrl,
            ], function ($value) {
                return !is_null($value) && $value !== '';
            }),
        ];
    }

    $schemaGraph = [
        [
            '@type' => 'WebSite',
            '@id' => $siteUrl . '#website',
            'url' => $siteUrl,
            'name' => $siteName,
            'inLanguage' => 'vi-VN',
        ],
        array_filter([
            '@type' => 'Organization',
            '@id' => $siteUrl . '#organization',
            'name' => $publisherName,
            'url' => $siteUrl,
            'logo' => $publisherLogo ? [
                '@type' => 'ImageObject',
                'url' => $publisherLogo,
            ] : null,
        ], function ($value) {
            return !is_null($value) && $value !== '';
        }),
        [
            '@type' => 'BreadcrumbList',
            '@id' => $currentUrl . '#breadcrumb',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Trang chủ',
                    'item' => $homeUrl,
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => $pageTitle,
                    'item' => $categoryUrl,
                ],
            ],
        ],
        [
            '@type' => 'CollectionPage',
            '@id' => $currentUrl . '#collection',
            'url' => $currentUrl,
            'name' => $pageTitle,
            'description' => $pageTitle,
            'inLanguage' => 'vi-VN',
            'isPartOf' => [
                '@type' => 'WebSite',
                '@id' => $siteUrl . '#website',
            ],
        ],
        [
            '@type' => 'ItemList',
            '@id' => $currentUrl . '#itemlist',
            'name' => $pageTitle,
            'numberOfItems' => count($itemListElements),
            'itemListElement' => $itemListElements,
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@graph' => $schemaGraph], $jsonFlags) !!}</script>
@endsection
@section('css')
@endsection
@section('js')

@endsection
@section('content')
<div class="breadcumb-wrapper breadcumb-wrapper--overlay" data-bg-src="{{url(''.$banner[0]->image)}}">
    <div class="container">
       <div class="breadcumb-content">
          <h1 class="breadcumb-title">{{($title_page)}}</h1>
          <div class="breadcumb-menu-wrapper">
             <ul class="breadcumb-menu">
                <li><a href="{{route('home')}}">Home</a></li>
                <li><a href="{{route('listCateBlog',['slug'=>$cate_name])}}">{{($title_page)}}</a></li>
                <li>{{($title_page)}}</li>
             </ul>
          </div>
       </div>
    </div>
 </div>
<div class="themeholy-blog-wrapper blog-details space-top space-extra-bottom">
    <div class="container-md container-fluid">
        <div class="row g-4 mb-80 justify-content-center">
            @if (count($blog) > 0)
            @foreach ($blog as $item)
            <div class="col-lg-4 col-sm-6">
                <div class="blog-card style2">
                    <div class="blog-img">
                        <a href="{{route('detailBlog',['slug'=>$item->slug])}}">
                            <img src="{{ url('' . $item->image) }}" alt="{{ languageName($item->title) }}">
                        </a>
                        <div class="blog-card_wrapper">
                            <span class="blog-card_date">{{ date_format($item->created_at, 'd') }}</span>
                            <span class="blog-card_month">{{ date_format($item->created_at, 'M') }}</span>
                        </div>
                    </div>
                    <div class="blog-card-content">
                        <div class="blog-meta">
                            <a href="{{route('detailBlog',['slug'=>$item->slug])}}" tabindex="-1">
                                <i class="fa-regular fa-user"></i>By-Admin
                            </a>
                        </div>
                        <h3 class="box-title">
                            <a href="{{route('detailBlog',['slug'=>$item->slug])}}" tabindex="-1">{{ languageName($item->title) }}</a>
                        </h3>
                        <div class="blog-card_text line_2">{!! languageName($item->description) !!}</div>
                        <a href="{{route('detailBlog',['slug'=>$item->slug])}}" class="half-line-btn" tabindex="-1">
                            Xem thêm<i class="fa-solid fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <h3>Nội dung đang cập nhật</h3>
            @endif
        </div>
        <nav class="shop-pagination">
            {{ $blog->links() }}
        </nav>
    </div>
</div>
@endsection