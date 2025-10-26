@extends('layouts.mobile')

@section('title', 'عمدة الصين | محادثة الرحلة')

@section('content')
<style>
    html {
        direction: ltr;
    }
</style>

<body class="relative -z-20">
    <div class="container h-screen dark:text-white flex flex-col justify-between">
        <!-- Header -->
        <div class="flex justify-between items-center bg-p2 px-6 py-6"
            style="position: fixed; width: 100%; z-index: 999999999999999;">
            <div class="flex justify-start items-center gap-4">
                <a href="{{ url()->previous() }}"
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
                    <p class="text-2xl font-semibold">عمدة الصين</p>
                    <p class="text-xs font-semibold">Online</p>
                </div>
            </div>
        </div>

        <!-- Trip Info -->
        <div class="flex justify-center items-center bg-p2 px-6 py-4"
            style="position: fixed; width: 100%; z-index: 999999999999999; margin: auto; top: 90px;">
            <div class="flex justify-start items-center gap-4">
                <div class="text-white">
                    <p style="font-size: 0.75rem; margin: auto;" class="text-center font-semibold">
                        {{ $order->reference_number ?? 'غير متوفر' }}
                    </p>
                    <p style="font-size: 0.75rem; margin: auto;" class="text-center font-semibold">طلب رحلة</p>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <div class="relative h-full flex justify-end flex-col items-start pb-24 bg-bgColor1 dark:bg-color1"
            style="background-image: url('{{ asset('assets/images/bg-image.png') }}')">

            <div class="flex justify-center items-center w-full pb-8">
                <p
                    class="text-xs font-semibold bg-white dark:bg-color9 dark:border-color24 py-2 px-8 border border-color21 rounded-full">
                    {{ now()->format('d M, Y') }}
                </p>
            </div>

            <div id="chat-container" class="flex flex-col gap-8 w-full"
                style="margin-top: 93px; padding-top: 23px; overflow: auto;">
                @forelse ($messages as $message)
                @php
                $isAdmin = $message->user && $message->user->role === 'admin';
                $messageAlign = $isAdmin ? 'justify-start' : 'justify-end';
                $bubbleClass = $isAdmin
                ? 'bg-p2 dark:bg-p1 text-white rounded-r-2xl rounded-bl-2xl'
                : 'bg-white dark:bg-color9 text-color5 dark:text-white rounded-l-2xl rounded-tr-2xl';
                @endphp

                <div class="flex {{ $messageAlign }} items-end gap-3 w-full px-6">
                    <div class="flex flex-col gap-3">
                        <div class="flex justify-start items-center gap-2">
                            @if ($message->image)
                            <img src="{{ asset('storage/' . $message->image) }}" style="max-height: 200px;"
                                alt="Message Image" class="max-w-[200px] rounded-lg border border-color21" />
                            @endif

                            @if ($message->message)
                            <p class="{{ $bubbleClass }} p-4 text-xs max-w-[280px]">
                                {{ $message->message }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-gray-400 py-8">
                    <p>لا توجد رسائل بعد</p>
                </div>
                @endforelse
            </div>

            <!-- Input Form -->
            <div class="fixed bottom-0 left-0 right-0 z-50" style="direction: rtl;">
                <form id="message-form" enctype="multipart/form-data">
                    <input type="hidden" name="order_id" value="{{ $order_id }}">
                    <input type="hidden" name="order_type" value="{{ $order_type }}">

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
                                class="text-xs placeholder:text-color9 bg-transparent dark:text-white dark:placeholder:text-white outline-none w-full" />
                        </div>
                        <button type="submit" id="send-message"
                            class="text-white flex justify-center items-center bg-p1 p-3.5 rounded-full text-xl">
                            <i class="ph-fill ph-paper-plane-tilt"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('message-form').addEventListener('submit', function (e) {
            e.preventDefault();
            
            let messageInput = document.getElementById('message-input').value.trim();
            let imageInput = document.getElementById('image-upload').files[0];
            let orderId = document.querySelector('input[name="order_id"]').value;
            let orderType = document.querySelector('input[name="order_type"]').value;

            if (!messageInput && !imageInput) {
                return;
            }

            let formData = new FormData();
            formData.append('order_id', orderId);
            formData.append('order_type', orderType);
            if (messageInput) formData.append('message', messageInput);
            if (imageInput) formData.append('image', imageInput);

            // ✅ المستخدم يبعت على route بتاعه
            fetch('/mobile/user-trip-messages/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert('فشل إرسال الرسالة: ' + data.error);
                    return;
                }
                
                let chatContainer = document.getElementById('chat-container');
                let messageContent = '';
                
                if (data.message.image) {
                    messageContent += `<img src="/storage/${data.message.image}" alt="Message Image" style="max-height: 200px;" class="max-w-[200px] rounded-lg border border-color21" />`;
                }
                if (data.message.message) {
                    messageContent += `<p class="bg-white dark:bg-color9 text-color5 dark:text-white rounded-l-2xl rounded-tr-2xl p-4 text-xs max-w-[280px]">${data.message.message}</p>`;
                }
                
                let newMessage = `
                    <div class="flex justify-end items-end gap-3 w-full px-6">
                        <div class="flex flex-col gap-3">
                            <div class="flex justify-start items-center gap-2">
                                ${messageContent}
                            </div>
                        </div>
                    </div>
                `;
                
                chatContainer.insertAdjacentHTML('beforeend', newMessage);
                chatContainer.scrollTop = chatContainer.scrollHeight;
                
                document.getElementById('message-input').value = '';
                document.getElementById('image-upload').value = '';
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('حدث خطأ أثناء إرسال الرسالة');
            });
        });

        // Auto scroll on load
        window.addEventListener('load', function() {
            let chatContainer = document.getElementById('chat-container');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        });
    </script>
</body>
@endsection