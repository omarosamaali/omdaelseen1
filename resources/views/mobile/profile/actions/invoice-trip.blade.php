@extends('layouts.mobile')

@section('title', 'الفواتير | Invoices')
<link rel="stylesheet" href="{{ asset('assets/assets/css/orders.css') }}">
<link rel="stylesheet" href="{{ asset('assets/assets/css/china-discover.css') }}">

@section('content')
@if(Auth::user()->role == 'admin')
    <x-china-header :title="__('messages.الفواتير')" :route="route('mobile.admin-orders')" />
    @else
    <x-china-header :title="__('messages.الفواتير')" :route="route('mobile.orders')" />
    @endif
<div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white dark:bg-black">


    <div style="margin-top: 36px;">
        <div class="relative z-20">
            <div class="flex flex-col gap-4 pt-8" style="direction: rtl;">
                @if ($trip->invoices->isEmpty())
                <div class="bg-white dark:bg-color9 py-4 px-5 rounded-2xl shadow-md border text-center">
                    <x-empty />
                </div>
                @else
                @foreach ($trip->invoices as $invoice)
                <div class="shadow flex border justify-between items-center bg-white dark:bg-color9 py-4 px-5 rounded-2xl"
                    style="margin-left: 10px; margin-right: 10px;">
                    <div class="flex justify-start items-center gap-3">
                        <div style="display: flex; flex-direction: column; gap: 5px;">
                            <link rel="stylesheet"
                                href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.1/sweetalert2.min.css">
                            @if (Auth::user()->role == 'admin')
                            <form id="deleteInvoiceForm-{{ $invoice->id }}"
                                action="{{ route('mobile.delete-invoice', $invoice->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="confirmDelete({{ $invoice->id }})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            @endif
                            <script
                                src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.1/sweetalert2.all.min.js">
                            </script>
                            <script>
                                function confirmDelete(invoiceId) {
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "لن تتمكن من استرداد هذه الفاتورة بعد الحذف!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، احذف الفاتورة!',
            cancelButtonText: 'إلغاء',
            reverseButtons: true,
            // RTL support
            customClass: {
                container: 'swal-rtl'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'جارِ الحذف...',
                    html: 'يرجى الانتظار',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit the form
                document.getElementById('deleteInvoiceForm-' + invoiceId).submit();
            }
        });
    }
                            </script>

                            {{-- CSS للدعم العربي --}}
                            <style>
                                .swal-rtl {
                                    direction: rtl;
                                    text-align: right;
                                }

                                .swal2-popup {
                                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                                }

                                .swal2-title {
                                    font-weight: bold;
                                }
                            </style>

                            {{-- لعرض رسائل النجاح أو الخطأ بعد العودة من الـ Controller --}}
                            @if(session('success'))
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'تم الحذف!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'موافق',
            timer: 3000,
            timerProgressBar: true
        });
    });
                            </script>
                            @endif

                        </div>
                        <div style="display: flex; flex-direction: column; gap: 5px;">
                            <p class="text-xs font-semibold">
                                رقم الفاتورة
                            </p>
                            <p class="text-xs font-semibold">
                                {{ $invoice->invoice_number ?? 'غير محدد' }}
                            </p>
                        </div>
                        <div style="display: flex; flex-direction: column;">
                            <p class="text-xs font-semibold flex justify-start items-center gap-1">
                                {{ $invoice->invoice_date ?
                                \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') : 'غير محدد' }}
                            </p>
                            <p class="text-xs font-semibold flex justify-start items-center gap-1">
                                {{ $invoice->title ?? 'بدون عنوان' }}
                            </p>
                            <p style="color: gray; font-size: 13px;"
                                class="text-xs font-semibold flex justify-start items-center gap-1 pt-1">
                                {{ $invoice->user ? $invoice->user->name : 'غير محدد' }}
                            </p>
                        </div>
                    </div>
                    <div
                        class="flex justify-center items-center gap-2 bg-color16 dark:bg-bgColor14 py-1.5 px-4 rounded-full">
                        <a
                            href="{{ route('mobile.profile.actions.show_invoice-trip', ['tripId' => $trip->id, 'invoiceId' => $invoice->id]) }}">
                            <i class="fa-solid fa-eye" style="color: green;"></i>
                        </a>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection