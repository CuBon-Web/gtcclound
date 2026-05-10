@extends('layouts.main.master')
@section('title')
    Liên hệ với chúng tôi
@endsection
@section('description')
    Liên hệ với chúng tôi
@endsection
@section('image')
    {{ url('' . $setting->logo) }}
@endsection
@section('css')
@endsection
@section('js')
@endsection
@section('content')
    <!-- Start Breadcrumb Section -->
    <div class="breadcumb-wrapper breadcumb-wrapper--overlay" data-bg-src="{{url(''.$banner[0]->image)}}">
        <div class="container">
           <div class="breadcumb-content">
              <h1 class="breadcumb-title">Liên hệ với chúng tôi</h1>
              <div class="breadcumb-menu-wrapper">
                 <ul class="breadcumb-menu">
                    <li><a href="{{route('home')}}">Home</a></li>
                    <li>Liên hệ với chúng tôi</li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
    @php
       $phoneValue = $setting->hotline ?? $setting->phone1 ?? '';
       $phoneDigits = preg_replace('/\D+/', '', (string) $phoneValue);
       $facebook = $setting->facebook ?? null;
       $youtube = $setting->youtube ?? null;
       $instagram = $setting->instagram ?? null;
       $linkedin = $setting->linkedin ?? null;
    @endphp
    <div class="space" id="contact-sec">
        <div class="container">
           <div class="row gy-40 flex-row-reverse">
              <div class="col-xl-8">
                 <div class="contact-form-wrapper">
                    <form action="{{ route('postcontact') }}" method="POST" class="contact-form">
                       @csrf
                       <h2 class="form-title">Gửi liên hệ <span class="shape"></span></h2>
                       @if(session('success'))
                          <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                       @endif
                       @if(session('error'))
                          <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                       @endif
                       <div class="row">
                          <div class="form-group col-md-6"><input type="text" class="form-control" name="name" id="name" placeholder="Họ và tên" required> <i class="fal fa-user"></i></div>
                          <div class="form-group col-md-6"><input type="email" class="form-control" name="email" id="email" placeholder="Email" required> <i class="fal fa-envelope"></i></div>
                          <div class="form-group col-md-12"><input type="tel" class="form-control" name="phone" id="phone" placeholder="Số điện thoại" required> <i class="fa-regular fa-phone-flip"></i></div>
                         <div class="form-group col-12"><textarea name="mess" id="mess" cols="30" rows="4" class="form-control" placeholder="Nội dung liên hệ" required></textarea> <i class="fal fa-comment"></i></div>
                          <div class="btn-group style2"><button type="submit" class="themeholy-btn">Gửi liên hệ<span class="icon"><i class="fa-sharp fa-regular fa-paper-plane"></i></span></button></div>
                       </div>
                    </form>
                 </div>
              </div>
              <div class="col-xl-4">
                 <div class="contact-info-wrap">
                    <div class="title-area">
                       <span class="sub-title"><img src="/frontend/img/title_left.svg" alt="shape">Liên hệ</span>
                       <h2 class="sec-title mb-0">Kết nối với chúng tôi</h2>
                    </div>
                    <div class="contact-info">
                       <div class="contact-info_icon"><i class=""><img src="/frontend/img/location_5.svg" alt=""></i></div>
                       <div class="media-body">
                          <h4 class="contact-info_title">Địa chỉ văn phòng</h4>
                          <span class="contact-info_text">{{ $setting->address1 ?? 'Đang cập nhật' }}</span>
                       </div>
                    </div>
                    <div class="contact-info">
                       <div class="contact-info_icon"><i class=""><img src="/frontend/img/phone.svg" alt=""></i></div>
                       <div class="media-body">
                          <h4 class="contact-info_title">Số điện thoại</h4>
                          <span class="contact-info_text"><a href="tel:{{ $phoneDigits ?: $phoneValue }}">{{ $phoneValue ?: 'Đang cập nhật' }}</a></span>
                       </div>
                    </div>
                    <div class="contact-info">
                       <div class="contact-info_icon"><i class=""><img src="/frontend/img/email.svg" alt=""></i></div>
                       <div class="media-body">
                          <h4 class="contact-info_title">Email</h4>
                          <span class="contact-info_text"><a href="mailto:{{ $setting->email }}">{{ $setting->email ?? 'Đang cập nhật' }}</a></span>
                       </div>
                    </div>
                    
                 </div>
              </div>
           </div>
        </div>
     </div>
     <div class="map-sec">
        {!!($setting->iframe_map)!!}
     </div>
     
@endsection
