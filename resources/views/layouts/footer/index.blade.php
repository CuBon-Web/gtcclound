<footer class="footer-wrapper footer-layout1 cta-sec">
    <div class="widget-area">
       <div class="container">
          <div class="row justify-content-between">
             <div class="col-md-6 col-xxl-3 col-xl-4">
                <div class="widget footer-widget">
                   <div class="themeholy-widget-about">
                      <div class="about-logo"><a href="{{route('home')}}"><img src="{{$setting->logo}}" alt="GTC Cloud" loading="lazy" decoding="async"></a></div>
                      <p class="about-text">{{$setting->webname}}</p>
                      <div class="themeholy-social"><a href="{{$setting->facebook}}"><i class="fab fa-facebook-f"></i></a> <a href="{{$setting->twitter}}"><i class="fab fa-twitter"></i></a> <a href="{{$setting->linkedin}}"><i class="fab fa-linkedin-in"></i></a> <a href="{{$setting->behance}}"><i class="fa-brands fa-behance"></i></a></div>
                   </div>
                </div>
             </div>
             <div class="col-md-6 col-xl-auto">
                <div class="widget footer-widget">
                   <h3 class="widget_title">Liên hệ</h3>
                   <div class="themeholy-widget-contact">
                      <div class="info-box">
                         <p class="info-box_text">{{$setting->address1}}</p>
                      </div>
                      <div class="info-box">
                         <p class="info-box_text">T2-T7 : 09.00 am-06.00 pm</p>
                      </div>
                      <div class="info-box">
                         <p class="info-box_text"><a href="tel:{{$setting->phone1}}" class="info-box_link">{{$setting->phone1}}</a></p>
                      </div>
                      <div class="info-box">
                         <p class="info-box_text"><a href="mailto:{{$setting->email}}" class="info-box_link">{{$setting->email}}</a></p>
                      </div>
                   </div>
                </div>
             </div>
             <div class="col-md-6 col-xl-auto">
                <div class="widget widget_nav_menu footer-widget">
                   <h3 class="widget_title">Chính sách và điều khoản</h3>
                   <div class="menu-all-pages-container">
                      <ul class="menu">
                        @foreach ($pageContent as $item)
                        @if ($item->type == 'ho-tro-khanh-hang')
                        <li><a href="{{route('pagecontent',['slug'=>$item->slug])}}">{{($item->title)}}</a></li>
                        @endif
                        
                        @endforeach
                      </ul>
                   </div>
                </div>
             </div>
             <div class="col-md-6 col-xl-3">
                <div class="widget footer-widget">
                   <h3 class="widget_title">Vị trí</h3>
                   {!!$setting->iframe_map!!}
                </div>
             </div>
          </div>
       </div>
    </div>
    <div class="copyright-wrap">
       <div class="container">
          <div class="row justify-content-between">
             <div class="col-lg-12">
                <p class="copyright-text"><i class="fal fa-copyright"></i> 2023 All Rights Reserved By <a href="#">TUẤN ANH DEV.</a></p>
             </div>
          </div>
       </div>
    </div>
 </footer>