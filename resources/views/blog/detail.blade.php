@extends('layouts.main.master')
@section('title')
{{ $blog_detail->seo_title ? $blog_detail->seo_title : languageName($blog_detail->title) }}
@endsection
@section('description')
{{ $blog_detail->meta_description ? $blog_detail->meta_description : languageName($blog_detail->description) }}
@endsection
@section('image')
{{url(''.$blog_detail->image)}}
@endsection
@section('schema')
@php
    $cleanText = function ($value) {
        $text = (string) $value;
        // Remove zero-width chars that usually appear from copy/paste.
        return preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $text);
    };
    $jsonFlags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
    $postTitle = $cleanText(languageName($blog_detail->title));
    $postDescription = $cleanText($blog_detail->meta_description ?: strip_tags(languageName($blog_detail->description)));
    $postContentText = trim($cleanText(strip_tags(languageName($blog_detail->content))));
    preg_match_all('/[\p{L}\p{N}]+/u', $postContentText, $wordMatches);
    $postWordCount = count($wordMatches[0]);
    $postUrl = url()->current();
    $homeUrl = route('home');
    $categoryUrl = route('listCateBlog', ['slug' => $blog_detail->category]);
    $siteName = $setting->webname ?? $setting->company ?? 'Website';
    $publisherName = $setting->company ?? $siteName;
    $publisherLogo = !empty($setting->logo) ? url($setting->logo) : url(''.$blog_detail->image);
