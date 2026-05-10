@extends('layouts.main.master')
@section('title')
    {{ $product->seo_title ? $product->seo_title : $product->name }}
@endsection
@section('description')
    {{ $product->meta_description ? $product->meta_description : languageName($product->description) }}
@endsection
@section('image')
    @php
        $img = json_decode($product->images);
        $ungdung = json_decode($product->preserve);
    @endphp
    {{ url('' . $img[0]) }}
@endsection
@section('schema')
    @php
        $cleanText = function ($value) {
            $text = (string) $value;
            // Remove zero-width chars that usually appear from copy/paste.
            return preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $text);
        };
        $jsonFlags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
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

        $productUrl = url()->current();
        $homeUrl = route('home');
        $siteUrl = url('/');
        $categoryUrl = !empty($product->cate_slug) ? route('allListProCate', ['danhmuc' => $product->cate_slug]) : null;
        $siteName = $cleanText(config('app.name', 'Website'));
        $productName = $cleanText($product->name ?? '');
        $productDescription = $cleanText($product->meta_description ?: strip_tags(languageName($product->description)));
        $categoryName = $cleanText(optional($product->cate)->name ?? '');
        $sku = $cleanText($product->sku ?? '');
        $allImages = array_values(array_filter(array_map($toAbsoluteUrl, (array) $img)));
        $primaryImage = $allImages[0] ?? null;

        $price = (float) ($product->price ?? 0);
        $discount = (float) ($product->discount ?? 0);
        $offerPrice = $discount > 0 && $discount < $price ? $discount : $price;
        if ($offerPrice <= 0) {
            $offerPrice = $discount > 0 ? $discount : $price;
        }

        $schemaGraph = [
            [
                '@type' => 'WebSite',
                '@id' => $siteUrl . '#website',
                'url' => $siteUrl,
                'name' => $siteName,
                'inLanguage' => 'vi-VN',
            ],
            [
                '@type' => 'Organization',
                '@id' => $siteUrl . '#organization',
                'name' => $siteName,
                'url' => $siteUrl,
            ],
            [
                '@type' => 'BreadcrumbList',
                '@id' => $productUrl . '#breadcrumb',
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
                        'name' => $categoryName !== '' ? $categoryName : 'Sản phẩm',
                        'item' => $categoryUrl ?: route('allProduct'),
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 3,
                        'name' => $productName,
                        'item' => $productUrl,
                    ],
                ],
            ],
            [
                '@type' => 'Product',
                '@id' => $productUrl . '#product',
                'mainEntityOfPage' => [
                    '@type' => 'WebPage',
                    '@id' => $productUrl,
                ],
                'name' => $productName,
                'description' => $productDescription,
                'url' => $productUrl,
                'sku' => $sku !== '' ? $sku : null,
                'category' => $categoryName !== '' ? $categoryName : null,
                'image' => $allImages,
                'brand' => [
                    '@type' => 'Brand',
                    'name' => $siteName,
                ],
                'offers' => [
                    '@type' => 'Offer',
                    'url' => $productUrl,
                    'priceCurrency' => 'VND',
                    'price' => $offerPrice > 0 ? number_format($offerPrice, 0, '.', '') : null,
                    'availability' => 'https://schema.org/InStock',
                    'itemCondition' => 'https://schema.org/NewCondition',
                    'seller' => [
                        '@type' => 'Organization',
                        '@id' => $siteUrl . '#organization',
                    ],
                ],
            ],
        ];

        if (!empty($primaryImage)) {
            $schemaGraph[1]['logo'] = [
                '@type' => 'ImageObject',
                'url' => $primaryImage,
            ];
        }

        if (empty($schemaGraph[3]['image'])) {
            unset($schemaGraph[3]['image']);
        }
        if (empty($schemaGraph[3]['sku'])) {
            unset($schemaGraph[3]['sku']);
        }
        if (empty($schemaGraph[3]['category'])) {
            unset($schemaGraph[3]['category']);
        }
        if (empty($schemaGraph[3]['offers']['price'])) {
            unset($schemaGraph[3]['offers']);
        }
    @endphp
    <script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@graph' => $schemaGraph], $jsonFlags) !!}</script>
