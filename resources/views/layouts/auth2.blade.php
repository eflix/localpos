<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'POS') }}</title>
    @include('layouts.partials.css')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-image: linear-gradient(45deg, #6200EA, #03A9F4, #6200EA);
        }

        .container-fluid {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-form-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        .btn-bg-maroon {
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .control-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .footer-section {
            text-align: right;
        }

        select#change_lang {
            width: 100%;
        }

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
            background-color: #6200EA;
            background-image: linear-gradient(135deg, #6200EA 0%, #03A9F4 100%);
        }

        .btn-green {
            background-color: #4CAF50;
            /* Warna hijau */
            color: white;
            /* Warna teks putih */
            border: none;
            /* Tidak ada border */
            transition: 0.3s;
            /* Efek transisi ketika tombol ditekan */
        }

        .btn-green:hover {
            background-color: #45a049;
            color: white;
        }
    </style>
</head>

<body>
    <div id="particles-js"></div>

    @inject('request', 'Illuminate\Http\Request')
    @if (session('status') && session('status.success'))
    <input type="hidden" id="status_span" data-status="{{ session('status.success') }}" data-msg="{{ session('status.msg') }}">
    @endif

    <div class="container-fluid">
        <div class="login-form-container">
            <div class="logo-section">
                <a href="/">
                    @if(file_exists(public_path('uploads/logo.png')))
                    <img src="/uploads/logo.png" class="img-rounded" alt="Logo" width="150">
                    @else
                    {{ config('app.name', 'ultimatePOS') }}
                    @endif
                </a>
            </div>

            <div class="control-section">
                <select class="form-control input-sm" id="change_lang">
                    @foreach(config('constants.langs') as $key => $val)
                    <option value="{{$key}}" @if( (empty(request()->lang) && config('app.locale') == $key)
                        || request()->lang == $key)
                        selected
                        @endif
                        >
                        {{$val['full_name']}}
                    </option>
                    @endforeach
                </select>

                <a href="{{ action([\Modules\Superadmin\Http\Controllers\PricingController::class, 'index']) }}" class="btn btn-green" style="margin-left: 10px;">@lang('superadmin::lang.pricing')</a>


            </div>

            @yield('content')

            <div class="footer-section">
                @if(!($request->segment(1) == 'business' && $request->segment(2) == 'register'))
                @if(config('constants.allow_registration'))
                <a href="{{ route('business.getRegister') }}@if(!empty(request()->lang)){{'?lang=' . request()->lang}} @endif" class="btn bg-maroon btn-flat">{{ __('business.not_yet_registered')}} {{ __('business.register_now') }}</a>
                @if(Route::has('pricing') && config('app.env') != 'demo' && $request->segment(1) != 'pricing')


                @endif
                @endif
                @endif
                @if($request->segment(1) != 'login')
                <br><span>{{ __('business.already_registered')}} </span>
                <a href="{{ action([\App\Http\Controllers\Auth\LoginController::class, 'login']) }}@if(!empty(request()->lang)){{'?lang=' . request()->lang}} @endif">{{ __('business.sign_in') }}</a>
                @endif
            </div>
        </div>
    </div>

    @include('layouts.partials.javascripts')

    <!-- Scripts -->
    <script src="{{ asset('js/login.js?v=' . $asset_v) }}"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>


    @yield('javascript')

    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2_register').select2();

            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });

        particlesJS('particles-js', {
            particles: {
                number: {
                    value: 100,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                color: {
                    value: '#ffffff'
                },
                shape: {
                    type: 'circle',
                    stroke: {
                        width: 0,
                        color: '#000000'
                    },
                    polygon: {
                        nb_sides: 5
                    },
                },
                opacity: {
                    value: 0.5,
                    random: false,
                    anim: {
                        enable: false,
                        speed: 1,
                        opacity_min: 0.1,
                        sync: false
                    }
                },
                size: {
                    value: 3,
                    random: true,
                    anim: {
                        enable: false,
                        speed: 40,
                        size_min: 0.1,
                        sync: false
                    }
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: '#ffffff',
                    opacity: 0.4,
                    width: 1.5
                },
                move: {
                    enable: true,
                    speed: 2,
                    direction: 'none',
                    random: true,
                    straight: false,
                    out_mode: 'out',
                    bounce: false,
                    attract: {
                        enable: false,
                        rotateX: 600,
                        rotateY: 1200
                    }
                }
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: {
                        enable: true,
                        mode: 'grab'
                    },
                    onclick: {
                        enable: true,
                        mode: 'push'
                    },
                    resize: true
                },
                modes: {
                    grab: {
                        distance: 140,
                        line_linked: {
                            opacity: 1
                        }
                    },
                    bubble: {
                        distance: 400,
                        size: 40,
                        duration: 2,
                        opacity: 8,
                        speed: 3
                    },
                    repulse: {
                        distance: 200,
                        duration: 0.4
                    },
                    push: {
                        particles_nb: 4
                    },
                    remove: {
                        particles_nb: 2
                    }
                }
            },
            retina_detect: true
        });
    </script>
</body>

</html>