@endphp
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "WebSite",
      "@id": {!! json_encode(url('/') . '#website', $jsonFlags) !!},
      "url": {!! json_encode(url('/'), $jsonFlags) !!},
      "name": {!! json_encode($siteName, $jsonFlags) !!}
    },
    {
      "@type": "Organization",
      "@id": {!! json_encode(url('/') . '#organization', $jsonFlags) !!},
      "name": {!! json_encode($publisherName, $jsonFlags) !!},
      "url": {!! json_encode(url('/'), $jsonFlags) !!},
      "logo": {
        "@type": "ImageObject",
        "url": {!! json_encode($publisherLogo, $jsonFlags) !!}
      }
    },
    {
      "@type": "BreadcrumbList",
      "@id": {!! json_encode($postUrl . '#breadcrumb', $jsonFlags) !!},
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Trang chủ",
          "item": {!! json_encode($homeUrl, $jsonFlags) !!}
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": {!! json_encode($cleanText(languageName($blog_detail->category)), $jsonFlags) !!},
          "item": {!! json_encode($categoryUrl, $jsonFlags) !!}
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": {!! json_encode($postTitle, $jsonFlags) !!},
          "item": {!! json_encode($postUrl, $jsonFlags) !!}
        }
      ]
    },
    {
      "@type": "BlogPosting",
      "@id": {!! json_encode($postUrl . '#article', $jsonFlags) !!},
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": {!! json_encode($postUrl, $jsonFlags) !!}
      },
      "headline": {!! json_encode($postTitle, $jsonFlags) !!},
      "description": {!! json_encode($postDescription, $jsonFlags) !!},
      "articleSection": {!! json_encode($cleanText(languageName($blog_detail->category)), $jsonFlags) !!},
      "inLanguage": "vi-VN",
      "wordCount": {{ $postWordCount }},
      "datePublished": {!! json_encode(optional($blog_detail->created_at)->toIso8601String(), $jsonFlags) !!},
      "dateModified": {!! json_encode(optional($blog_detail->updated_at)->toIso8601String(), $jsonFlags) !!},
      "image": [
        {
          "@type": "ImageObject",
          "url": {!! json_encode(url(''.$blog_detail->image), $jsonFlags) !!}
        }
      ],
      "author": {
        "@type": "Person",
        "name": {!! json_encode($cleanText($blog_detail->author ?: 'Admin'), $jsonFlags) !!}
      },
      "publisher": {
        "@type": "Organization",
        "@id": {!! json_encode(url('/') . '#organization', $jsonFlags) !!}
      }
    }
  ]
}
</script>
@endsection
@section('css')
<style>
.blog-detail-sticky {
  position: sticky;
  top: 100px;
  max-height: calc(100vh - 116px);
  overflow-y: auto;
  padding-right: 4px;
}
@media (max-width: 991.98px) {
  .blog-detail-sticky {
    position: relative;
    top: 0;
    max-height: none;
    overflow: visible;
    padding-right: 0;
  }
}
</style>
@endsection
@section('js')
@endsection
@section('content')
<div class="breadcumb-wrapper breadcumb-wrapper--overlay" data-bg-src="{{url(''.$blog_detail->image)}}">
    <div class="container">
       <div class="breadcumb-content">
          <h1 class="breadcumb-title">{{languageName($blog_detail->title)}}</h1>
          <div class="breadcumb-menu-wrapper">
             <ul class="breadcumb-menu">
                <li><a href="{{route('home')}}">Home</a></li>
                <li><a href="{{route('listCateBlog',['slug'=>$blog_detail->category])}}">{{languageName($blog_detail->category)}}</a></li>
                <li>{{languageName($blog_detail->title)}}</li>
             </ul>
          </div>
       </div>
    </div>
 </div>
 <section class="themeholy-blog-wrapper blog-details space-top space-extra-bottom">
    <div class="container">
       <div class="row">
          <div class="col-xxl-9 col-lg-8">
             <div class="themeholy-blog blog-single has-post-thumbnail">
                <div class="blog-img">
                   <img src="{{ url('' . $blog_detail->image) }}" alt="{{ languageName($blog_detail->title) }}">
                </div>
                <div class="blog-content">
                   <div class="blog-meta">
                      <a href="#"><i class="fa-regular fa-user"></i>By-{{ $blog_detail->author ?: 'Admin' }}</a>
                      <a href="#"><i class="fa-light fa-calendar-days"></i>{{ optional($blog_detail->created_at)->format('d M, Y') }}</a>
                      <a href="{{ route('listCateBlog', ['slug' => $blog_detail->category]) }}"><i class="fa-regular fa-folder"></i>{{ languageName($blog_detail->category) }}</a>
                   </div>
                   <h1 class="blog-title">{{ languageName($blog_detail->title) }}</h1>
                   {!! languageName($blog_detail->content) !!}

                   @if($prevBlog || $nextBlog)
                   <div class="row gy-3 mt-4">
                      @if($prevBlog)
                      <div class="col-md-6">
                         <a class="themeholy-btn w-100 text-start" href="{{ route('detailBlog', ['slug' => $prevBlog->slug]) }}">
                            <i class="far fa-arrow-left"></i> {{ \Illuminate\Support\Str::limit(languageName($prevBlog->title), 58) }}
                         </a>
                      </div>
                      @endif
                      @if($nextBlog)
                      <div class="col-md-6">
                         <a class="themeholy-btn blue-btn w-100 text-start" href="{{ route('detailBlog', ['slug' => $nextBlog->slug]) }}">
                            {{ \Illuminate\Support\Str::limit(languageName($nextBlog->title), 58) }} <i class="far fa-arrow-right"></i>
                         </a>
                      </div>
                      @endif
                   </div>
                   @endif
                </div>
             </div>
          </div>
          <div class="col-xxl-3 col-lg-4">
             <aside class="sidebar-area blog-detail-sticky">
    

                <div class="widget widget_categories">
                    <h3 class="widget_title">Danh mục dịch vụ</h3>
                    <ul>
                       @forelse($servicehome as $item)
                          <li>
                             <a href="{{ route('serviceList', ['slug' => $item->slug]) }}">{{ languageName($item->name) }}</a>
                          </li>
                       @empty
                          <li><span>Chưa có danh mục dịch vụ</span></li>
                       @endforelse
                    </ul>
                 </div>

                <div class="widget">
                   <h3 class="widget_title">Bài viết mới<span class="shape"></span></h3>
                   <div class="recent-post-wrap">
                      @forelse($blognew->where('id', '!=', $blog_detail->id)->take(6) as $item)
                      <div class="recent-post">
                         <div class="media-img">
                            <a href="{{ route('detailBlog', ['slug' => $item->slug]) }}">
                               <img src="{{ url('' . $item->image) }}" alt="{{ languageName($item->title) }}">
                            </a>
                         </div>
                         <div class="media-body">
                            <div class="recent-post-meta"><a href="{{ route('detailBlog', ['slug' => $item->slug]) }}"><i class="fal fa-calendar-days"></i>{{ optional($item->created_at)->format('d M, Y') }}</a></div>
                            <h4 class="post-title"><a class="text-inherit" href="{{ route('detailBlog', ['slug' => $item->slug]) }}">{{ \Illuminate\Support\Str::limit(languageName($item->title), 58) }}</a></h4>
                         </div>
                      </div>
                      @empty
                      <p class="mb-0">Chưa có bài viết mới.</p>
                      @endforelse
                   </div>
                </div>
             </aside>
          </div>
       </div>
    </div>
 </section>

@endsection