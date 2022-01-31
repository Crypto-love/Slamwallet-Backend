@extends('standard.layout')

@section('content')

<div id="content" class="main-content">
    @if ($message = Session::get('destroy'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{{$message}}</strong> 
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{{$message}}</strong> 
        </div>
    @endif
            <div class="layout-px-spacing">
                <div class="row layout-top-spacing" id="cancel-row">
                    
                    <div class="col-xl-12 col-lg-12 col-smf-12 layout-spacing skills">
                        <div class="widget-content widget-content-area br-6">
                            <div class="table-responsive mb-4 mt-4">
                                <div id="multi-column-ordering_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="userTable" class="table table-hover dataTable text-left" style="width: 100%;" role="grid" aria-describedby="multi-column-ordering_info">
                                                <h3>User History</h3>
                                                <div class="text-right">
                                                    <a class="btn btn-info text-white" href="{{route('admin.historyRecord')}}">Back</a>
                                                </div>
                                                <br>

                                                <thead>
                                                    <tr role="row">
                                                        <th>No</th>
                                                        <th>Email</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($usersPerDay) > 0)
                                                    @foreach($usersPerDay as $key=>$temp) 
                                                    <tr>
                                                        <td>{{ (++$key) }}</td>
                                                        <td><a href="{{route('admin.profile', ['user_id' => $temp['id']] )}}">{{$temp->email}}</a></td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                <tbody>
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
    
@endsection
@section('script')
<script>
    $('#userTable').DataTable({
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7,
        columnDefs: [ {
            targets: [ 0 ],
            orderData: [ 0, 1 ]
        }, {
            targets: [ 1 ],
            orderData: [ 1, 0 ]
        }]
    });
</script>
@endsection