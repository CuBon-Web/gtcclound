@extends('layouts.main.master')
@section('title')
{{$title}}
@endsection
@section('description')
Danh sách {{$title}}
@endsection
@section('image')
{{url(''.$banner[0]->image)}}
@endsection
@section('js')

@endsection
@section('css')
<style>
.widget_categories .product-cat-level2,
.widget_categories .product-cat-level3 {
   list-style: none;
   margin: 8px 0 0;
}
.widget_categories .product-cat-level2 {
   padding-left: 14px;
   border-left: 2px solid rgba(13, 71, 161, 0.18);
}
.widget_categories .product-cat-level2 > li {
   margin-bottom: 6px;
}
.widget_categories .product-cat-level2 > li > a {
   display: inline-block;
   font-size: 0.93em;
   font-weight: 600;
   color: #0d47a1;
}
.widget_categories .product-cat-level3 {
   padding-left: 18px;
   margin-top: 4px;
}
.widget_categories .product-cat-level3 > li {
   margin-bottom: 4px;
   position: relative;
}
.widget_categories .product-cat-level3 > li::before {
   content: "•";
   position: absolute;
   left: -11px;
   top: 1px;
   color: #94a3b8;
   font-size: 0.8em;
}
.widget_categories .product-cat-level3 > li > a {
   display: inline-block;
   font-size: 0.86em;
   font-weight: 400;
   color: #475569;
}
.widget_categories > ul > li > a {
   transition: color .2s ease;
}
.widget_categories > ul > li > a:hover,
.widget_categories > ul > li.is-active > a {
   color: #0a1f44;
}
.widget_categories .product-cat-level2 > li > a {
   transition: color .2s ease, background-color .2s ease;
   border-radius: 6px;
   padding: 2px 6px;
}
.widget_categories .product-cat-level2 > li > a:hover,
.widget_categories .product-cat-level2 > li.is-active > a {
   color: #0b3d91;
   background: rgba(13, 71, 161, 0.12);
}
.widget_categories .product-cat-level3 > li > a {
   transition: color .2s ease;
}
.widget_categories .product-cat-level3 > li > a:hover,
.widget_categories .product-cat-level3 > li.is-active > a {
   color: #0f766e;
}
.widget_categories .product-cat-level3 > li:hover::before,
.widget_categories .product-cat-level3 > li.is-active::before {
   color: #0f766e;
}
.sidebar-shop {
   position: sticky;
   top: 100px;
   max-height: calc(100vh - 116px);
   overflow-y: auto;
   padding-right: 4px;
}
@media (max-width: 991.98px) {
   .sidebar-shop {
      position: relative;
      top: 0;
      max-height: none;
      overflow: visible;
      padding-right: 0;
   }
}
</style>
@endsection
@section('content')
<div class="breadcumb-wrapper breadcumb-wrapper--overlay" data-bg-src="{{url(''.$banner[0]->image)}}">
    <div class="container">
       <div class="breadcumb-content">
          <h1 class="breadcumb-title">{{$title}}</h1>
          <div class="breadcumb-menu-wrapper">
             <ul class="breadcumb-menu">
                <li><a href="{{route('home')}}">Home</a></li>
                <li><a href="{{route('allProduct')}}">Sản phẩm</a></li>
                <li>{{$title}}</li>
             </ul>
          </div>
       </div>
    </div>
 </div>
 <section class="space-top space-extra-bottom">
    <div class="container">
       <div class="row flex-row-reverse">
          <div class="col-xl-9 col-lg-8">
             <div class="row gy-40">
                @foreach ($list as $item)
                <div class="col-xl-4 col-sm-6">
                    @include('layouts.product.item',['pro'=>$item])
                 </div>
                @endforeach
                
             </div>
             <div class="themeholy-pagination text-center pt-50">
                {{$list->links()}}
             </div>
          </div>
          <div class="col-xl-3 col-lg-4">
             <aside class="sidebar-area sidebar-shop">
                <div class="widget widget_categories">
                   <h3 class="widget_title">Danh mục sản phẩm<span class="shape"></span></h3>
                   <ul>
                      @php
                        $currentCateSlug = $cate_slug ?? '';
                        $currentTypeSlug = $type_slug ?? '';
                        $currentTypeTwoSlug = $type_two_slug ?? '';
                      @endphp
                      @foreach(($productCategoryTree ?? []) as $cate)
                        <li class="{{ $currentCateSlug === ($cate['slug'] ?? '') ? 'is-active' : '' }}">
                          <a href="{{ route('allListProCate', ['danhmuc' => $cate['slug']]) }}">
                            {{ $cate['name'] }}
                          </a>
                          <span>({{ $cate['count'] }})</span>
                          @if(!empty($cate['children']))
                            <ul class="product-cat-level2">
                              @foreach($cate['children'] as $type)
                                <li class="{{ $currentTypeSlug === ($type['slug'] ?? '') ? 'is-active' : '' }}">
                                  <a href="{{ route('allListType', ['danhmuc' => $cate['slug'], 'loaidanhmuc' => $type['slug']]) }}">
                                    {{ $type['name'] }}
                                  </a>
                                  <span>({{ $type['count'] }})</span>
                                  @if(!empty($type['children']))
                                    <ul class="product-cat-level3">
                                      @foreach($type['children'] as $typeTwo)
                                        <li class="{{ $currentTypeTwoSlug === ($typeTwo['slug'] ?? '') ? 'is-active' : '' }}">
                                          <a href="{{ route('allListTypeTwo', ['danhmuc' => $cate['slug'], 'loaidanhmuc' => $type['slug'], 'loai2' => $typeTwo['slug']]) }}">
                                            {{ $typeTwo['name'] }}
                                          </a>
                                          <span>({{ $typeTwo['count'] }})</span>
                                        </li>
                                      @endforeach
                                    </ul>
                                  @endif
                                </li>
                              @endforeach
                            </ul>
                          @endif
                        </li>
                      @endforeach
                   </ul>
                </div>
             </aside>
          </div>
       </div>
    </div>
 </section>
   
@endsection