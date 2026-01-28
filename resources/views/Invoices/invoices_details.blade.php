@extends('layouts.master')
@section('title')
    INVOICES DETAILS
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <a href="{{ url()->previous() }}" class="previous">&laquo; Previous</a>
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل
                    الفواتير</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('ADD'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('ADD') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="panel panel-primary tabs-style-3">
        <div class="tab-menu-heading">
            <div class="tabs-menu">
                <!-- Tabs -->
                <ul class="nav panel-tabs">
                    <li><a href="#tab11" class="active" data-toggle="tab"><i class="fa fa-file-invoice"></i> الفواتير</a>
                    </li>
                    <li><a href="#tab12" data-toggle="tab"><i class="fa fa-info-circle"></i> تفاصيل الفواتير</a></li>
                    <li><a href="#tab13" data-toggle="tab"><i class="fa fa-paperclip"></i> المرفقات</a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body tabs-menu-body">
            <div class="tab-content">
                <!-- Tab 1: الفواتير -->
                <div class="tab-pane active" id="tab11">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table key-buttons text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">#</th>
                                        <th class="border-bottom-0">رقم الفاتورة</th>
                                        <th class="border-bottom-0">تاريخ الفاتورة</th>
                                        <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                        <th class="border-bottom-0">القسم</th>
                                        <th class="border-bottom-0">المنتج</th>
                                        <th class="border-bottom-0">مبلغ التحصيل</th>
                                        <th class="border-bottom-0">مبلغ العمولة</th>
                                        <th class="border-bottom-0">الخصم</th>
                                        <th class="border-bottom-0">نسبة الضريبة</th>
                                        <th class="border-bottom-0">قيمة الضريبة</th>
                                        <th class="border-bottom-0">الإجمالي</th>
                                        <th class="border-bottom-0">الحالة</th>
                                        <th class="border-bottom-0">المستخدم</th>
                                        <th class="border-bottom-0">ملاحظات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($invoice as $inv) --}}
                                        <tr>
                                            <td>{{ $inv->id }}</td>
                                            <td>{{ $inv->invoice_number }}</td>
                                            <td>{{ $inv->invoice_Date }}</td>
                                            <td>{{ $inv->Due_date }}</td>
                                            <td>{{ $inv->section->section_name }}</td>
                                            <td>{{ $inv->product }}</td>
                                            <td>{{ $inv->Amount_collection }}</td>
                                            <td>{{ $inv->Amount_Commission }}</td>
                                            <td>{{ $inv->Discount }}</td>
                                            <td>{{ $inv->Rate_VAT }}</td>
                                            <td>{{ $inv->Value_VAT }}</td>
                                            <td>{{ $inv->Total }}</td>
                                            <td>
                                                @if ($inv->Value_Status == 1)
                                                    <span class="badge badge-success">{{ $inv->Status }}</span>
                                                @elseif($inv->Value_Status == 2)
                                                    <span class="badge badge-danger">{{ $inv->Status }}</span>
                                                @else
                                                    <span class="badge badge-warning">{{ $inv->Status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ Auth::user()->name ?? '-' }}</td>
                                            <td>{{ $inv->note ?? '-' }}</td>
                                        </tr>
                                    {{-- @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: تفاصيل الفواتير -->
                <div class="tab-pane" id="tab12">
                    <div class="card-body">
                        <div class="table-responsive mt-15">
                            <table class="table table-striped center table-bordered" style="text-align:center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">رقم الفاتورة</th>
                                        <th scope="col">المنتج</th>
                                        <th scope="col">القسم</th>
                                        <th scope="col">الحالة</th>
                                        <th scope="col">تاريخ الدفع</th>
                                        <th scope="col">الملاحظات</th>
                                        <th scope="col">تاريخ الإضافة</th>
                                        <th scope="col">المستخدم</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $detail)
                                        <tr>
                                            <td>{{ $detail->id }}</td>
                                            <td>{{ $detail->invoice_number }}</td>
                                            <td>{{ $detail->product }}</td>
                                            <td>{{ $detail->invoices->section->section_name ?? '-' }}</td>
                                            <td>
                                                @if ($detail->Value_Status == 1)
                                                    <span class="badge badge-success">{{ $detail->Status }}</span>
                                                @elseif($detail->Value_Status == 2)
                                                    <span class="badge badge-danger">{{ $detail->Status }}</span>
                                                @else
                                                    <span class="badge badge-warning">{{ $detail->Status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $detail->Payment_Date ?? 'لم يتم الدفع' }}</td>
                                            <td>{{ $detail->note ?? '-' }}</td>
                                            <td>{{ $detail->created_at }}</td>
                                            <td>{{ $detail->user }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: المرفقات -->
                <div class="tab-pane" id="tab13">
                    <div class="card-body">
                        <div class="card-body">
                            <div class="col-lg-12 col-md-12">
                                <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                <h5 class="card-title">اضافة مرفقات</h5>
                                <form method="post" action="{{ url('/InvoiceAttachments') }}"
                                    enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="invoice_number"
                                        value="{{ $inv->invoice_number }}">
                                    <input type="hidden" name="invoice_id"
                                        value="{{ $inv->id }}">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="file_name"
                                            required>
                                        <label class="custom-file-label" for="customFile">حدد
                                            المرفق</label>
                                    </div><br><br>
                                    <button type="submit" class="btn btn-primary btn-sm "
                                        name="uploadedFile">تاكيد</button>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped center table-bordered" style="text-align:center">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">#</th>
                                        <th class="border-bottom-0">رقم الفاتورة</th>
                                        <th class="border-bottom-0">اسم الملف</th>
                                        <th class="border-bottom-0">المستخدم</th>
                                        <th class="border-bottom-0">تاريخ الإنشاء</th>
                                        <th class="border-bottom-0">العمليات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @if ($inv->attachments->count() > 0)
                                            @foreach ($inv->attachments as $attachment)
                                                <tr>
                                                    <td>{{ $attachment->id }}</td>
                                                    <td>{{ $inv->invoice_number }}</td>
                                                    <td>{{ $attachment->file_name }}</td>
                                                    <td>{{ $attachment->Created_by }}</td>
                                                    <td>{{ $attachment->created_at }}</td>
                                                    <td colspan="2">

                                                        <a class="btn btn-outline-success btn-sm"
                                                            href="{{ url('View_file') }}/{{ $inv->invoice_number }}/{{ $attachment->file_name }}"
                                                            role="button"><i class="fas fa-eye"></i>&nbsp;
                                                            عرض</a>

                                                        <a class="btn btn-outline-info btn-sm"
                                                            href="{{ url('download') }}/{{ $inv->invoice_number }}/{{ $attachment->file_name }}"
                                                            role="button"><i class="fas fa-download"></i>&nbsp;
                                                            تحميل</a>


                                                        <button class="btn btn-outline-danger btn-sm" data-toggle="modal"
                                                            data-file_name="{{ $attachment->file_name }}"
                                                            data-invoice_number="{{ $attachment->invoice_number }}"
                                                            data-id_file="{{ $attachment->id }}"
                                                            data-target="#delete_file">حذف</button>


                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @if (
                                        $invoices->sum(function ($inv) {
                                            return $inv->invoices->attachments->count();
                                        }) == 0)
                                        <tr>
                                            <td colspan="5" class="text-center">لا توجد مرفقات</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- delete -->
    <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('delete_file') }}" method="post">

                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                        </p>

                        <input type="hidden" name="id_file" id="id_file" value="">
                        <input type="hidden" name="file_name" id="file_name" value="">
                        <input type="hidden" name="invoice_number" id="invoice_number" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)

            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })

        // عرض اسم الملف المختار
        $('#customFile').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).siblings('.custom-file-label').text(fileName || 'حدد المرفق');
        })
    </script>
@endsection
