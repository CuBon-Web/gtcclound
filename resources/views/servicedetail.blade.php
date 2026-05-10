@extends('layouts.main.master')
@section('title')
{{($detail_service->name)}}
@endsection
@section('description')
{{($detail_service->description)}}
@endsection
@section('image')
{{url(''.$detail_service->image)}}
@endsection
@section('css')

@endsection
@section('js')
@endsection
@section('content')
<div class="breadcumb-wrapper breadcumb-wrapper--overlay" data-bg-src="{{url(''.$detail_service->image)}}">
    <div class="container">
       <div class="breadcumb-content">
          <h1 class="breadcumb-title">{{($detail_service->name)}}</h1>
          <div class="breadcumb-menu-wrapper">
             <ul class="breadcumb-menu">
                <li><a href="{{route('home')}}">Home</a></li>
                <li><a href="{{route('serviceList',['slug'=>$detail_service->cate_slug])}}">Dịch vụ</a></li>
                <li>{{($detail_service->name)}}</li>
             </ul>
          </div>
       </div>
    </div>
 </div>

 <section class="space-top space-extra-bottom">
	<div class="container">
	   <div class="row flex-row-reverse">
		  <div class="col-xxl-8 col-lg-8">
			 <div class="page-single service-single">
				{!!languageName($detail_service->content)!!}
			 </div>
		  </div>
		  <div class="col-xxl-4 col-lg-4">
			 <aside class="sidebar-area">
				<div class="widget widget_categories">
				   <h3 class="widget_title">Danh mục dịch vụ<span class="shape"></span></h3>
				   <ul>
					@foreach ($servicehome as $item)
					<li><a href="{{route('serviceList',['slug'=>$item->slug])}}">{{languageName($item->name)}}</a></li>
					@endforeach
				   </ul>
				</div>
				<form action="{{route('postServicePlanRegister')}}" method="POST" class="service-form style2">
					@csrf
				   <input type="hidden" name="service_category_id" value="{{ (int) $detail_service->cate_id }}">
				   <input type="hidden" name="plan_title" value="{{ $detail_service->name }}">
				   <h3 class="fs-24 mb-20 mt-n1 text-black">Yêu cầu báo giá</h3>
				   @if(session('success'))
				   <div class="alert alert-success mb-3" role="alert">{{ session('success') }}</div>
				   @endif
				   <div class="row">
					  <div class="form-group col-12"><input type="text" class="form-control" name="full_name" id="full_name" placeholder="Họ và tên" required> <i class="fal fa-user"></i></div>
					  <div class="form-group col-12"><input type="email" class="form-control" name="email" id="email" placeholder="Email" required> <i class="fal fa-envelope"></i></div>
					  <div class="form-group col-12"><input type="text" class="form-control" name="phone" id="phone" placeholder="Điện thoại" required> <i class="fa-solid fa-phone"></i></div>
					  <div class="form-group col-12"><textarea class="form-control" name="address" id="address" placeholder="Địa chỉ" required></textarea> <i class="fa-solid fa-location-dot"></i></div>
					  <div class="btn-group justify-content-center"><button type="submit" class="themeholy-btn blue-btn2 btn-fw justify-content-center">Gửi yêu cầu<span class="icon"><i class="fa-sharp fa-regular fa-paper-plane"></i></span></button></div>
				   </div>
				   <p class="form-messages mb-0 mt-3"></p>
				</form>
			 </aside>
		  </div>
	   </div>
	</div>
 </section>

@endsection