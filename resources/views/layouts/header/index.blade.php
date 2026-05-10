<div class="popup-search-box d-none d-lg-block">
    <button class="searchClose"><i class="fal fa-times"></i></button>
    <form action="#"><input type="text" placeholder="What are you looking for?"> <button type="submit"><i class="fal fa-search"></i></button></form>
 </div>
 <div class="themeholy-menu-wrapper">
    <div class="themeholy-menu-area text-center">
       <button class="themeholy-menu-toggle"><i class="fal fa-times"></i></button>
                   <div class="mobile-logo"><a href="{{route('home')}}"><img width="180" height="54" src="{{$setting->logo}}" alt="GTC Cloud" decoding="async"></a></div>
       <div class="themeholy-mobile-menu">
          <ul>
             <li>
                <a href="{{route('home')}}">Trang chủ</a>
             </li>
             <li><a href="{{route('aboutUs')}}">Giới thiệu</a></li>
             <li class="menu-item-has-children">
                <a href="#">Dịch vụ</a>
                <ul class="sub-menu">
                    @foreach ($servicehome as $item)
                        <li><a href="{{route('serviceList',['slug'=>$item->slug])}}">{{languageName($item->name)}}</a></li>
                    @endforeach
                </ul>
             </li>
             <li class="menu-item-has-children">
               <a href="#">Sản phẩm</a>
               <ul class="sub-menu">
                   @foreach ($categoryhome as $item)
                       <li><a href="{{route('allListProCate',['danhmuc'=>$item->slug])}}">{{languageName($item->name)}}</a></li>
                   @endforeach
               </ul>
            </li>
             @foreach ($blogCate as $item)
                 
                <li><a href="{{route('listCateBlog',['slug'=>$item->slug])}}">{{languageName($item->name)}}</a></li>
            @endforeach
             <li><a href="{{route('lienHe')}}">Liên hệ</a></li>
          </ul>
       </div>
    </div>
 </div>
 <header class="themeholy-header header-layout2">
    <div class="header-top">
       <div class="container">
          <div class="row justify-content-center justify-content-lg-between align-items-center gy-2">
             <div class="col-auto d-none d-lg-block">
                <div class="header-links">
                   <ul>
                      <li><i class="fa-regular fa-phone"></i><span class="link-title">Phone : </span><a href="tel:{{$setting->phone1}}">{{$setting->phone1}}</a></li>
                      <li><i class="fa-regular fa-envelope"></i><span class="link-title">Email : </span><a href="mailto:{{$setting->email}}">{{$setting->email}}</a></li>
                   </ul>
                </div>
             </div>
          </div>
       </div>
    </div>
    <div class="sticky-wrapper">
       <div class="menu-area">
          <div class="container">
             <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                   <div class="header-logo"><a href="{{route('home')}}"><img width="180" height="54" src="{{$setting->logo}}" alt="GTC Cloud" decoding="async"></a></div>
                </div>
                <div class="col-auto">
                   <nav class="main-menu d-none d-lg-inline-block">
                      <ul>
                         <li>
                            <a href="{{route('home')}}">Trang chủ</a>
                         </li>
                         <li><a href="{{route('aboutUs')}}">Giới thiệu</a></li>
                         <li class="menu-item-has-children">
                            <a href="#">Dịch vụ</a>
                            <ul class="sub-menu">
                                @foreach ($servicehome as $item)
                                    <li><a href="{{route('serviceList',['slug'=>$item->slug])}}">{{languageName($item->name)}}</a></li>
                                @endforeach
                            </ul>
                         </li>
                         <li class="menu-item-has-children">
                           <a href="#">Sản phẩm</a>
                           <ul class="sub-menu">
                               @foreach ($categoryhome as $item)
                                   <li><a href="{{route('allListProCate',['danhmuc'=>$item->slug])}}">{{languageName($item->name)}}</a></li>
                               @endforeach
                           </ul>
                        </li>
                         @foreach ($blogCate as $item)
                            <li><a href="{{route('listCateBlog',['slug'=>$item->slug])}}">{{languageName($item->name)}}</a></li>
                        @endforeach
                         <li><a href="{{route('lienHe')}}">Liên hệ</a></li>
                      </ul>
                   </nav>
                   <button type="button" class="themeholy-menu-toggle d-inline-block d-lg-none"><i class="far fa-bars"></i></button>
                </div>
                <div class="col-auto d-none d-xl-block">
                   <div class="header-button">
                       <button type="button" class="icon-btn searchBoxToggler"><i class="fal fa-search"></i></button> </div>
                </div>
             </div>
          </div>
       </div>
       <div class="logo-bg"></div>
    </div>
    <div class="menu-shape">
       <div class="top-shape" data-bg-src="/frontend/img/header_bg_1.png"></div>
    </div>
 </header>