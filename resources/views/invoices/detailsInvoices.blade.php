@extends('layouts.master')
@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection
@section('title')
    Details Inovice
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Invoice</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Details Inovice</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')




    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ $error }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endforeach
    @endif


    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif



    <!-- row opened -->
    <div class="row row-sm">

        <div class="col-xl-12">
            <!-- div -->
            <div class="card mg-b-20" id="tabs-style2">
                <div class="card-body">
                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-2">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li><a href="#tab4" class="nav-link active" data-toggle="tab">
                                                    Invoice Information</a></li>
                                            <li><a href="#tab5" class="nav-link" data-toggle="tab">Status Inovice</a></li>
                                            <li><a href="#tab6" class="nav-link" data-toggle="tab">Attachments</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                    <div class="tab-content">


                                        <div class="tab-pane active" id="tab4">
                                            <div class="table-responsive mt-15">

                                                <table class="table table-striped" style="text-align:center">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">invoice number</th>
                                                            <td>{{ $invoices->invoice_number }}</td>
                                                            <th scope="row">invoice date</th>
                                                            <td>{{ $invoices->invoice_date }}</td>
                                                            <th scope="row">due date</th>
                                                            <td>{{ $invoices->due_date }}</td>
                                                            <th scope="row">Section</th>
                                                            <td>{{ $invoices->Section->name_section }}</td>
                                                        </tr>

                                                        <tr>
                                                            <th scope="row">product</th>
                                                            <td>{{ $invoices->product->name }}</td>
                                                            <th scope="row">Amount collection</th>
                                                            <td>{{ $invoices->Amount_collection }}</td>
                                                            <th scope="row">Amount Commission</th>
                                                            <td>{{ $invoices->Amount_Commission }}</td>
                                                            <th scope="row">Discount</th>
                                                            <td>{{ $invoices->discount }}</td>
                                                        </tr>


                                                        <tr>
                                                            <th scope="row">rate vat</th>
                                                            <td>{{ $invoices->rate_vat }}</td>
                                                            <th scope="row">value vat</th>
                                                            <td>{{ $invoices->value_vat }}</td>
                                                            <th scope="row">total</th>
                                                            <td>{{ $invoices->total }}</td>
                                                            <th scope="row">الحالة الحالية</th>
                                                            <td>{!! $invoices->value_status !!}</td>
                                                        </tr>

                                                        <tr>
                                                            <th scope="row">Note</th>
                                                            <td>{{ $invoices->note }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>


                                        <div class="tab-pane" id="tab5">
                                            <div class="table-responsive mt-15">
                                                <table class="table center-aligned-table mb-0 table-hover"
                                                    style="text-align:center">
                                                    <thead>
                                                        <tr class="text-dark">
                                                            <th>#</th>
                                                            <th>invoice id</th>
                                                            <th>value status</th>
                                                            <th>note</th>
                                                            <th>created at </th>
                                                            <th>created by</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $count = 0; ?>
                                                        @foreach ($invoices_details as $invoice_det)
                                                            <?php $count++; ?>
                                                            <tr>
                                                                <td>{{ $count }}</td>
                                                                <td>{{ $invoice_det->invoices->invoice_number }}</td>
                                                                <td>{!! $invoice_det->value_status !!}</td>
                                                                <td>{{ $invoice_det->note }}</td>
                                                                <td>{{ $invoice_det->created_at }}</td>
                                                                <td>{{ $invoice_det->invoices->created_by }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>


                                            </div>
                                        </div>




                                        <div class="tab-pane" id="tab6">
                                            <!--المرفقات-->
                                            <div class="card card-statistics">
                                                <div class="card-body">
                                                    <p class="text-danger">* file Extension .jpeg ,.jpg , png </p>
                                                    <h5 class="card-title">اضافة مرفقات</h5>
                                                    <form method="post" action="/invoices/storeAttachment"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="customFile"
                                                                name="file_name" required>
                                                            <input type="hidden" id="customFile" name="invoice_number"
                                                                value="{{ $invoices->invoice_number }}">
                                                            <input type="hidden" id="invoice_id" name="invoice_id"
                                                                value="{{ $invoices->id }}">
                                                            <label class="custom-file-label" for="customFile">
                                                                choose File</label>
                                                        </div><br><br>
                                                        <button type="submit" class="btn btn-primary btn-sm "
                                                            name="uploadedFile">Add</button>
                                                    </form>
                                                </div>
                                                <br>

                                                <div class="table-responsive mt-15">
                                                    <table class="table center-aligned-table mb-0 table table-hover"
                                                        style="text-align:center">
                                                        <thead>
                                                            <tr class="text-dark">
                                                                <th scope="col">م</th>
                                                                <th scope="col">اسم الملف</th>
                                                                <th scope="col">قام بالاضافة</th>
                                                                <th scope="col">تاريخ الاضافة</th>
                                                                <th scope="col">العمليات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 0; ?>
                                                            @foreach ($invoices_attachments as $attachment)
                                                                <?php $i++; ?>
                                                                <tr>
                                                                    <td>{{ $i }}</td>
                                                                    <td>{{ $attachment->file_name }}</td>
                                                                    <td>{{ $attachment->invoices->created_by }}</td>
                                                                    <td>{{ $attachment->created_at }}</td>
                                                                    <td colspan="2">

                                                                        <a class="btn btn-outline-success btn-sm"
                                                                            href="{{ url('invoices/View_file') }}/{{ $attachment->invoices_id }}/{{ $attachment->file_name }}"
                                                                            target="_blank" role="button"><i
                                                                                class="fas fa-eye"></i>&nbsp;
                                                                            View</a>

                                                                        <a class="btn btn-outline-info btn-sm"
                                                                            href="{{ url('invoices/download') }}/{{ $attachment->invoices_id }}/{{ $attachment->file_name }}"
                                                                            role="button"><i
                                                                                class="fas fa-download"></i>&nbsp;
                                                                            Download</a>

                                                                        <button class="btn btn-outline-danger btn-sm"
                                                                            data-toggle="modal"
                                                                            data-id_file="{{ $attachment->id }}"
                                                                            data-file_name="{{ $attachment->file_name }}"
                                                                            data-invoices_id="{{ $attachment->invoices_id }}"
                                                                            data-target="#delete_file">Delete</button>

                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>




                                        <!-- delete -->
                                        <div class="modal fade" id="delete_file" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ url('invoices/destroy') }}" method="post">

                                                        @csrf
                                                        <div class="modal-body">
                                                            <p class="text-center">
                                                            <h6 style="color:red"> Are You Sure for Delete this File</h6>
                                                            </p>
                                                            <input type="text" class="btn btn-default" readonly
                                                                name="file_name" id="file_name">
                                                            <input type="hidden" name="id_file" id="id_file" value="">
                                                            <input type="hidden" name='invoices_id' id="invoices_id"
                                                                value="">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /div -->
        </div>

    </div>
    <!-- /row -->

    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>

    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name');
            var invoices_id = button.data('invoices_id');
            var modal = $(this)
            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoices_id').val(invoices_id);

        })
    </script>


@endsection
