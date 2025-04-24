<!-- resources/views/auth/forgot-password.blade.php -->
@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>إعادة تعيين كلمة المرور - قرية عمدة الصين</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: "Cairo", sans-serif;
            overflow-x: hidden;
        }
        .page-container {
            display: flex;
            height: 100vh;
            background-image: url('{{ asset('assets/img/bg-w.svg') }}');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            width: 100%;
        }
        .main-content {
            flex: 1;
            padding: 20px;
            position: relative;
        }
        .form-container {
            text-align: center;
            max-width: 385px;
            align-items: center;
            justify-content: center;
            display: flex;
            margin: auto;
            margin-top: 330px;
            background: #d1d1d142;
            z-index: 9999999999;
            border-radius: 26px;
            padding: 20px;
        }
        .logo {
            position: absolute;
            top: 100px;
            left: 50%;
            width: 200px;
            height: 200px;
            z-index: 99999;
            transform: translate(-50%, -50%);
        }
        .logo-title {
            width: 70%;
            z-index: 99;
            color: #be3d1e;
            text-align: center;
            font-size: 46px;
            font-weight: normal;
            position: absolute;
            top: 30%;
            line-height: 1.4;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        footer {
            position: absolute;
            bottom: 5px;
            align-items: center;
            justify-content: center;
            margin: auto;
            display: flex;
            flex-direction: column;
            width: 100%;
            z-index: 99999999999;
            color: white;
        }
        input {
            font-size: 12px;
            text-align: center;
            display: block;
            margin-top: 0.25rem;
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
        }
        input:focus {
            outline: none;
            border: none;
        }
        .error-message {
            color: red;
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body style="overflow: hidden;">
    <div class="page-container">
        <div class="logo-container-bottom">
            <img class="logo" src="{{ asset('assets/img/logo.svg') }}" alt="">
        </div>
        <h1 class="logo-title">إعادة تعيين كلمة المرور</h1>

        <div class="main-content">
            <div class="form-container">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div style="margin-bottom: 1rem;">
                        <label for="email" style="color: white;">{{ __('البريد الالكتروني') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                            <span class="error-message">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <!-- Status Message -->
                    @if (session('status'))
                        <div style="color: green; margin-bottom: 1rem;">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                        <button type="submit" style="font-family: Cairo; border: 0; padding: 0.5rem 1rem; background-color: #c00000; color: white; border-radius: 0.375rem; font-weight: 500;">
                            {{ __('إرسال رابط إعادة تعيين كلمة المرور') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <footer>
            <div class="footer-container">
                <div class="footer-link-bottom">
                    جميع الحقوق محفوظة ل عمدة الصين للوساطة التجارية © 2025
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
@endsection