@extends('layouts.appOmdahome')

@section('content')
<style>
    #chair-image {
        bottom: 0px;
        position: absolute;
        height: 500px;
        align-items: center;
        justify-content: center;
        margin: auto;
        display: flex;
        right: 43%;
        z-index: 9999;
    }

    #container-title {
        z-index: 9999999;
        bottom: 255px;
        position: absolute;
        right: 41%;
    }

    #chat-bubble {
        height: 187px;
        align-items: center;
        justify-content: center;
        margin: auto;
        display: flex;
        z-index: 9999999;
        transform: scaleX(-1);
        rotate: 21deg;
    }

    .home-title {
        position: relative;
        z-index: 9999999;
        color: rgb(0, 0, 0);
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        top: 89px;
        right: -6px;
    }

    .ads-container {
        display: flex;
        justify-content: space-between;
    }

    .logo {
        width: 350px;
        height: 250px;
    }

    .image-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: rgb(0, 0, 0);
    font-size: 16px;
    font-weight: normal;
    text-align: center;
    z-index: 1000;
    width: 100%;
    padding: 5px 10px;
    border-radius: 5px;
    }
</style>
<div>
<div class="container mt-5 mb-5" style="margin-right: 70px;">
    <div class="row align-items-center">
        <div class="col-md-8" style="max-width: 1200px; margin-top: 50px;">
            <div class="p-3" style=" ">
                <h3 style="color: #071739; font-weight: bold; margin-bottom: 20px; font-size: 35px;">كيف نعمل؟</h3>
                <p style="font-size: 18px; line-height: 1.8; color: #333;">{{ $works->content_ar }}</p>
            </div>
        </div>
        <div class="col-md-4 text-center" style="margin-top: 50px; margin-bottom: 20px; margin-right: 316px;">
            <img src="{{ asset('storage/' . $works->avatar) }}" alt="About Image" class="img-fluid rounded-circle shadow" 
            style="border-radius: 5%; max-width: 200px; max-height: 200px;">
        </div>
    </div>
</div>
</div>
@endsection