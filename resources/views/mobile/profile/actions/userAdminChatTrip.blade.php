@extends($layout)
@section('title', 'عمدة الصين | China Omda')

@section('content')
<div class="relative h-screen flex flex-col bg-gradient-to-b from-bgColor1 to-gray-50 dark:from-color1 dark:to-gray-900"
    style="background-image: url('{{ asset('assets/images/bg-image.png') }}'); background-size: cover; background-attachment: fixed;">

    <!-- Header with Date -->
    <div class="flex justify-center items-center w-full py-6 backdrop-blur-sm">
        <div
            class="bg-white/90 dark:bg-color9/90 backdrop-blur-md shadow-lg border border-color21/20 dark:border-color24/20 rounded-full px-6 py-3">
            <p style="color: black;" class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                <i class="ph ph-calendar-blank ml-2"></i>
                {{ now()->format('d M, Y') }}
            </p>
        </div>
    </div>

    <!-- Chat Messages Container -->
    <div class="flex-1 overflow-hidden">
        <div class="h-full overflow-y-auto px-4 py-6 space-y-6" id="chat-container">
            @foreach ($travel_chats as $message)
            <div
                class="flex {{ $message->user->role === 'admin' ? 'justify-start' : 'justify-end' }} items-end gap-3 w-full animate-fade-in">

                <!-- Admin Avatar (Left Side) --> 
                @if ($message->user->role === 'admin')
                <div
                    class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-p2 to-p1 rounded-full flex items-center justify-center shadow-lg">
                    <img src="{{ asset('assets/assets/images/logo.png') }}" alt="">
                </div>
                @endif

                <!-- Message Content -->
                <div class="flex flex-col gap-2 max-w-[320px] sm:max-w-[400px]">

                    <!-- Message Bubble -->
                    <div class="relative group">
                        @if ($message->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $message->image) }}" alt="Message Image"
                                class="max-w-full max-h-[200px] rounded-2xl shadow-lg border border-white/20 hover:scale-105 transition-transform duration-200 cursor-pointer"
                                onclick="openImageModal(this.src)" />
                        </div>
                        @endif

                        @if ($message->message)
                        <div class="relative {{ $message->user->role === 'admin' 
                                    ? 'bg-gradient-to-r from-p2 to-p1 text-white rounded-r-2xl rounded-bl-2xl shadow-lg' 
                                    : 'bg-white dark:bg-color9 text-color5 dark:text-white rounded-l-2xl rounded-tr-2xl shadow-lg border border-gray-100 dark:border-color24' }} 
                                    p-4 backdrop-blur-sm" style="color: black;">

                            <!-- Message Text -->
                            <p class="text-sm leading-relaxed">
                                {{ $message->message }}
                            </p>

                            <!-- Message Time -->
                            <div class="flex justify-{{ $message->user->role === 'admin' ? 'start' : 'end' }} mt-2">
                                <span class="text-xs opacity-70">
                                    {{ $message->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <!-- Message Arrow -->
                            {{-- <div
                                class="absolute {{ $message->user->role === 'admin' ? '-left-1 bottom-2' : '-right-1 bottom-2' }}">
                                <div
                                    class="w-3 h-3 {{ $message->user->role === 'admin' 
                                            ? 'bg-p1 rotate-45' 
                                            : 'bg-white dark:bg-color9 border-r border-b border-gray-100 dark:border-color24 rotate-45' }}">
                                </div>
                            </div> --}}
                        </div>
                        @endif
                    </div>
                </div>

                <!-- User Status & Avatar (Right Side) -->
                @if ($message->user->role !== 'admin')
                <div class="flex flex-col items-center gap-2">
                    <div
                        class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-color9 dark:to-color24 rounded-full flex items-center justify-center shadow-lg">
                        <img src="{{ asset('storage/' . $message->user->avatar) }}" style="border-radius: 50%; border: 2px solid rgb(0, 0, 0); width: 50px; height: 50px;" alt="">
                    </div>
                    <div class="bg-p2 dark:bg-p1 rounded-full p-1 shadow-md">
                        <i class="ph ph-check text-white text-xs"></i>
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal"
    class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeImageModal()"
            class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors">
            <i class="ph ph-x text-2xl"></i>
        </button>
        <img id="modalImage" src="" alt="Full Size Image" class="max-w-full max-h-full rounded-lg shadow-2xl" />
    </div>
</div>

<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #chat-container::-webkit-scrollbar {
        width: 6px;
    }

    #chat-container::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    #chat-container::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }

    #chat-container::-webkit-scrollbar-thumb:hover {
        background: rgba(0, 0, 0, 0.3);
    }

    /* Dark mode scrollbar */
    .dark #chat-container::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
    }

    .dark #chat-container::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
    }

    .dark #chat-container::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Hover effects */
    .group:hover .shadow-lg {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Responsive improvements */
    @media (max-width: 640px) {
        .max-w-[320px] {
            max-width: 280px;
        }
    }
</style>

<script>
    // Auto scroll to bottom when page loads
document.addEventListener('DOMContentLoaded', function() {
    const chatContainer = document.getElementById('chat-container');
    chatContainer.scrollTop = chatContainer.scrollHeight;
});

// Image modal functions
function openImageModal(src) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    modalImage.src = src;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>

@endsection