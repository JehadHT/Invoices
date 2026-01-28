@extends('layouts.master')
@section('title')
    الفواتير 
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                    الفواتير</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('delete_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم حذف الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif

    @if (session()->has('Archive_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم أرشفة الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif

    @if (session()->has('Change_Status'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم تعديل حالة الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('edit') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card mg-b-20">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                <a href="invoices/create" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                        class="fas fa-plus"></i>&nbsp; اضافة فاتورة</a>
                {{-- <h4 class="card-title mg-b-0">الفواتير</h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i> --}}
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table key-buttons text-md-nowrap">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">رقم الفاتورة</th>
                            <th class="border-bottom-0">تاريخ الفاتورة</th>
                            <th class="border-bottom-0">تاريخ الاستحقاق</th>
                            <th class="border-bottom-0">المنتج</th>
                            <th class="border-bottom-0">القسم</th>
                            <th class="border-bottom-0">الخصم</th>
                            <th class="border-bottom-0">نسبة الضريبة</th>
                            <th class="border-bottom-0">الإجمالي</th>
                            <th class="border-bottom-0">الحالة</th>
                            <th class="border-bottom-0">العمليات</th>
                            <th class="border-bottom-0">ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @foreach ($invoices as $inv)
                            <?php $i++; ?>
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $inv->invoice_number }}</td>
                                <td>{{ $inv->invoice_Date }}</td>
                                <td>{{ $inv->Due_date }}</td>
                                <td>{{ $inv->product }}</td>
                                <td><a href="{{ url('invoices_details') }}/{{ $inv->id }}">{{ $inv->section->section_name }}
                                    </a></td>
                                <td>{{ $inv->Discount }}</td>
                                <td>{{ $inv->Rate_VAT }}</td>
                                <td>{{ $inv->Total }}</td>
                                <td>
                                    @if ($inv->Value_Status == 1)
                                        <span class="text-success">{{ $inv->Status }}</span>
                                    @elseif($inv->Value_Status == 2)
                                        <span class="text-danger">{{ $inv->Status }}</span>
                                    @else
                                        <span class="text-warning">{{ $inv->Status }}</span>
                                    @endif
                                </td>
                                {{-- العمليات --}}
                                <td>
                                    <div class="dropdown">
                                        <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-info"
                                            data-toggle="dropdown" type="button">العمليات<i
                                                class="fas fa-caret-down ml-1"></i></button>
                                        <div class="dropdown-menu tx-13">
                                            <h6 class="dropdown-header tx-uppercase tx-11 tx-bold tx-inverse tx-spacing-1">
                                                Dropdown header</h6>
                                            {{-- تعديل الفاتورة --}}
                                            <a class="dropdown-item"
                                                href="{{ url('edit_invoices') }}/{{ $inv->id }}"><i
                                                    class="text-primary fas fa-edit"></i>&nbsp;&nbsp;تعديل الفاتورة</a>
                                            {{-- حذف الفاتورة --}}
                                            <a class="dropdown-item" href="#" data-invoice_id="{{ $inv->id }}"
                                                data-type="delete" data-toggle="modal" data-target="#delete_invoice"><i
                                                    class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                                الفاتورة</a>
                                            {{-- تغيير حالة الدفع --}}
                                            <a class="dropdown-item"
                                                href="{{ url('change_Status') }}/{{ $inv->id }}"><i
                                                    class=" text-success fas fa-money-bill"></i>&nbsp;&nbsp;تغيير حالة
                                                الدفع</a>
                                            {{-- أرشفة الفاتورة --}}
                                            <a class="dropdown-item" href="#" data-invoice_id="{{ $inv->id }}"
                                                data-type="archive" data-toggle="modal" data-target="#Archive_invoice"><i
                                                    class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;أرشفة
                                                الفاتورة</a>
                                            {{-- طباعة فاتورة --}}
                                            <a class="dropdown-item"
                                                href="{{ url('print_invoice') }}/{{ $inv->id }}"><i
                                                    class=" text-success fas fa-money-bill"></i>&nbsp;&nbsp;طباعة فاتورة</a>
                                        </div>
                                    </div>

                                </td>
                                <td>{{ $inv->note }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /row -->
        </div>
        <!-- Container closed -->
    </div>
    <!-- main-content closed -->

    <!-- حذف الفاتورة -->
    <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    هل انت متاكد من عملية الحذف ؟
                    <input type="hidden" name="invoice_id" id="invoice_id" value="">
                    <input type="hidden" name="type" id="type" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">تاكيد</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- أرشفة الفاتورة -->
    <div class="modal fade" id="Archive_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">أرشفة الفاتورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    هل انت متاكد من عملية الأرشفة ؟
                    <input type="hidden" name="invoice_id" id="invoice_id" value="">
                    <input type="hidden" name="type" id="type" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
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
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    <script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var type = button.data('type')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
            modal.find('.modal-body #type').val(type);
        })

        $('#Archive_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var type = button.data('type')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
            modal.find('.modal-body #type').val(type);
        })
    </script>
@endsection
