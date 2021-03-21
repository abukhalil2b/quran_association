<!DOCTYPE html>
<html dir=rtl>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/box-style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css')}}" rel="stylesheet">

</head>
<body>
    <div class="bg-color-ligtorange">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 justify-logo">
                    <div class="logo-container">
                        <img class="logo-img mt-1" src="{{ asset('img/logo1.png') }}" alt="">

                    </div>
                </div>

                 <div class="col-lg-6 justify-top-link">
                    @if(Auth::guard()->check())
                        <a class=""
                            onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();"
                            href="{{route('logout')}}">{{ __('auth.Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        <a class="text-darkorange px-2 mt-2" href="{{route('dashboard')}}"> الرئيسية </a>
                    @else
                        <a class="text-darkorange px-2 mt-2" href="{{route('login')}}">تسجيل الدخول</a>
                        <a class="text-darkorange px-2 mt-2" href="{{route('register')}}">تسجيل جديد</a>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div class="overlay">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-2 center e">
                    <a class="text-white" href="/">عن الجمعية</a>
                </div>
                <div class="col-md-2 center">
                    <a class="text-white" href="/">المدونة </a>
                </div>
                <div class="col-md-2 center">
                    <a class="text-white" href=""> اتصل بنا </a>
                </div>
            </div>

            <div class="row justify-content-center">
                <span class="text-white ">
                    <div class="center text-lg py-1 ">
                        مركز <span class="text-orange">ولاية العامرات </span>
                    </div>
                    
                    <div class="center text-sm py-1 ">
                        الجمعية العمانية  <span class="text-orange mobile-block">للعناية بالقرآن الكريم</span>
                    </div>

                    <div class="center py-2">
                        <span class="text-orange ">سجل </span>  في الدورات القرآنية
                    </div>
                </span>
            </div> <!-- title row -->

            @if(session('status'))
            <div class="row text-lg -container pt-5 ">
                <div class="alert alert-warning">
                    <b>{{session('status')}}</b>
                </div>
            </div> <!-- alert row -->
            @endif
        </div>

    </div>

<div style="min-height:62vh">

    <center><p  class="text-lg py-2 text-darkorange"><span class="underline">{{__('pages.comingcourse')}}</span></p></center>

    <div class="container">
        <div class="row">
        @foreach($comingcourses as $course)
            <div class="col-lg-4 col-md-6">
                <div class="box box-orange mt-2 mb-2">
                    <div class="box-top box-top-orange">
                        {{$course->title}}
                    </div>
                    <div class="box-body">
                        <p>{{$course->shortDescription}}</p>


                        <span class="text-orange">السعر</span>
                        @if($course->free==0)
                        <span class="badge badge-warning">{{$course->price}}</span>
                        @else
                        <span class="badge badge-success">مجانية</span>
                        @endif
                        <div>تاريخ البدء {{$course->startAt}}</div>
                        <span class="text-orange">الأيام:</span>
                        @foreach($course->weekDays as $day)
                           @if($day){{__('weeks.'.$day)}}@endif
                        @endforeach
                        <div>
                            تاريخ نهاية التسجيل {{$course->registerEndAt}}
                        </div>
                        <center><a href="" class="font-bold">التفاصيل</a></center>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
     </div>

    <center><p  class="text-lg py-2 text-darkorange"><span class="underline">{{__('pages.nowcourse')}}</span></p></center>

        <div class="container">
        <div class="row">
        @foreach($nowcourses as $course)
            <div class="col-lg-4 col-md-6">
                <div class="box box-red mt-2 mb-2">
                    <div class="box-top box-top-red">
                        {{$course->title}}
                    </div>
                    <div class="box-body">
                        <p>{{$course->shortDescription}}</p>


                        <span class="text-red">السعر</span>
                        @if($course->free==0)
                        <span class="badge badge-warning">{{$course->price}}</span>
                        @else
                        <span class="badge badge-success">مجانية</span>
                        @endif
                        <div>تاريخ البدء {{$course->startAt}}</div>
                        <span class="text-red">الأيام:</span>
                        @foreach($course->weekDays as $day)
                            {{__('weeks.'.$day)}}
                        @endforeach

                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>

    <center><p  class="text-lg py-2 text-darkorange"><span class="underline">{{__('pages.pastcourse')}}</span></p></center>

    <div class="container">
        <div class="row">
        @foreach($pastcourses as $course)
            <div class="col-lg-4 col-md-6">
                <div class="box box-blue mt-2 mb-2">
                    <div class="box-top box-top-blue">
                        {{$course->title}}
                    </div>
                    <div class="box-body">
                        <p>{{$course->shortDescription}}</p>


                        <span class="text-blue">السعر</span>
                        @if($course->free==0)
                        <span class="badge badge-warning">{{$course->price}}</span>
                        @else
                        <span class="badge badge-success">مجانية</span>
                        @endif
                        <div>تاريخ البدء {{$course->startAt}}</div>
                        <span class="text-blue">الأيام:</span>
                        @foreach($course->weekDays as $day)
                            {{__('weeks.'.$day)}}
                        @endforeach

                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>



</div>

    <div class="footer bg-color-ligtorange text-darkorange">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-md-4 col-sm-12 justify-logo">
                    <div class="footer-logo-container">
                        <span class="logo-title-lg" >الجمعية العمانية للعناية بالقرآن الكريم</span>
                        <span class="logo-title-sm" >مركز ولاية العامرات</span>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 footer-social-container">
                    <div class="social">
                        <img src="img/instagram.png"width="30">
                        <img src="img/facebook.png" width="30">
                        <img src="img/twitter.png"  width="30">
                        <img src="img/youtube.png"  width="30">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 justify-footer-link">
                    <div class="footer-link">
                        <span> <a href="">الجمعية</a> |</span>
                        <span> <a href="">سياسة الإستخدتم</a> |</span>
                        <span> <a href="">اتصل بنا</a> </span>
                    </div>
                </div>

            </div>
        </div>
    </div><!--/footer-->

</body>
</html>