@endsection
@section('css')
<style>
.product-gallery .product-big-img .img {
    border-radius: 12px;
    overflow: hidden;
}
.product-gallery .product-big-img img {
    width: 100%;
    height: auto;
    display: block;
}
.product-thumb-slider-wrap {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 12px;
}
.product-thumb-slider {
    flex: 1;
    display: flex;
    gap: 8px;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding-bottom: 4px;
}
.product-thumb-slider::-webkit-scrollbar {
    height: 6px;
}
.product-thumb-slider::-webkit-scrollbar-thumb {
    background: rgba(13, 71, 161, 0.35);
    border-radius: 10px;
}
.product-thumb-item {
    border: 2px solid transparent;
    padding: 0;
    border-radius: 8px;
    background: #fff;
    width: 78px;
    min-width: 78px;
    height: 78px;
    overflow: hidden;
    cursor: pointer;
    transition: border-color .2s ease, transform .2s ease;
}
.product-thumb-item:hover {
    border-color: rgba(13, 71, 161, 0.45);
}
.product-thumb-item.is-active {
    border-color: #0d47a1;
    transform: translateY(-1px);
}
.product-thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.product-thumb-nav {
    border: 1px solid rgba(10, 31, 68, 0.14);
    background: #fff;
    color: #0d47a1;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    line-height: 30px;
    text-align: center;
    padding: 0;
}
.product-contact-cta .themeholy-btn {
    border-radius: 8px;
    min-width: 118px;
    padding: 12px 18px;
    font-size: 13px;
    line-height: 20px;
    justify-content: center;
}
.product-contact-cta__hotline {
    background: linear-gradient(135deg, #ff6b35, #ff3d00) !important;
    color: #fff !important;
}
.product-contact-cta__hotline:before {
    background: linear-gradient(135deg, #ff6b35, #ff3d00) !important;
}
.product-contact-cta__hotline:hover {
    background: linear-gradient(135deg, #ff5722, #e53935) !important;
}
.product-contact-cta__hotline:hover:before {
    background: linear-gradient(135deg, #ff5722, #e53935) !important;
}
.product-contact-cta__zalo {
    background: linear-gradient(135deg, #1a73e8, #0068ff) !important;
    color: #fff !important;
}
.product-contact-cta__zalo:before {
    background: linear-gradient(135deg, #1a73e8, #0068ff) !important;
}
.product-contact-cta__zalo:hover {
    background: linear-gradient(135deg, #0b5ed7, #0057d8) !important;
}
.product-contact-cta__zalo:hover:before {
    background: linear-gradient(135deg, #0b5ed7, #0057d8) !important;
}
.product-contact-cta__messenger {
    background: linear-gradient(135deg, #00b2ff, #006aff) !important;
    color: #fff !important;
}
.product-contact-cta__messenger:before {
    background: linear-gradient(135deg, #00b2ff, #006aff) !important;
}
.product-contact-cta__messenger:hover {
    background: linear-gradient(135deg, #0096ff, #0057ff) !important;
}
.product-contact-cta__messenger:hover:before {
    background: linear-gradient(135deg, #0096ff, #0057ff) !important;
}
.product-detail-tabs {
    margin-top: 26px;
}
.product-detail-tabs .product-tab-style1 {
    gap: 8px;
    margin-bottom: 14px;
    border-bottom: 1px solid rgba(15, 23, 42, 0.08);
    padding-bottom: 12px;
}
.product-detail-tabs .product-tab-style1 .nav-link.themeholy-btn {
    min-height: 40px;
    padding: 9px 16px;
    font-size: 13px;
    line-height: 18px;
    text-transform: none;
    border-radius: 8px;
    box-shadow: none;
    letter-spacing: 0;
}
.product-detail-tabs .tab-content {
    background: #fff;
    border: 1px solid rgba(15, 23, 42, 0.08);
    border-radius: 10px;
    padding: 16px 18px;
}
.product-detail-tabs .tab-pane {
    font-size: 14px;
    color: #334155;
    line-height: 1.65;
}
.product-spec-list {
    list-style: none;
    margin: 0;
    padding: 0;
}
.product-spec-list li {
    display: flex;
    gap: 8px;
    align-items: flex-start;
    padding: 8px 10px;
    border-radius: 7px;
    background: #f8fafc;
    border: 1px solid rgba(148, 163, 184, 0.2);
    margin-bottom: 7px;
    font-size: 13px;
    line-height: 1.5;
}
.product-spec-list li::before {
    content: "";
    width: 6px;
    height: 6px;
    border-radius: 50%;
    margin-top: 7px;
    background: #0d47a1;
    flex-shrink: 0;
}
.product-spec-empty {
    margin: 0;
    color: #64748b;
    font-size: 13px;
}
</style>
@endsection
@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var gallery = document.getElementById('productGallery');
    if (!gallery) return;

    var mainImage = gallery.querySelector('.product-main-image');
    var thumbSlider = gallery.querySelector('#productThumbSlider');
    var thumbs = gallery.querySelectorAll('.product-thumb-item');
    var prevBtn = gallery.querySelector('.product-thumb-nav.prev');
    var nextBtn = gallery.querySelector('.product-thumb-nav.next');

    function setActiveThumb(target) {
        thumbs.forEach(function (btn) {
            btn.classList.remove('is-active');
        });
        target.classList.add('is-active');
    }

    thumbs.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var img = btn.getAttribute('data-image');
            if (img && mainImage) {
                mainImage.src = img;
                setActiveThumb(btn);
            }
        });
    });

    if (prevBtn && thumbSlider) {
        prevBtn.addEventListener('click', function () {
            thumbSlider.scrollBy({ left: -180, behavior: 'smooth' });
        });
    }
    if (nextBtn && thumbSlider) {
        nextBtn.addEventListener('click', function () {
            thumbSlider.scrollBy({ left: 180, behavior: 'smooth' });
        });
    }
});
</script>
@endsection
@section('content')
    <!-- Start Breadcrumb Section -->
    <div class="breadcumb-wrapper breadcumb-wrapper--overlay" data-bg-src="{{url(''.$img[0])}}">
        <div class="container">
           <div class="breadcumb-content">
              <h1 class="breadcumb-title">{{($product->name)}}</h1>
              <div class="breadcumb-menu-wrapper">
                 <ul class="breadcumb-menu">
                    <li><a href="{{route('home')}}">Home</a></li>
                    <li><a href="{{route('allListProCate',['danhmuc'=>$product->cate_slug])}}">Sản phẩm</a></li>
                    <li>{{($product->name)}}</li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
    <section class="product-details space-top space-extra-bottom">
        <div class="container">
           <div class="row">
              @php
                  $galleryRaw = json_decode($product->images, true) ?? [];
                  $gallery = [];
                  foreach ($galleryRaw as $g) {
                      if (!$g) {
                          continue;
                      }
                      $gallery[] = preg_match('/^https?:\/\//i', $g) ? $g : url($g);
                  }
                  if (empty($gallery)) {
                      $gallery[] = '/frontend/img/product/product_details_1_1.jpg';
                  }
                  $mainImage = $gallery[0];
                  $price = (float) ($product->price ?? 0);
                  $discount = (float) ($product->discount ?? 0);
                  $salePrice = $discount > 0 ? $discount : $price;
                  $showOldPrice = $discount > 0 && $price > $discount;
                  $shortDesc = trim(preg_replace('/\s+/u', ' ', strip_tags((string) languageName($product->description))));
                  $preserveList = is_array($ungdung) ? $ungdung : [];
                  $categoryUrl = !empty($product->cate_slug) ? route('allListProCate', ['danhmuc' => $product->cate_slug]) : route('allProduct');
              @endphp
              <div class="col-lg-6">
                 <div class="product-gallery" id="productGallery">
                 <div class="product-big-img">
                    <div class="img"><img class="product-main-image" src="{{ $mainImage }}" alt="{{ $product->name }}"></div>
                 </div>
                 <div class="product-thumb-slider-wrap">
                    <button type="button" class="product-thumb-nav prev" aria-label="Ảnh trước"><i class="far fa-angle-left"></i></button>
                    <div class="product-thumb-slider" id="productThumbSlider">
                        @foreach($gallery as $image)
                        <button type="button" class="product-thumb-item {{ $loop->first ? 'is-active' : '' }}" data-image="{{ $image }}">
                            <img src="{{ $image }}" alt="{{ $product->name }} {{ $loop->iteration }}">
                        </button>
                        @endforeach
                    </div>
                    <button type="button" class="product-thumb-nav next" aria-label="Ảnh sau"><i class="far fa-angle-right"></i></button>
                 </div>
                 </div>
              </div>
              <div class="col-lg-6 align-self-center">
                 <div class="product-about">
                    <h2>{{($product->name)}}</h2>
                    <p class="price">
                       {{ number_format($salePrice) }}₫
                       @if($showOldPrice)
                          <del>{{ number_format($price) }}₫</del>
                       @endif
                    </p>
                    <p class="text">{{ $shortDesc }}</p>
                    @if(!empty($preserveList))
                    <div class="checklist">
                       <ul>
                          @foreach($preserveList as $item)
                             @if(!empty($item))
                                <li>{{ $item }}</li>
                             @endif
                          @endforeach
                       </ul>
                    </div>
                    @endif
                    @php
                       $hotlineValue = $setting->hotline ?? $setting->phone1 ?? '';
                       $hotlineDigits = preg_replace('/\D+/', '', (string) $hotlineValue);
                       $zaloLink = $hotlineDigits ? 'https://zalo.me/' . $hotlineDigits : '#';
                       $messengerLink = $setting->messenger ?? $setting->facebook ?? '#';
                    @endphp
                    <div class="product-contact-cta d-flex flex-wrap align-items-center mt-3" style="gap:10px;">
                       <a href="tel:{{ $hotlineDigits ?: $hotlineValue }}" class="themeholy-btn product-contact-cta__hotline">
                          Hotline
                          <span class="icon"><i class="fa-solid fa-phone"></i></span>
                       </a>
                       <a href="{{ $zaloLink }}" class="themeholy-btn product-contact-cta__zalo" target="_blank" rel="noopener">
                          Zalo
                          <span class="icon"><i class="fa-solid fa-comment-dots"></i></span>
                       </a>
                       <a href="{{ $messengerLink }}" class="themeholy-btn product-contact-cta__messenger" target="_blank" rel="noopener">
                          Messenger
                          <span class="icon"><i class="fa-brands fa-facebook-messenger"></i></span>
                       </a>
                    </div>
                 </div>
              </div>
           </div>
           <div class="product-detail-tabs">
           <ul class="nav product-tab-style1" id="productTab" role="tablist">
              <li class="nav-item" role="presentation"><a class="nav-link themeholy-btn active" id="description-tab" data-bs-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Chi tiết sản phẩm</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link themeholy-btn" id="reviews-tab" data-bs-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Thông số kỹ thuật</a></li>
           </ul>
           <div class="tab-content" id="productTabContent">
              <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                 {!! languageName($product->content) !!}
              </div>
              <div class="tab-pane fade " id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                 @php
                    $specs = json_decode($product->size, true);
                 @endphp
                 @if(is_array($specs) && count($specs))
                    <div class="checklist">
                       <ul class="product-spec-list">
                          @foreach($specs as $specKey => $spec)
                             @if(is_array($spec))
                                @php
                                   // Hỗ trợ nhiều cấu trúc kỹ thuật:
                                   // 1) {name, value}
                                   // 2) {label, content}
                                   // 3) mảng key => value bất kỳ
                                   $name = trim((string)($spec['name'] ?? $spec['label'] ?? ''));
                                   $value = trim((string)($spec['value'] ?? $spec['content'] ?? ''));
                                @endphp
                                @if($name !== '' || $value !== '')
                                   <li>{{ $name }}@if($value !== ''): {{ $value }}@endif</li>
                                @else
                                   @foreach($spec as $k => $v)
                                      @php
                                         $kText = trim((string)$k);
                                         $vText = is_array($v) ? trim((string)($v['content'] ?? $v['value'] ?? json_encode($v))) : trim((string)$v);
                                      @endphp
                                      @if($vText !== '')
                                         <li>{{ $kText !== '' && !is_numeric($kText) ? $kText . ': ' : '' }}{{ $vText }}</li>
                                      @endif
                                   @endforeach
                                @endif
                             @elseif(!empty($spec))
                                <li>{{ $spec }}</li>
                             @endif
                          @endforeach
                       </ul>
                    </div>
                 @else
                    <p class="product-spec-empty">Thông số kỹ thuật đang cập nhật.</p>
                 @endif
              </div>
           </div>
           </div>
           <div class="space-extra-top mb-30">
              <div class="row justify-content-between align-items-center">
                 <div class="col-auto">
                    <h2 class="sec-title">Sản phẩm tương tự</h2>
                 </div>
                 <div class="col d-none d-sm-block">
                    <hr class="title-line">
                 </div>
                 <div class="col-auto">
                    <div class="sec-btn">
                       <div class="icon-box"><button data-slick-prev="#productCarousel" class="slick-arrow default"><i class="far fa-arrow-left"></i></button> <button data-slick-next="#productCarousel" class="slick-arrow default"><i class="far fa-arrow-right"></i></button></div>
                    </div>
                 </div>
              </div>
              <div class="row themeholy-carousel" id="productCarousel" data-slide-show="4" data-lg-slide-show="3" data-md-slide-show="2" data-sm-slide-show="2" data-xs-slide-show="1">
                 @forelse($productlq as $pro)
                 <div class="col-xl-3 col-lg-4 col-sm-6">
                    @include('layouts.product.item', ['pro' => $pro])
                 </div>
                 @empty
                 <div class="col-12">
                    <p class="mb-0 text-center">Chưa có sản phẩm liên quan.</p>
                 </div>
                 @endforelse
              </div>
           </div>
        </div>
     </section>
@endsection
