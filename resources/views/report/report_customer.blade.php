@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">

    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

@section('title')
    Customer Reports
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Reports</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/Customer
                Reports
            </span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')

<!-- row -->
<div class="row">

    <div class="col-xl-12">
        <div class="card mg-b-20">


            <div class="card-header pb-0">

                <form action="/report/sereach_customer" method="POST" role="search" autocomplete="off">
                    @csrf

                    <div class="row">

                        <div class="col">
                            <label for="inputName" class="control-label">Section</label>
                            <select name="Section" class="form-control select2">
                                <option value="" selected disabled>Select Section</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->name_section }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                            <label for="inputName" class="control-label">Product</label>
                            <select id="product" name="product" class="form-control select2">
                            </select>
                        </div>

                        <div class="col-lg-3" id="start_at">
                            <label for="exampleFormControlSelect1">From Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div><input class="form-control fc-datepicker" value="{{ $start_at ?? '' }}"
                                    name="start_at" placeholder="YYYY-MM-DD" type="text">
                            </div><!-- input-group -->
                        </div>

                        <div class="col-lg-3" id="end_at">
                            <label for="exampleFormControlSelect1">To Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div><input class="form-control fc-datepicker" name="end_at"
                                    value="{{ $end_at ?? '' }}" placeholder="YYYY-MM-DD" type="text">
                            </div><!-- input-group -->
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-sm-2 col-md-2">
                            <button class="btn btn-primary btn-block">Sereach</button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if (isset($invoices))
                        <table id="example" class="table key-buttons text-md-nowrap" style=" text-align: center">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">Invoice_number</th>
                                    <th class="border-bottom-0">invoice_date</th>
                                    <th class="border-bottom-0">due_date</th>
                                    <th class="border-bottom-0">product</th>
                                    <th class="border-bottom-0">section</th>
                                    <th class="border-bottom-0">discount</th>
                                    <th class="border-bottom-0">rate_vat</th>
                                    <th class="border-bottom-0">value_vat</th>
                                    <th class="border-bottom-0">total</th>
                                    <th class="border-bottom-0">status</th>
                                    <th class="border-bottom-0">note</th>
                                    <th class="border-bottom-0">operation</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 0; ?>
                                @foreach ($invoices as $invoice)
                                    <?php $count++; ?>
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td><a
                                                href="details/{{ $invoice->id }}">{{ $invoice->invoice_number }}</a>
                                        </td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>{{ $invoice->product->name }}</td>
                                        <td>{{ $invoice->section->name_section }}</td>
                                        <td>{{ $invoice->discount }}</td>
                                        <td>{{ $invoice->rate_vat }}</td>
                                        <td>{{ $invoice->value_vat }}</td>
                                        <td>{{ $invoice->total }}</td>
                                        <td>{!! $invoice->value_status !!}</td>
                                        <td>{{ $invoice->note }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                    type="button">Operation<i
                                                        class="fas fa-caret-down ml-1"></i></button>
                                                <div class="dropdown-menu tx-13">

                                                    <a class="dropdown-item"
                                                        href=" {{ url('/invoices/edit_invoice') }}/{{ $invoice->id }}">
                                                        Edit Invoice</a>


                                                    <a class="dropdown-item" href="#"
                                                        data-invoice_id="{{ $invoice->id }}" data-toggle="modal"
                                                        data-target="#delete_invoice"
                                                        data-invoice_number="{{ $invoice->invoice_number }}">
                                                        <i class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;
                                                        Delete Invoices</a>


                                                    <a class="dropdown-item" data-invoice_id="{{ $invoice->id }}"
                                                        data-toggle="modal" data-target="#payment_status"><i
                                                            class=" text-success fas fa-money-bill"></i>&nbsp;&nbsp;
                                                        Payment Status
                                                    </a>


                                                    <a class="dropdown-item" href="#"
                                                        data-invoice_id="{{ $invoice->id }}" data-toggle="modal"
                                                        data-target="#Transfer_invoice"><i
                                                            class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;
                                                        Archive Invoices
                                                    </a>


                                                    <a class="dropdown-item"
                                                        href="Print_invoice/{{ $invoice->id }}"><i
                                                            class="text-success fas fa-print"></i>&nbsp;&nbsp;
                                                        Print Invoice
                                                    </a>

                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                    @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Archive Invoices  -->
    <div class="modal fade" id="Transfer_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Archive Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/invoices/addArchive" method="post">
                    @csrf
                    <div class="modal-body">
                        Are You Sure for Archive Invoice
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                        <button type="submit" class="btn btn-primary">Archive</button>
                    </div>
                </form>
            </div>
        </div>
    </div>






    <!-- Delete Invoices  -->
    <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Delete Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/invoices/destoryInvoices" method="post">
                    @csrf
                    <div class="modal-body">
                        Are You Sure for Delete Invoice
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                        <input type="text" name="invoice_number" id="invoice_number" value="" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <!-- Payment Status  -->
    <div class="modal fade" id="payment_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Payment Status </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/invoices/update_details" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" value="" id="invoice_id" name="invoice_id">
                        <label for="inputName" class="control-label">Select payment Status</label>
                        <select name="payment_status" class="form-control SlectBox" required>
                            <option value="" selected disabled>select Status</option>
                            <option value="1">Not Paid</option>
                            <option value="2">Paid</option>
                            <option value="3">Paid partial</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
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

<!--Internal  Datepicker js -->
<script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<!--Internal  jquery.maskedinput js -->
<script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
<!--Internal  spectrum-colorpicker js -->
<script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
<!-- Internal Select2.min js -->
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!--Internal Ion.rangeSlider.min js -->
<script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
<!--Internal  jquery-simple-datetimepicker js -->
<script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
<!-- Ionicons js -->
<script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
<!--Internal  pickerjs js -->
<script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
<!-- Internal form-elements js -->
<script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
<script>
    var date = $('.fc-datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    }).val();
</script>

<script>
    $(document).ready(function() {



        $('select[name="Section"]').on('change', function() {

            var selectId = $(this).val();
            if (selectId) {
                $.ajax({
                    type: "GET",
                    url: "{{ URL('report/send_product_AJAX') }}/" + selectId,
                    data: "json",
                    success: function(response) {
                        $('select[name="product"]').empty();
                        $('select[name="product"]').append(
                        '<option selected value="All">All</option>')
                        $.each(response, function(index, value) {
                            $('select[name="product"]')
                                .append('<option value="' + response[index]['id'] +
                                    '">' +
                                    response[index]["name"] + '</option>')
                        });
                    }
                });
            } else {

            }

        });








        $("#delete_invoice").on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var invoice_id = button.data('invoice_id');
            var invoice_number = button.data('invoice_number');

            var modal = $(this);
            modal.find('.modal-body #invoice_id').val(invoice_id);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        });


        $('#payment_status').on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget);
            var invoice_id = button.data('invoice_id');

            var modal = $(this);
            modal.find('.modal-body #invoice_id').val(invoice_id);
        });


        $('#Transfer_invoice').on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget);
            var invoice_id = button.data('invoice_id');

            var modal = $(this);
            modal.find('.modal-body #invoice_id').val(invoice_id);
        });
    });
</script>


@endsection
