@section('title')

    طباعة الفاتورة{{ $invoice->invoice_number ?? '' }}
@endsection
@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/css/print_invoice.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    طباعة الفاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice">
                <div class="card card-invoice">
                    <div id="print" class="card-body">
                        <div class="invoice-header">
                            <h1 class="invoice-title">فاتورة / Invoice</h1>
                            <div class="billed-from">
                                <h5>{{ auth()->user()->name ?? 'الشركة' }}</h5>
                                <p>
                                    <strong>رقم الفاتورة:</strong> {{ $invoice->invoice_number }}<br>
                                    <strong>التاريخ:</strong>
                                    {{ \Carbon\Carbon::parse($invoice->invoice_Date)->format('d/m/Y') }}<br>
                                    <strong>تاريخ الاستحقاق:</strong>
                                    {{ \Carbon\Carbon::parse($invoice->Due_date)->format('d/m/Y') }}
                                </p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="label-info">تم الفوترة إلى / Billed To</label>
                                <div class="billed-to">
                                    <h6>{{ $invoice->section->section_name ?? 'قسم' }} -
                                        {{ $invoice->clientName ?? 'اسم العميل' }}</h6>
                                    <p>
                                        <strong>الحالة:</strong>
                                        @if ($invoice->status == 'paid')
                                            <span class="badge badge-success">مدفوعة</span>
                                        @elseif($invoice->status == 'pending')
                                            <span class="badge badge-warning">قيد الانتظار</span>
                                        @elseif($invoice->status == 'partially_paid')
                                            <span class="badge badge-info">مدفوعة جزئياً</span>
                                        @else
                                            <span class="badge badge-danger">ملغاة</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md">
                                <label class="label-info">معلومات الفاتورة / Invoice Information</label>
                                <p class="invoice-info-row"><span>رقم الفاتورة</span>
                                    <span>{{ $invoice->invoice_number }}</span>
                                </p>
                                <p class="invoice-info-row"><span>تاريخ الفاتورة</span>
                                    <span>{{ \Carbon\Carbon::parse($invoice->invoice_Date)->format('d/m/Y') }}</span>
                                </p>
                                <p class="invoice-info-row"><span>تاريخ الاستحقاق</span>
                                    <span>{{ \Carbon\Carbon::parse($invoice->Due_date)->format('d/m/Y') }}</span>
                                </p>
                                <p class="invoice-info-row"><span>القسم</span>
                                    <span>{{ $invoice->section->section_name ?? 'عام' }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="wd-5p">#</th>
                                        <th class="wd-25p">المنتج / Product</th>
                                        <th class="tx-right wd-12p">مبلغ التحصيل</th>
                                        <th class="tx-right wd-12p">مبلغ العمولة</th>
                                        <th class="tx-right wd-12p">الخصم</th>
                                        <th class="tx-right wd-12p">الضربية</th>
                                        <th class="tx-right wd-12p">الإجمالي</th>
                                        <th class="tx-right wd-12p">الإجمالي شامل الضريبة</th>
                                        <th class="tx-center wd-12p">الحالة</th>
                                        <th class="tx-center wd-14p">تاريخ الدفع</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($invoice->details && count($invoice->details) > 0)
                                        @php
                                            $i = 1;
                                        $total = $invoice->Amount_Commission - $invoice->Discount;
                                        @endphp
                                        @foreach ($details as $detail)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>
                                                    <strong>{{ $detail->product }}</strong><br>
                                                    <small class="text-muted">{{ $detail->description ?? '' }}</small>
                                                </td>
                                                <td class="tx-center">
                                                    {{ number_format($invoice->Amount_collection ?? 0, 2) }}</td>
                                                <td class="tx-right">
                                                    {{ number_format($invoice->Amount_Commission ?? 0, 2) }}</td>
                                                <td class="tx-right">{{ number_format($invoice->Discount ?? 0, 2) }}</td>
                                                <td class="tx-right">{{ $invoice->Value_VAT ?? 0 }}</td>
                                                <td class="tx-right">
                                                    <strong>{{ number_format($total, 2) }}</strong>
                                                </td>
                                                <td class="tx-right">{{ $invoice->Total ?? 0 }}</td>
                                                <td class="tx-center">
                                                    @if ($detail->Status == 'مدفوعة' || $detail->Value_Status == 1)
                                                        <span class="badge badge-success" style="font-size: 11px;">✓
                                                            مدفوعة</span>
                                                    @elseif($detail->Status == 'غير مدفوعة' || $detail->Value_Status == 2)
                                                        <span class="badge badge-danger" style="font-size: 11px;">غير مدفوعة</span>
                                                    @elseif($detail->Status == 'مدفوعة جزئياً' || $detail->Value_Status == 3)
                                                        <span class="badge badge-info" style="font-size: 11px;">◐
                                                            جزئياً</span>
                                                    @else
                                                        <span class="badge badge-danger" style="font-size: 11px;">✕
                                                            ملغاة</span>
                                                    @endif
                                                </td>
                                                <td class="tx-center">
                                                    @if ($detail->Payment_Date)
                                                        <small>{{ \Carbon\Carbon::parse($detail->Payment_Date)->format('d/m/Y') }}</small>
                                                    @else
                                                        <small class="text-muted">---</small>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                <i class="mdi mdi-information"></i> لا توجد تفاصيل للفاتورة
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row mg-t-40">
                            <div class="col-md-8">
                                @if ($invoice->note)
                                    <div class="invoice-notes">
                                        <label class="main-content-label tx-13"><strong>ملاحظات / Notes</strong></label>
                                        <p>{{ $invoice->note }}</p>
                                    </div><!-- invoice-notes -->
                                @endif
                                <div style="margin-top: 20px;">
                                    <p><strong>حالة الفاتورة:</strong>
                                        @if ($invoice->Status == 'مدفوعة' || $invoice->Value_Status == 1)
                                            <span class="badge badge-success">✓ مدفوعة</span>
                                        @elseif($invoice->Status == 'قيد الانتظار' || $invoice->Value_Status == 2)
                                            <span class="badge badge-warning">⏳ قيد الانتظار</span>
                                        @elseif($invoice->Status == 'مدفوعة جزئياً' || $invoice->Value_Status == 3)
                                            <span class="badge badge-info">◐ مدفوعة جزئياً</span>
                                        @else
                                            <span class="badge badge-danger">✕ ملغاة</span>
                                        @endif
                                    </p>
                                    @if ($invoice->Payment_Date)
                                        <p><strong>تاريخ الدفع:</strong>
                                            {{ \Carbon\Carbon::parse($invoice->Payment_Date)->format('d/m/Y') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <table class="table table-sm" style="font-size: 14px;">
                                    <tbody>
                                        <tr class="total-row">
                                            <td><strong>المبلغ المستحق</strong></td>
                                            <td class="tx-right">
                                                <strong>{{ number_format($invoice->Amount_collection ?? 0, 2) }}</strong>
                                            </td>
                                        </tr>
                                        <tr class="total-row">
                                            <td><strong>العمولة</strong></td>
                                            <td class="tx-right">
                                                <strong>{{ number_format($invoice->Amount_Commission ?? 0, 2) }}</strong>
                                            </td>
                                        </tr>
                                        <tr class="total-row">
                                            <td><strong>الضريبة ({{ $invoice->Rate_VAT ?? 0 }})</strong></td>
                                            <td class="tx-right">
                                                <strong>{{ number_format($invoice->Value_VAT ?? 0, 2) }}</strong>
                                            </td>
                                        </tr>
                                        <tr class="total-row">
                                            <td><strong>الخصم</strong></td>
                                            <td class="tx-right">
                                                <strong>{{ number_format($invoice->Discount ?? 0, 2) }}</strong>
                                            </td>
                                        </tr>
                                        <tr class="total-due-row">
                                            <td><strong>الإجمالي النهائي</strong></td>
                                            <td class="tx-right">
                                                <strong>{{ number_format($invoice->Total ?? 0, 2) }}</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr class="mg-b-40">
                        <div class="no-print text-center">
                            <button type="button" class="btn btn-primary" onclick="printDiv()">
                                <i class="mdi mdi-printer ml-1"></i>طباعة
                            </button>
                            <a href="{{ route('invoices.index') }}" class="btn btn-secondary ml-2">
                                <i class="mdi mdi-arrow-left ml-1"></i>رجوع
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    
    <script type="text/javascript">
        function printDiv() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }

    </script>
@endsection
