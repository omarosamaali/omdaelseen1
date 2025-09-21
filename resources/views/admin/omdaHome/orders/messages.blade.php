@extends($layout)

@section('content')

<style>
    .th {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
        text-align: right;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 800px;
        border-radius: 10px;
        text-align: center;
    }

    .modal-image {
        max-width: 100%;
        max-height: 500px;
        object-fit: contain;
        margin-bottom: 10px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
    }

    .modal-buttons {
        margin-top: 10px;
        display: flex;
        justify-content: center;
        gap: 10px;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="p-4 text-end" style="margin-top: 30px;">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="max-width: 100%; margin: 20px">
        <table id="explorers_table" class="w-full text-sm text-left rtl:text-right text-gray-500"
            style="background: #c9c9c9;">
            <thead class="text-xs text-gray-700 uppercase">
                <tr>
                    <th scope="col" class="th">الرقم</th>
                    <th scope="col" class="th">التاريخ</th>
                    <th scope="col" class="th">النوع</th>
                    <th scope="col" class="th">المستخدم</th>
                    <th scope="col" class="th">الرسالة</th>
                    <th scope="col" class="th">الصورة</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($messages as $trip)
                <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                    <td class="th">{{ $loop->iteration }}</td>
                    <td class="th">{{ $trip->created_at }}</td>
                    <td class="th">منتج خاص</td>
                    <td class="th">{{ $trip->user->name }}</td>
                    <td class="th">{{ $trip->message }}</td>
                    <td class="th">
                        @if ($trip->image)
                        <button class="view-image-btn" data-image="{{ asset('storage/' . $trip->image) }}"
                            data-file="{{ asset('storage/' . $trip->image) }}">
                            <i class="fa fa-eye"></i> عرض الصورة
                        </button>
                        @else
                        لا توجد صورة
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const downloadOriginal = document.getElementById('downloadOriginal');
        const closeModal = document.getElementsByClassName('close')[0];
        document.querySelectorAll('.view-image-btn').forEach(button => {
            button.addEventListener('click', function() {
                const imageUrl = this.getAttribute('data-image');
                const fileUrl = this.getAttribute('data-file');
                modalImage.src = imageUrl;
                downloadOriginal.href = fileUrl;
                modal.style.display = 'block';
            });
        });
        closeModal.addEventListener('click', function() {
            modal.style.display = 'none';
        });
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
</script>
@endsection