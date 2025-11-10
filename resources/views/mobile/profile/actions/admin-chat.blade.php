@extends('layouts.mobile')

@section('title', 'عمدة الصين | China Omda')

@section('content')
<style>
    html {
        direction: ltr;
    }
</style>

<body class="relative -z-20">
    <div class="container h-screen dark:text-white flex flex-col justify-between">
        <div class="flex justify-between items-center bg-p2 px-6 py-6"
            style="position: fixed; width: 100%; z-index: 999999999999999;">
            <div class="flex justify-start items-center gap-4">
                <a href="{{ route('mobile.admin-orders') }}"
                    class="border border-color16 p-1.5 rounded-full flex justify-center items-center dark:border-bgColor16 dark:bg-bgColor14 bg-white">
                    <i class="ph ph-caret-left"></i>
                </a>
                <div style="background-color: white;" class="relative border-2 border-p1 p-1 rounded-full">
                    <img src="{{ asset('assets/assets/images/logo.png') }}" alt="" style="background-color: white;"
                        class="size-10 rounded-full bg-color8" />
                    <div class="bg-white p-0.5 rounded-full absolute -right-1.5 bottom-1">
                        <div class="size-3 rounded-full bg-p3"></div>
                    </div>
                </div>
                <div class="text-white">
                    <p class="text-2xl font-semibold">{{ $product->user->name }}</p>
                    <p class="text-xs font-semibold">Online</p>
                </div>
            </div>
        </div>
        <div class="flex justify-center items-center bg-p2 px-6 py-4"
            style="position: fixed; width: 100%; z-index: 999999999999999; margin: auto; top: 90px;">
            <div class="flex justify-start items-center gap-4">
                <div class="text-white">
                    <p style="font-size: 0.75rem; margin: auto;" class="text-center font-semibold">{{
                        $product->reference_number ?? 'غير متوفر' }}</p>
                    <p style="font-size: 0.75rem; margin: auto;" class="text-center font-semibold">طلب منتج</p>
                </div>
            </div>
        </div>
        <div class="relative h-full flex justify-end flex-col items-start pb-24 bg-bgColor1 dark:bg-color1"
            style="background-image: url('{{ asset('assets/images/bg-image.png') }}')">
            <div class="flex justify-center items-center w-full pb-8">
                <p
                    class="text-xs font-semibold bg-white dark:bg-color9 dark:border-color24 py-2 px-8 border border-color21 rounded-full">
                    {{ now()->format('d M, Y') }}
                </p>
            </div>
            <div class="flex flex-col gap-8 w-full" style="margin-top: 93px; padding-top: 23px; overflow: auto;">
                @foreach (App\Models\OrderMessage::where('product_id', $product_id)->with('user')->orderBy('created_at',
                'asc')->get() as $message)
                <div
                    class="flex {{ $message->user->role === 'admin' ? 'justify-start' : 'justify-end' }} items-end gap-3 w-full px-6">
                    <div class="flex flex-col gap-3">
                        <div class="flex justify-start items-center gap-2">
                            @if ($message->image)
                            <img src="{{ asset('storage/' . $message->image) }}" style="max-height: 200px;"
                                alt="Message Image" class="max-w-[200px] rounded-lg border border-color21" />
                            @endif
                            @if ($message->message)
                            <p
                                class="text-{{ $message->user->role === 'admin' ? 'white' : 'color5' }} p-4 {{ $message->user->role === 'admin' ? 'bg-p2 dark:bg-p1 rounded-r-2xl rounded-bl-2xl' : 'bg-white dark:bg-color9 dark:text-white rounded-l-2xl rounded-tr-2xl' }} text-xs max-w-[280px]">
                                {{ $message->message }}
                            </p>
                            @endif
                        </div>
                    </div>
                    @if ($message->user->role !== 'admin')
                    <div>
                        <i class="ph ph-check text-xs p-1 rounded-full bg-p2 dark:bg-p1 text-white"></i>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            <div class="fixed bottom-0 left-0 right-0 z-50" style="direction: rtl;">
                <form id="message-form" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="{{ $product_id }}">
                    <div class="flex justify-between items-center gap-2 px-6 container pb-8"
                        style="position: fixed; width: 100%; bottom: -17px; background: white; padding-top: 10px;">
                        <label for="image-upload" class="text-p1 text-2xl cursor-pointer">
                            <i class="ph-fill ph-image"></i>
                            <input type="file" id="image-upload" name="image" accept="image/*" class="hidden" />
                        </label>
                        <div
                            class="flex justify-start items-center bg-white dark:bg-color9 p-3.5 rounded-full w-full border border-color21">
                            <input type="text" id="message-input" name="message" placeholder="الرسالة"
                                style="text-align: right;"
                                class="text-xs placeholder:text-color9 bg-transparent dark:text-white dark:placeholder:text-white outline-none" />
                        </div>
                        <button type="submit" id="send-message"
                            class="text-white flex justify-center items-center bg-p1 p-3.5 rounded-full text-xl">
                            <i class="ph-fill ph-paper-plane-tilt"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

