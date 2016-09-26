@extends('layouts.app')

@section('content')
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>

        <div class="flex-center position-ref full-height">
            @if (!Route::has('login'))
                <div class="top-right links">
                    <a href="{{ url('/login') }}">Login</a>
                    <a href="{{ url('/register') }}">Register</a>
                </div>
                @else

            @endif

            <div class="content">
                <div class="title m-b-md">
                   Тестовая работа
                </div>

                <div class="links">
                    <a href="https://vk.com/exxxar">Моя страничка в соц. сетях</a>
                    <a href="tel:azy_exxxar">Мой Skype</a>
                    <a href="mailto:exxxar@gmail.com">Моя почта</a>
                    <a href="https://github.com/exxxar">GitHub</a>
                </div>
            </div>
        </div>
@endsection
