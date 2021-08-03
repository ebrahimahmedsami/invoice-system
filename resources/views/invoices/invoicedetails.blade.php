@extends('layouts.master')
@section('title')
    تفاصيل فاتورة
@stop
@section('css')
    <!---Internal  Prism css-->
    <link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{URL::asset('assets/plugins/inputtags/inputtags.css')}}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> قائمة الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل فاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    <div class="row row-sm">
        @if(\Illuminate\Support\Facades\Session::has('delete'))
            <div class="alert alert-success">
                {{\Illuminate\Support\Facades\Session::get('delete')}}
            </div>
        @endif
            @if(\Illuminate\Support\Facades\Session::has('attach_success'))
                <div class="alert alert-success">
                    {{\Illuminate\Support\Facades\Session::get('attach_success')}}
                </div>
            @endif
        <div class="col-xl-12">
            <!-- div -->
            <div class="card mg-b-20" id="tabs-style2">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        تفاصيل فاتورة
                    </div>
                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-2">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات الفاتورة</a></li>
                                            <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
                                            <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab4" style="font-size: 16px;">
                                            <div class="row">
                                                <div class="col">
                                                    <ul class="list-group">
                                                        <li class="list-group-item">
                                                            <span class="badge badge-primary">رقم الفاتورة</span>
                                                            {{$invoice->invoice_number}}</li>
                                                        <li class="list-group-item">
                                                            <span class="badge badge-primary">تاريخ الإصادار</span>
                                                            {{$invoice->invoice_date}}</li>
                                                        <li class="list-group-item">
                                                            <span class="badge badge-primary">تاريخ الإستحقاق</span>
                                                            {{$invoice->due_date}}</li>
                                                        <li class="list-group-item">
                                                            <span class="badge badge-primary">القسم</span>
                                                            {{$invoice->sections->section_name}}</li>
                                                        <li class="list-group-item">
                                                            <span class="badge badge-primary">المنتج</span>
                                                            {{$invoice->product}}</li>
                                                        <li class="list-group-item">
                                                            <span class="badge badge-primary">مبلغ التحصيل</span>
                                                            {{$invoice->amount_collection}}</li>
                                                        <li class="list-group-item">
                                                            <span class="badge badge-primary">مبلغ العمولة</span>
                                                            {{$invoice->amount_commission}}</li>
                                                    </ul>
                                                </div>
                                                <div class="col">
                                                    <ul class="list-group">
                                                        <li class="list-group-item">
                                                            <span class="badge badge-primary">الخصم</span>
                                                            {{$invoice->discount}}</li>
                                                        <li class="list-group-item">
                                                            <span class="badge badge-primary">نسبة الضريبة</span>
                                                            {{$invoice->rate_vat}}</li>
                                                        <li class="list-group-item">
                                                            <span class="badge badge-primary">قيمة الضريبة</span>
                                                            {{$invoice->value_vat}}</li>
                                                        <li class="list-group-item">
                                                            <span class="badge badge-primary">الإجمالي مع الضريبة</span>
                                                            {{$invoice->total}}</li>
                                                        <li class="list-group-item">
                                                            <span class="badge badge-primary">الحالة الحالية</span>
                                                            @if($invoice->value_status == 1)
                                                                <span class="badge badge-success">{{$invoice->status}}</span>
                                                            @elseif($invoice->value_status == 2)
                                                                <span class="badge badge-danger">{{$invoice->status}}</span>
                                                            @else
                                                                <span class="badge badge-warning">{{$invoice->status}}</span>
                                                            @endif</li>
                                                        <li class="list-group-item">
                                                            <span class="badge badge-primary">المستخدم</span>
                                                            {{$invoice->user}}</li>
                                                        <li class="list-group-item">
                                                            <span class="badge badge-primary">ملاحظات</span>
                                                            {{$invoice->note}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab5">
                                            <table class="table text-md-nowrap" id="example1" data-page-length="50">
                                                <thead>
                                                <tr>
                                                    <th class="wd-15p border-bottom-0">#</th>
                                                    <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                                    <th class="wd-15p border-bottom-0">المنتج</th>
                                                    <th class="wd-20p border-bottom-0">القسم</th>
                                                    <th class="wd-15p border-bottom-0">حالة الدفع</th>
                                                    <th class="wd-15p border-bottom-0">تاريخ الدفع</th>
                                                    <th class="wd-15p border-bottom-0">ملاحظات</th>
                                                    <th class="wd-15p border-bottom-0">تاريخ الإضافة</th>
                                                    <th class="wd-15p border-bottom-0">المستخدم</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($details as $d)
                                                    <tr>
                                                        <td>{{$d->id}}</td>
                                                        <td>{{$d->invoice_number}}</td>
                                                        <td>{{$d->product}}</td>
                                                        <td>{{$d->invoices->sections->section_name}}</td>
                                                        <td>
                                                            @if($d->value_status == 1)
                                                                <span class="badge badge-success">{{$d->status}}</span>
                                                            @elseif($d->value_status == 2)
                                                                <span class="badge badge-danger">{{$d->status}}</span>
                                                            @else
                                                                <span class="badge badge-warning">{{$d->status}}</span>
                                                            @endif
                                                        </td>
                                                        <td>{{$d->payment_date}}</td>
                                                        <td>{{$d->note}}</td>
                                                        <td>{{$d->created_at}}</td>
                                                        <td>{{$d->user}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                        <div class="tab-pane" id="tab6">
                                            <form method="post" action="{{url('attachment/add')}}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" class="form-control" name="id" value="{{$invoice->id}}">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">اضافة مرفق</label>
                                                    <input type="file" class="form-control" name="pic" required>
                                                    @error('pic')
                                                    <small class="form-text text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                                <button type="submit" class="btn btn-main-primary pd-x-20">اضافة مرفق</button>
                                            </form>

                                            <div class="table-responsive">
                                                <table class="table text-md-nowrap" id="example1" data-page-length="50">
                                                    <thead>
                                                    <tr>
                                                        <th class="wd-15p border-bottom-0">#</th>
                                                        <th class="wd-15p border-bottom-0">اسم الملف</th>
                                                        <th class="wd-15p border-bottom-0">القائم بالإضافة</th>
                                                        <th class="wd-20p border-bottom-0">تاريخ الاإضافة</th>
                                                        <th class="wd-15p border-bottom-0">العمليات</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($attachment as $a)
                                                        <tr>
                                                            <td>{{$a->id}}</td>
                                                            <td>{{$a->file_name}}</td>
                                                            <td>{{$a->user}}</td>
                                                            <td>{{$a->created_at}}</td>
                                                            <td>
                                                                <a href="{{url('view-file/'.$a->file_name)}}">
                                                                    <button class="btn btn-success">عرض</button>
                                                                </a>
                                                                <a href="{{url('download-file/'.$a->file_name)}}">
                                                                    <button class="btn btn-primary">تحميل</button>
                                                                </a>
                                                                <a href="{{url('delete-file/'.$a->id.'/'.$a->file_name)}}">
                                                                    <button class="btn btn-danger">حذف</button>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
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
        <!--/div-->
    </div>
    </div>
    </div>
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!-- Internal Select2 js-->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <!-- Internal Input tags js-->
    <script src="{{URL::asset('assets/plugins/inputtags/inputtags.js')}}"></script>
    <!--- Tabs JS-->
    <script src="{{URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js')}}"></script>
    <script src="{{URL::asset('assets/js/tabs.js')}}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{URL::asset('assets/plugins/clipboard/clipboard.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/clipboard/clipboard.js')}}"></script>
    <!-- Internal Prism js-->
    <script src="{{URL::asset('assets/plugins/prism/prism.js')}}"></script
@endsection
