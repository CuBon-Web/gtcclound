@extends('layouts.main.master')
@section('title')
{{$cateService->name}}
@endsection
@section('description')
{{$cateService->description}}
@endsection
@section('image')
{{url(''.$banner[0]->image)}}
@endsection
@section('css')
<style>
/* Bảng giá — phong cách viễn thông (xanh sâu + accent vàng, đồng bộ tone trang chủ) */
.service-pricing-wrap {
  position: relative;
  overflow: hidden;
}
.service-pricing-bg {
  position: absolute;
  inset: 0;
  pointer-events: none;
  opacity: 0.45;
  background-image:
    radial-gradient(circle at 12% 18%, rgba(13, 71, 161, 0.12) 0%, transparent 42%),
    radial-gradient(circle at 88% 72%, rgba(254, 209, 1, 0.14) 0%, transparent 45%),
    repeating-linear-gradient(-12deg, transparent, transparent 40px, rgba(10, 31, 68, 0.03) 40px, rgba(10, 31, 68, 0.03) 41px);
}
.service-pricing-wrap .title-area .sec-text {
  max-width: 36rem;
  margin: 0.75rem auto 0;
  color: #5a6a85;
  font-size: 0.95rem;
  line-height: 1.6;
}
.service-pricing-card {
  position: relative;
  border-radius: 16px;
  overflow: hidden;
  height: 100%;
  display: flex;
  flex-direction: column;
  background: #fff;
  border: 1px solid rgba(10, 31, 68, 0.08);
  box-shadow: 0 8px 32px rgba(10, 31, 68, 0.08);
  transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
}
.service-pricing-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 48px rgba(13, 71, 161, 0.15);
  border-color: rgba(13, 71, 161, 0.18);
}
.service-pricing-card__accent {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, #fed101 0%, #ffe566 35%, #0d47a1 100%);
  z-index: 2;
}
.service-pricing-card__head {
  position: relative;
  text-align: center;
  padding: 1.5rem 1.15rem 1.35rem;
  color: #fff;
  background: linear-gradient(145deg, #0a1f44 0%, #123a6e 48%, #0d47a1 100%);
}
.service-pricing-card__head::before {
  content: "";
  position: absolute;
  inset: 0;
  opacity: 0.22;
  background-image:
    linear-gradient(rgba(255,255,255,0.07) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px);
  background-size: 14px 14px;
  pointer-events: none;
}
.service-pricing-card__icon {
  position: relative;
  width: 48px;
  height: 48px;
  margin: 0 auto 12px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
  color: #0a1f44;
  background: linear-gradient(135deg, #fed101 0%, #ffe867 58%, #fff6b8 100%);
  box-shadow: 0 8px 22px rgba(254, 209, 1, 0.35);
}
.service-pricing-card__title {
  position: relative;
  font-weight: 700;
  font-size: 1.15rem;
  margin-bottom: 0.5rem;
  line-height: 1.35;
  letter-spacing: -0.02em;
}
.service-pricing-card__price {
  position: relative;
  font-weight: 700;
  font-size: 1.35rem;
  letter-spacing: -0.02em;
}
.service-pricing-card__price-unit {
  display: block;
  font-size: 0.8rem;
  font-weight: 600;
  opacity: 0.88;
  margin-top: 0.2rem;
  letter-spacing: 0;
}
.service-pricing-card__body {
  position: relative;
  flex: 1;
  font-size: 0.875rem;
  background: linear-gradient(180deg, #fafbfd 0%, #ffffff 100%);
  padding: 4px 0 0;
}
.service-pricing-card__row {
  display: grid;
  grid-template-columns: 1.15fr 0.85fr;
  border-bottom: 1px solid rgba(10, 31, 68, 0.06);
  min-height: 3rem;
}
.service-pricing-card__row:last-child {
  border-bottom: none;
}
.service-pricing-card__row:nth-child(even) .service-pricing-card__label {
  background: #f3f6fb;
}
.service-pricing-card__row:nth-child(even) .service-pricing-card__val {
  background: #f8fafc;
}
.service-pricing-card__cell {
  padding: 0.65rem 0.85rem;
  border-right: 1px solid rgba(10, 31, 68, 0.06);
  display: flex;
  align-items: center;
}
.service-pricing-card__cell:last-child {
  border-right: none;
}
.service-pricing-card__label {
  background: #eef2f8;
  font-weight: 600;
  color: #0a1f44;
  font-size: 0.8125rem;
  line-height: 1.45;
}
.service-pricing-card__val {
  justify-content: center;
  text-align: center;
  background: #fff;
  color: #1e293b;
  font-weight: 500;
}
.service-pricing-card__check-wrap {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 28px;
  height: 28px;
  border-radius: 50%;
  background: rgba(25, 135, 84, 0.12);
}
.service-pricing-card__check {
  color: #0f766e;
  font-size: 0.95rem;
}
.service-pricing-card__dash {
  color: #94a3b8;
  font-size: 1.1rem;
  font-weight: 300;
}
@media (max-width: 575.98px) {
  .service-pricing-card__price { font-size: 1.2rem; }
  .service-pricing-card__label { font-size: 0.78rem; }
}
.service-pricing-card__footer {
  padding: 1rem 1rem 1.1rem;
  margin-top: auto;
  border-top: 1px solid rgba(10, 31, 68, 0.08);
  background: #fff;
}
.service-pricing-card__footer .themeholy-btn {
  justify-content: center;
}
#servicePlanRegisterModal .modal-content {
  border: none;
  border-radius: 14px;
  box-shadow: 0 24px 60px rgba(10, 31, 68, 0.18);
}
#servicePlanRegisterModal .modal-header {
  border-bottom: 1px solid rgba(10, 31, 68, 0.08);
  padding: 1.1rem 1.25rem;
}
#servicePlanRegisterModal .modal-title {
  font-weight: 700;
  color: #0a1f44;
  font-size: 1.1rem;
}
#servicePlanRegisterModal .modal-body {
  padding: 1.25rem;
}
#servicePlanRegisterModal .form-label {
  font-weight: 600;
  font-size: 0.85rem;
  color: #0a1f44;
  margin-bottom: 0.35rem;
}
#servicePlanRegisterModal .form-control {
  border-radius: 8px;
  border-color: rgba(10, 31, 68, 0.12);
}
#servicePlanRegisterModal .form-control:focus {
  border-color: #0d47a1;
  box-shadow: 0 0 0 0.2rem rgba(13, 71, 161, 0.12);
}
#servicePlanRegisterModal .register-form-msg {
  font-size: 0.875rem;
  border-radius: 8px;
  padding: 0.65rem 0.85rem;
  margin-bottom: 0.75rem;
  display: none;
}
#servicePlanRegisterModal .register-form-msg.is-error {
  display: block;
  background: #fff5f5;
  color: #c92a2a;
  border: 1px solid #ffc9c9;
}
#servicePlanRegisterModal .register-form-msg.is-success {
  display: block;
  background: #ebfbee;
  color: #2b8a3e;
  border: 1px solid #b2f2bb;
}
.service-linked-products {
  background: #fff;
  /* Cho sticky hoạt động ổn định trong section */
  overflow: visible;
}
.service-linked-products .row {
  align-items: stretch;
}
.slp-sidebar {
  --slp-sticky-top: 100px;
  background: #fff;
  border: 1px solid rgba(10, 31, 68, 0.08);
  border-radius: 12px;
  padding: 12px 14px;
  box-shadow: 0 4px 20px rgba(10, 31, 68, 0.06);
  position: -webkit-sticky;
  position: sticky;
  top: var(--slp-sticky-top);
  width: 100%;
  max-height: calc(100vh - var(--slp-sticky-top) - 16px);
  overflow-y: auto;
  -webkit-overflow-scrolling: touch;
  z-index: 2;
}
.slp-sidebar-group + .slp-sidebar-group {
  margin-top: 1rem;
  padding-top: 1rem;
  border-top: 1px dashed rgba(10, 31, 68, 0.1);
}
.slp-sidebar-group-title {
  font-weight: 700;
  font-size: 0.85rem;
  color: #0a1f44;
  margin-bottom: 0.5rem;
  text-transform: uppercase;
  letter-spacing: 0.04em;
}
.slp-sidebar-list {
  list-style: none;
  margin: 0;
  padding: 0;
}
.slp-sidebar-link {
  display: block;
  width: 100%;
  text-align: left;
  border: none;
  background: transparent;
  padding: 0.45rem 0.6rem;
  margin-bottom: 4px;
  border-radius: 8px;
  font-size: 0.9rem;
  color: #334155;
  cursor: pointer;
  transition: background 0.2s, color 0.2s;
}
.slp-sidebar-link:hover {
  background: #eef2f8;
  color: #0d47a1;
}
.slp-sidebar-link.is-active {
  background: linear-gradient(135deg, rgba(13, 71, 161, 0.12), rgba(254, 209, 1, 0.15));
  color: #0a1f44;
  font-weight: 600;
}
@media (max-width: 991.98px) {
  .slp-sidebar {
    position: relative;
    top: 0;
    max-height: none;
    overflow-y: visible;
    margin-bottom: 1.5rem;
  }
}
.service-integrated-posts .blog-card.style2 {
  height: 100%;
}
.service-integrated-posts .blog-card.style2 .blog-img img {
  width: 100%;
  height: 220px;
  object-fit: cover;
}
.service-integrated-posts .blog-excerpt {
  font-size: 0.9rem;
  color: #5a6a85;
  line-height: 1.55;
  margin: 0 0 0.75rem;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
@endsection
@section('js')
<script>
(function ($) {
  var registerUrl = @json(route('postServicePlanRegister'));
  var csrf = $('meta[name="csrf-token"]').attr('content');
  var $form = $('#servicePlanRegisterForm');
  var $msg = $('#servicePlanRegisterMsg');

  $(document).on('click', '.service-pricing-register-btn', function () {
    var title = $(this).attr('data-plan-title') || '';
    $('#plan_register_plan_title').val(title);
    $msg.removeClass('is-error is-success').text('').hide();
    $form.find('button[type="submit"]').prop('disabled', false);
    var el = document.getElementById('servicePlanRegisterModal');
    if (el && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
      var m = bootstrap.Modal.getInstance(el);
      if (!m) m = new bootstrap.Modal(el);
      m.show();
    }
  });

  $form.on('submit', function (e) {
    e.preventDefault();
    $msg.removeClass('is-error is-success').text('').hide();
    var $btn = $form.find('button[type="submit"]').prop('disabled', true);
    $.ajax({
      url: registerUrl,
      method: 'POST',
      dataType: 'json',
      data: $form.serialize(),
      headers: {
        'X-CSRF-TOKEN': csrf,
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      success: function (res) {
        $msg.addClass('is-success').text(res.message || 'Đăng ký thành công.').show();
        $form[0].reset();
        setTimeout(function () {
          var modalEl = document.getElementById('servicePlanRegisterModal');
          if (modalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            var inst = bootstrap.Modal.getInstance(modalEl);
            if (inst) inst.hide();
          }
        }, 1600);
      },
      error: function (xhr) {
        $btn.prop('disabled', false);
        var text = 'Không gửi được. Vui lòng thử lại.';
        if (xhr.responseJSON) {
          if (xhr.responseJSON.message) text = xhr.responseJSON.message;
          if (xhr.responseJSON.errors) {
            var parts = [];
            $.each(xhr.responseJSON.errors, function (k, v) {
              if (v && v[0]) parts.push(v[0]);
            });
            if (parts.length) text = parts.join(' ');
          }
        }
        $msg.addClass('is-error').text(text).show();
      },
      complete: function () {
        $btn.prop('disabled', false);
      }
    });
  });
})(jQuery);
</script>
<script>
(function () {
  var grid = document.getElementById('linkedProductsGrid');
  if (!grid) return;

  var productsUrl = @json(route('serviceLinkedProductsJson', ['slug' => $cateService->slug]));
  var basePath = @json(rtrim(url('/'), '/'));
  var $ = window.jQuery;
  var $grid = $(grid);
  var $load = $('#linkedProductsLoading');
  var $empty = $('#linkedProductsEmpty');
  var $pager = $('#linkedProductsPager');
  var $toolbar = $('#linkedProductsToolbar');
  var currentPage = 1;
  var lastState = { type_cate: null, type_two: null };

  function buildProductUrl(item) {
    var t = item.type_slug && item.type_slug.length ? item.type_slug : 'loai';
    return basePath + '/chi-tiet/' + encodeURIComponent(item.cate_slug) + '/' + encodeURIComponent(t) + '/' + encodeURIComponent(item.slug) + '.html';
  }

  function imgUrl(src) {
    if (!src) return '/frontend/img/product/product_1_1.jpg';
    if (src.indexOf('http') === 0) return src;
    return basePath + '/' + String(src).replace(/^\/+/, '');
  }

  function renderProducts(items) {
    $grid.empty();
    if (!items || !items.length) {
      $empty.show();
      return;
    }
    $empty.hide();
    items.forEach(function (item) {
      var url = buildProductUrl(item);
      var price = Math.round(item.discount || item.price || 0);
      var oldPrice = Math.round(item.price || 0);
      var showDel = oldPrice > 0 && price > 0 && price < oldPrice;
      var html =
        '<div class="col-md-6 col-xl-4">' +
        '<div class="themeholy-product product-grid">' +
        '<div class="product-img">' +
        '<a href="' + url + '"><img src="' + imgUrl(item.thumb) + '" alt="" loading="lazy"></a>' +
        '</div>' +
        '<div class="product-content">' +
        '<h3 class="product-title"><a href="' + url + '">' + $('<div/>').text(item.name || '').html() + '</a></h3>' +
        '<span class="price">' + price.toLocaleString('vi-VN') + '₫' +
        (showDel ? ' <del>' + oldPrice.toLocaleString('vi-VN') + '₫</del>' : '') +
        '</span>' +
        '</div></div></div>';
      $grid.append(html);
    });
  }

  function loadPage(page) {
    if (!lastState.type_cate) return;
    currentPage = page || 1;
    var qs =
      '?type_cate=' +
      encodeURIComponent(lastState.type_cate) +
      (lastState.type_two !== null && lastState.type_two !== ''
        ? '&type_two=' + encodeURIComponent(lastState.type_two)
        : '') +
      '&page=' +
      encodeURIComponent(currentPage);
    $load.show();
    $empty.hide();
    fetch(productsUrl + qs, { credentials: 'same-origin', headers: { Accept: 'application/json' } })
      .then(function (r) {
        return r.json().then(function (j) {
          if (!r.ok) throw new Error(j.message || 'Lỗi tải dữ liệu');
          return j;
        });
      })
      .then(function (data) {
        $load.hide();
        renderProducts(data.data || []);
        var total = data.total || 0;
        var last = data.last_page || 1;
        var cur = data.current_page || 1;
        $toolbar.text(total ? 'Hiển thị ' + total + ' sản phẩm' : '');
        $pager.empty();
        if (last > 1) {
          $pager.show();
          var prev = document.createElement('button');
          prev.type = 'button';
          prev.className = 'btn btn-sm btn-outline-secondary';
          prev.textContent = '← Trước';
          prev.disabled = cur <= 1;
          prev.addEventListener('click', function () {
            loadPage(cur - 1);
          });
          var next = document.createElement('button');
          next.type = 'button';
          next.className = 'btn btn-sm btn-outline-secondary';
          next.textContent = 'Sau →';
          next.disabled = cur >= last;
          next.addEventListener('click', function () {
            loadPage(cur + 1);
          });
          var span = document.createElement('span');
          span.className = 'small text-muted mx-2';
          span.textContent = 'Trang ' + cur + ' / ' + last;
          $pager.append(prev, span, next);
        } else {
          $pager.hide();
        }
      })
      .catch(function () {
        $load.hide();
        $grid.empty();
        $empty.text('Không tải được danh sách.').show();
      });
  }

  $(document).on('click', '.slp-sidebar-link', function () {
    var $btn = $(this);
    $('.slp-sidebar-link').removeClass('is-active');
    $btn.addClass('is-active');
    lastState.type_cate = parseInt($btn.attr('data-type-cate'), 10);
    var ttRaw = $btn.attr('data-type-two');
    lastState.type_two = ttRaw === '' || ttRaw === undefined ? null : parseInt(ttRaw, 10);
    loadPage(1);
  });

  var $first = $('.slp-sidebar-link').first();
  if ($first.length) {
    $first.trigger('click');
  }
})();
</script>
@endsection
@section('content')
<div class="breadcumb-wrapper breadcumb-wrapper--overlay" data-bg-src="{{url(''.$cateService->image)}}">
    <div class="container">
       <div class="breadcumb-content">
          <h1 class="breadcumb-title">{{$cateService->name}}</h1>
          <div class="breadcumb-menu-wrapper">
             <ul class="breadcumb-menu">
                <li><a href="{{route('home')}}">Home</a></li>
                <li><a href="{{route('serviceList',['slug'=>$cateService->slug])}}">Dịch vụ</a></li>
                <li>{{$cateService->name}}</li>
             </ul>
          </div>
       </div>
    </div>
 </div>
 <section class="space-top space-extra-bottom">
    <div class="container">
       <div class="row flex-row-reverse">
          <div class="col-xxl-12 col-lg-12">
             <div class="page-single service-single">
                <div class="page-content">
                   <h2 class="h4">Giới thiệu về {{languageName($cateService->name)}}</h2>
                   {!!languageName($cateService->content)!!}
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>
 @php
    $pricingPlans = $cateService->pricing_plans ?? [];
    if (!is_array($pricingPlans)) {
        $pricingPlans = [];
    }
 @endphp
 @if(count($pricingPlans))
 <section class="service-pricing-wrap space-top space-extra-bottom">
    <div class="service-pricing-bg" aria-hidden="true"></div>
    <div class="container position-relative">
       <div class="title-area text-center mb-40">
          <span class="sub-title">
             <img src="/frontend/img/title_left.svg" alt="" width="24" height="12"> Gói dịch vụ
          </span>
          <h2 class="sec-title">Bảng giá &amp; tính năng</h2>
          <p class="sec-text">Các gói kết nối linh hoạt — phù hợp doanh nghiệp và hạ tầng viễn thông. Liên hệ để được tư vấn cấu hình tối ưu.</p>
       </div>
       <div class="row justify-content-center gy-4 gx-xl-4">
          @foreach($pricingPlans as $plan)
          <div class="col-xl-4 col-lg-6">
             <div class="service-pricing-card">
                <div class="service-pricing-card__accent" aria-hidden="true"></div>
                <div class="service-pricing-card__head">
                   <div class="service-pricing-card__title">{{ languageName($plan['title'] ?? '') }}</div>
                   <div class="service-pricing-card__price">
                      @if(!empty($plan['price']))
                         {{ $plan['price'] }}đ
                         @if(!empty($plan['unit']))
                            <span class="service-pricing-card__price-unit">theo {{ $plan['unit'] }}</span>
                         @endif
                      @else
                         <span class="service-pricing-card__dash">Liên hệ</span>
                      @endif
                   </div>
                </div>
                <div class="service-pricing-card__body">
                   @foreach($plan['features'] ?? [] as $feat)
                      @if(!empty($feat['label']))
                      <div class="service-pricing-card__row">
                         <div class="service-pricing-card__cell service-pricing-card__label">{{ languageName($feat['label']) }}</div>
                         <div class="service-pricing-card__cell service-pricing-card__val">
                            @if(($feat['type'] ?? 'text') === 'boolean')
                               @if(!empty($feat['value']))
                                  <span class="service-pricing-card__check-wrap" title="Có trong gói">
                                     <i class="fa-solid fa-check service-pricing-card__check" aria-hidden="true"></i>
                                  </span>
                               @else
                                  <span class="service-pricing-card__dash" aria-hidden="true">—</span>
                               @endif
                            @else
                               {{ languageName($feat['value'] ?? '') }}
                            @endif
                         </div>
                      </div>
                      @endif
                   @endforeach
                </div>
                @php
                  $planTitleBtn = trim((string) languageName($plan['title'] ?? ''));
                  if ($planTitleBtn === '') {
                    $planTitleBtn = 'Gói dịch vụ';
                  }
                @endphp
                <div class="service-pricing-card__footer">
                   <button type="button" class="themeholy-btn blue-btn w-100 service-pricing-register-btn" data-plan-title="{{ htmlspecialchars($planTitleBtn, ENT_QUOTES, 'UTF-8') }}">
                      Đăng ký ngay
                      <span class="icon"><i class="fa-sharp fa-regular fa-paper-plane"></i></span>
                   </button>
                </div>
             </div>
          </div>
          @endforeach
       </div>

       <div class="modal fade" id="servicePlanRegisterModal" tabindex="-1" aria-labelledby="servicePlanRegisterModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="servicePlanRegisterModalLabel">Đăng ký gói dịch vụ</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                   <div id="servicePlanRegisterMsg" class="register-form-msg" role="alert"></div>
                   <form id="servicePlanRegisterForm" method="post" action="{{ route('postServicePlanRegister') }}" novalidate>
                      @csrf
                      <input type="hidden" name="service_category_id" id="plan_register_service_category_id" value="{{ (int) $cateService->id }}">
                      <input type="hidden" name="plan_title" id="plan_register_plan_title" value="">
                      <div class="row g-3">
                         <div class="col-md-6">
                            <label class="form-label" for="plan_register_full_name">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="full_name" id="plan_register_full_name" required maxlength="255" autocomplete="name">
                         </div>
                         <div class="col-md-6">
                            <label class="form-label" for="plan_register_phone">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="phone" id="plan_register_phone" required maxlength="50" autocomplete="tel">
                         </div>
                         <div class="col-12">
                            <label class="form-label" for="plan_register_email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="plan_register_email" required maxlength="255" autocomplete="email">
                         </div>
                         <div class="col-12">
                            <label class="form-label" for="plan_register_address">Địa chỉ</label>
                            <input type="text" class="form-control" name="address" id="plan_register_address" required maxlength="255" autocomplete="street-address">
                         </div>
                      </div>
                      <div class="d-flex justify-content-end align-items-center mt-4 pt-2 border-top">
                         <button type="submit" class="themeholy-btn blue-btn ms-2">Gửi đăng ký</button>
                      </div>
                   </form>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>
 @endif

 @php
    $linkedSidebar = isset($linked_product_sidebar) && is_array($linked_product_sidebar) ? $linked_product_sidebar : [];
 @endphp
 @if(count($linkedSidebar))
 <section class="service-linked-products space-top space-extra-bottom">
    <div class="container">
       <div class="title-area text-center mb-40">
          <span class="sub-title">
             <img src="/frontend/img/title_left.svg" alt="" width="24" height="12"> Sản phẩm liên quan
          </span>
          <h2 class="sec-title">Thiết bị &amp; giải pháp</h2>
          <p class="sec-text">Chọn nhóm danh mục bên trái để xem sản phẩm phù hợp với dịch vụ.</p>
       </div>
       <div class="row">
          <div class="col-lg-3 mb-4 mb-lg-0">
             <aside class="slp-sidebar" aria-label="Danh mục sản phẩm">
                @foreach($linkedSidebar as $grp)
                <div class="slp-sidebar-group">
                   <div class="slp-sidebar-group-title">{{ $grp['name'] }}</div>
                   <ul class="slp-sidebar-list">
                      @foreach($grp['children'] as $ch)
                      <li>
                         <button type="button" class="slp-sidebar-link"
                            data-type-cate="{{ (int) $grp['type_cate_id'] }}"
                            data-type-two="{{ $ch['id'] === null ? '' : (int) $ch['id'] }}"
                         >{{ $ch['name'] }}</button>
                      </li>
                      @endforeach
                   </ul>
                </div>
                @endforeach
             </aside>
          </div>
          <div class="col-lg-9">
             <div id="linkedProductsWrap">
                <div id="linkedProductsToolbar" class="small text-muted mb-3"></div>
                <div id="linkedProductsLoading" class="text-center py-5 text-muted" style="display:none;">Đang tải…</div>
                <div id="linkedProductsEmpty" class="text-center py-5 text-muted" style="display:none;">Không có sản phẩm trong nhóm này.</div>
                <div id="linkedProductsGrid" class="row g-3"></div>
                <nav id="linkedProductsPager" class="d-flex justify-content-center align-items-center flex-wrap gap-2 mt-4" style="display:none;" aria-label="Phân trang"></nav>
             </div>
          </div>
       </div>
    </div>
 </section>
 @endif

 @php
    $integratedPosts = isset($serviceIntegratedPosts) ? $serviceIntegratedPosts : collect();
 @endphp
 @if($integratedPosts->count())
 <section class="service-integrated-posts space-top space-extra-bottom">
    <div class="container">
       <div class="title-area text-center mb-40">
          <span class="sub-title">
             <img src="/frontend/img/title_left.svg" alt="" width="24" height="12"> Bài viết tích hợp
          </span>
          <h2 class="sec-title">Tích hợp</h2>
       </div>
       <div class="row gy-4">
          @foreach($integratedPosts as $post)
          @php
             $postTitle = languageName($post->name);
             $postDescRaw = languageName($post->description);
             $postExcerpt = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/u', ' ', strip_tags((string) $postDescRaw))), 160);
             $postUrl = route('serviceDetail', ['danhmuc' => $post->cate_slug, 'slug' => $post->slug]);
             $postImg = $post->image ? url(ltrim($post->image, '/')) : '/frontend/img/blog/blog_1_1.jpg';
          @endphp
          <div class="col-md-6 col-xl-4">
             <div class="blog-card style2">
                <div class="blog-img">
                   <a href="{{ $postUrl }}">
                      <img src="{{ $postImg }}" alt="{{ $postTitle }}" loading="lazy" decoding="async">
                   </a>
                   @if($post->created_at)
                   <div class="blog-card_wrapper">
                      <span class="blog-card_date">{{ $post->created_at->format('d') }}</span>
                      <span class="blog-card_month">{{ $post->created_at->format('M') }}</span>
                   </div>
                   @endif
                </div>
                <div class="blog-card-content">
                   <h3 class="box-title">
                      <a href="{{ $postUrl }}">{{ $postTitle }}</a>
                   </h3>
                   @if($postExcerpt !== '')
                   <p class="blog-excerpt">{{ $postExcerpt }}</p>
                   @endif
                   <a href="{{ $postUrl }}" class="half-line-btn">
                      Xem chi tiết<i class="fa-solid fa-arrow-right ms-2"></i>
                   </a>
                </div>
             </div>
          </div>
          @endforeach
       </div>
    </div>
 </section>
 @endif
@endsection