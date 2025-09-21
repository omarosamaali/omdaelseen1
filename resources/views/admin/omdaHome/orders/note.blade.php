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
    <div style="display: flex; flex-direction: row-reverse; justify-content: space-between;">
        <div style="margin-left: 20px;">
            <a href="{{ route('admin.orders.createNote', $order->id) }}"
                class="btn btn-dark px-4 py-2 mt-4 bg-black text-white rounded-md">
                ملاحظة جديدة
            </a>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; gap:10px; margin-right: 20px;">
            <p>الملاحظات</p>
            <div style="display: flex; align-items: center; gap: 10px;">
                <form id="filter-form" action="{{ route('admin.orders.note', $order->id) }}" method="GET"
                    style="margin: 0; display:flex; gap:10px;">
                    <select name="status" id="status-filter" onchange="this.form.submit()"
                        style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 30px; background-color: transparent; text-align: center;">
                        <option value="">جميع الحالات</option>
                        <option value="عامة" {{ request('status')=='عامة' ? 'selected' : '' }}>عامة</option>
                        <option value="خاصة" {{ request('status')=='خاصة' ? 'selected' : '' }}>خاصة</option>
                        <option value="ملغية" {{ request('status')=='ملغية' ? 'selected' : '' }}>ملغية</option>
                    </select>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث"
                        style="text-align: right; width: 200px; padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 30px; background-color: transparent;">
                    <button type="submit" style="display:none"></button>
                </form>
            </div>
        </div>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="max-width: 100%; margin: 20px">
        <table id="explorers_table" class="w-full text-sm text-left rtl:text-right text-gray-500"
            style="background: #c9c9c9;">
            <thead class="text-xs text-gray-700 uppercase">
                <tr>
                    <th scope="col" class="th">رقم الملاحظة</th>
                    <th scope="col" class="th">رقم المرجع</th>
                    <th scope="col" class="th">التاريخ</th>
                    <th scope="col" class="th">العنوان</th>
                    <th scope="col" class="th">الحالة</th>
                    <th scope="col" class="th">أجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notes as $note)
                <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                    <td class="th">{{ $note->note_number }}</td>
                    <td class="th">{{ $order->reference_number }}</td>
                    <td class="th">{{ $note->note_date }}</td>
                    <td class="th">{{ $note->title }}</td>
                    <td class="th">{{ $note->status }}</td>
                    <td class="th" style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.orders.showNote', $note->id) }}" class="font-medium text-blue-600">
                            <svg class="w-6 h-6 text-blue-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>
                        <a href="{{ route('admin.orders.editNote', $note->id) }}" class="font-medium text-green-600">
                            <i class="fa-solid fa-edit" style="font-size: 18px;"></i>
                        </a>
                        <form action="{{ route('admin.orders.destroyNote', $note->id) }}" method="POST"
                            style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذه الملاحظة؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-medium text-red-600">
                                <i class="fa-solid fa-trash" style="font-size: 18px;"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Get modal and elements
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const downloadOriginal = document.getElementById('downloadOriginal');
    const closeModal = document.getElementsByClassName('close')[0];

    // Handle button click to open modal for images
    document.querySelectorAll('.view-image-btn').forEach(button => {
        button.addEventListener('click', function() {
            const imageUrl = this.getAttribute('data-image');
            const fileUrl = this.getAttribute('data-file');
            modalImage.src = imageUrl;
            downloadOriginal.href = fileUrl;
            modal.style.display = 'block';
        });
    });

    // Close modal when clicking the close button
    closeModal.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Close modal when clicking outside the modal content
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
</script>
@endsection