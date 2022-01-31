@extends('standard.layout')

@section('content')

<div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-smf-12  layout-spacing skills">
                    <div class="widget-content widget-content-area br-6">
                        <div class="table-responsive mb-4 mt-4">
                            <div id="multi-column-ordering_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h3>Bulk Emails</h3>
                                        <br />
                                        <div>
                                            <form method="post" action="{{route('admin.sendBulkEmail')}}">
                                                @csrf
                                                <div class="form-group">
                                                    <label class="form">Subject:&nbsp;</label>
                                                    <input name="emailSubject" type="text" class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="form">Content:&nbsp;</label>
                                                    <textarea class="form-control" rows="10" name="emailContent"></textarea>
                                                </div>
                                                <div class="text-right">
                                                    <button class="btn btn-primary" type="submit">Submit</button>
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
   
@endsection