@extends('layouts.main.master')
@section('title')
Về Chúng Tôi
@endsection
@section('description')
{{$setting->company}}
@endsection
@section('css')
@endsection
@section('js')
@endsection
@section('content')
<div class="breadcumb-wrapper breadcumb-wrapper--overlay" data-bg-src="{{url(''.$banner[0]->image)}}">
    <div class="container">
       <div class="breadcumb-content">
          <h1 class="breadcumb-title">Về Chúng Tôi</h1>
          <div class="breadcumb-menu-wrapper">
             <ul class="breadcumb-menu">
                <li><a href="{{route('home')}}">Home</a></li>
                <li>Về Chúng Tôi</li>
             </ul>
          </div>
       </div>
    </div>
 </div>
 <section class="themeholy-blog-wrapper blog-details space-top space-extra-bottom">
    <div class="container">
       <div class="row">
          <div class="col-xxl-12 col-lg-12">
             <div class="themeholy-blog blog-single has-post-thumbnail">
                <div class="blog-content">
                   {!! languageName($gioithieu->content) !!}
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>





@endsection