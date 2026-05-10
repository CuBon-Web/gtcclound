@php
    $imgList = json_decode($pro->images, true) ?? [];
    $proImg = $imgList[0] ?? '/frontend/img/product/product_1_1.jpg';
    $productUrl = route('detailProduct', [
        'cate' => $pro->cate_slug,
        'type' => $pro->type_slug ? $pro->type_slug : 'loai',
        'id' => $pro->slug,
    ]);

    $originalPrice = (float) $pro->price;
    $salePrice = (float) $pro->discount;
    $variantMinPrice = isset($pro->variant_min_price) ? (float) $pro->variant_min_price : null;
    $variantMaxPrice = isset($pro->variant_max_price) ? (float) $pro->variant_max_price : null;
    if (!is_null($variantMinPrice)) {
        $salePrice = $variantMinPrice;
    }
    $discountPercent = 0;
    if ($originalPrice > 0 && $salePrice > 0 && $salePrice < $originalPrice) {
        $discountPercent = 100 - ceil(($salePrice / $originalPrice) * 100);
    }
@endphp

<div class="themeholy-product product-grid">
    <div class="product-img">
        <a href="{{ $productUrl }}">
            <img src="{{ $proImg }}" alt="{{ $pro->name }}" loading="lazy" decoding="async">
        </a>
        @if ($discountPercent > 0)
            <span class="product-badge">-{{ $discountPercent }}%</span>
        @endif
        <div class="actions">
            <a href="javascript:void(0)"
                class="icon-btn quick-view-trigger"
                data-bs-toggle="modal"
                data-bs-target="#product-view"
                data-quickview-url="{{ route('quickview', ['id' => $pro->id]) }}"
                data-product-url="{{ $productUrl }}"
                data-product-image="{{ $proImg }}"
                title="Xem nhanh">
                <i class="far fa-eye"></i>
            </a>
            <a href="{{ $productUrl }}" class="icon-btn" title="Xem chi tiết">
                <i class="far fa-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="product-content">
        @if ($pro->cate != null)
            <span class="product-cate">
                <a href="{{ route('allListProCate', ['danhmuc' => $pro->cate->slug]) }}">
                    {{ languageName($pro->cate->name) }}
                </a>
            </span>
        @endif
        <h3 class="product-title">
            <a href="{{ $productUrl }}">{{ $pro->name }}</a>
        </h3>
        @if (!is_null($variantMinPrice) && !is_null($variantMaxPrice) && $variantMinPrice != $variantMaxPrice)
            <span class="price">
                {{ number_format($variantMinPrice) }}₫ - {{ number_format($variantMaxPrice) }}₫
            </span>
        @else
            <span class="price">
                {{ number_format($salePrice) }}₫
                @if ($discountPercent > 0)
                    <del>{{ number_format($originalPrice) }}₫</del>
                @endif
            </span>
        @endif
    </div>
</div>