<script>
    // تأكد إن الـ script بيشتغل
    console.log('Script loaded!');
    
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM Ready!');
        
        const form = document.getElementById('message-form');
        console.log('Form found:', form);
        
        if (!form) {
            alert('Form not found!');
            return;
        }
        
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // مهم جداً!
            console.log('Form submitted via JavaScript!');
            
            let messageInput = document.getElementById('message-input');
            let imageInput = document.getElementById('image-upload');
            let productIdInput = document.querySelector('input[name="product_id"]');
            
            console.log('Message Input:', messageInput);
            console.log('Image Input:', imageInput);
            console.log('Product ID Input:', productIdInput);
            
            let messageValue = messageInput ? messageInput.value.trim() : '';
            let imageFile = imageInput ? imageInput.files[0] : null;
            let productId = productIdInput ? productIdInput.value : '';

            console.log('=== Form Data ===');
            console.log('Product ID:', productId);
            console.log('Message:', messageValue);
            console.log('Image:', imageFile ? imageFile.name : 'No image');

            if (!messageValue && !imageFile) {
                alert('يجب إدخال رسالة أو صورة');
                return;
            }

            let formData = new FormData();
            formData.append('product_id', productId);
            if (messageValue) formData.append('message', messageValue);
            if (imageFile) formData.append('image', imageFile);

            // اطبع الـ FormData
            console.log('=== FormData Contents ===');
            for (let pair of formData.entries()) {
                console.log(pair[0] + ':', pair[1]);
            }

            let sendButton = document.getElementById('send-message');
            let originalHTML = sendButton.innerHTML;
            sendButton.innerHTML = '<i class="ph ph-spinner-gap"></i>';
            sendButton.disabled = true;

            fetch('/mobile/chat/order/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                console.log('=== Response ===');
                console.log('Status:', response.status);
                return response.text();
            })
            .then(text => {
                console.log('=== Raw Response ===');
                console.log(text);
                
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    // اطبع الـ error على الصفحة
                    document.body.insertAdjacentHTML('afterbegin', 
                        `<div style="position:fixed;top:0;left:0;right:0;background:red;color:white;padding:20px;z-index:999999;max-height:400px;overflow:auto;">
                            <h3>Server Error:</h3>
                            <pre style="white-space:pre-wrap;font-size:12px;">${text}</pre>
                            <button onclick="this.parentElement.remove()" style="background:white;color:red;padding:10px;margin-top:10px;">Close</button>
                        </div>`
                    );
                    throw new Error('Invalid JSON');
                }
                
                console.log('=== Parsed Data ===');
                console.log(data);
                
                sendButton.innerHTML = originalHTML;
                sendButton.disabled = false;
                
                if (data.error) {
                    // اطبع الـ error على الصفحة
                    let errorHTML = '<h3>❌ خطأ: ' + data.error + '</h3>';
                    if (data.details) {
                        errorHTML += '<pre style="background:rgba(0,0,0,0.2);padding:10px;margin-top:10px;">' + JSON.stringify(data.details, null, 2) + '</pre>';
                    }
                    document.body.insertAdjacentHTML('afterbegin', 
                        `<div style="position:fixed;top:0;left:0;right:0;background:#ff6b6b;color:white;padding:20px;z-index:999999;direction:rtl;">
                            ${errorHTML}
                            <button onclick="this.parentElement.remove()" style="background:white;color:#ff6b6b;padding:10px;margin-top:10px;border:none;border-radius:5px;">إغلاق</button>
                        </div>`
                    );
                    return;
                }
                
                // Success - add message
                let chatContainer = document.querySelector('.flex.flex-col.gap-8');
                let messageContent = '';
                
                if (data.message.image) {
                    messageContent += `<img src="{{ asset('storage/') }}/${data.message.image}" style="max-height:200px;" class="max-w-[200px] rounded-lg border border-color21" />`;
                }
                if (data.message.message) {
                    messageContent += `<p class="text-white p-4 bg-p2 dark:bg-p1 rounded-r-2xl rounded-bl-2xl text-xs max-w-[280px]">${data.message.message}</p>`;
                }
                
                chatContainer.insertAdjacentHTML('beforeend', `
                    <div class="flex justify-start items-end gap-3 w-full px-6">
                        <div class="flex flex-col gap-3">
                            <div class="flex justify-start items-center gap-2">
                                ${messageContent}
                            </div>
                        </div>
                    </div>
                `);
                
                chatContainer.scrollTop = chatContainer.scrollHeight;
                
                messageInput.value = '';
                imageInput.value = '';
                
                // Success message
                document.body.insertAdjacentHTML('afterbegin', 
                    `<div style="position:fixed;top:20px;left:50%;transform:translateX(-50%);background:#51cf66;color:white;padding:15px 30px;z-index:999999;border-radius:10px;">
                        ✓ تم إرسال الرسالة
                    </div>`
                );
                setTimeout(() => document.querySelector('div[style*="#51cf66"]')?.remove(), 3000);
            })
            .catch(error => {
                console.error('=== Error ===');
                console.error(error);
                
                sendButton.innerHTML = originalHTML;
                sendButton.disabled = false;
                
                document.body.insertAdjacentHTML('afterbegin', 
                    `<div style="position:fixed;top:0;left:0;right:0;background:#c92a2a;color:white;padding:20px;z-index:999999;direction:rtl;">
                        <h3>⚠️ خطأ: ${error.message}</h3>
                        <button onclick="this.parentElement.remove()" style="background:white;color:#c92a2a;padding:10px;margin-top:10px;border:none;border-radius:5px;">إغلاق</button>
                    </div>`
                );
            });
        });
    });
</script>
</body>
@endsection