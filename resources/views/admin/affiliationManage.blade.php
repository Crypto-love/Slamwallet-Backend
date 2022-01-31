@extends('standard.layout')

@section('content')

<div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-smf-12 layout-spacing skills">
                    <div class="widget-content widget-content-area br-6">
                        <div class="table-responsive mb-4 mt-4">
                            <div id="multi-column-ordering_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <h3>Manage Affiliation</h3>
                                        <br />
                                        <!-- <div class="text-right">
                                            <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#addRefermodal">Add</button>
                                        </div>                                         -->
                                        <table id="affiliationTable" class="table table-hover text-left" style="width:100%">
                                            <thead>
                                                <tr role="row">
                                                    <th>Time</th>
                                                    <th>User</th>
                                                    <th>User Refered</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($refers) > 0)
                                            @foreach($refers as $temp)
                                                <tr role="row">
                                                    <td>{{$temp['created_at']}}</td>
                                                    
                                                    <td>
                                                        <a href="{{route('admin.profile', $temp['user_id'])}}">{{$temp->user_refer ? $temp->user_refer->email : "Deleted"}}</a>
                                                    </td>
                                                    
                                                    <td>
                                                        <a href="{{route('admin.profile', $temp['refer_id'])}}">{{$temp->user_refered ? $temp->user_refered->email : "Deleted"}}</a>
                                                    </td>
                                                    <td>          
                                                        <a href="{{route('admin.refer.destroy', $temp->id)}}" onClick="if(!confirm('Do you really delete?')) return false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
                                                        <a href="{{route('admin.refer.edit', $temp->id)}}" class="btn btn-info">
                                                            Edit
                                                        </a>
                                                    </td>          
                                                </tr>
                                            @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="addAffilatecontent">
                                            <form action="{{ route('admin.affiliation.add')}}" method="post">
                                            @csrf
                                                <div class="referform text-center">
                                                    <h5 class="addAffilatetitle">Add New Refer</h5>
                                                </div>
                                                <div class="referform">
                                                    <div>
                                                        <label>User</label>
                                                        <select class="selectpicker form-control" data-live-search="true" name="user" id="userSelectList">
                                                            @foreach($userList as $temp)
                                                            <option value="{{$temp->id}}">{{$temp->email}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label>Refered User</label>
                                                        <select class="selectpicker form-control" data-live-search="true" name="user_refered">
                                                            @foreach($userList as $temp)
                                                            <option value="{{$temp->id}}">{{$temp->email}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="referform md-button text-center">
                                                    <button class="btn" type="button" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                                                    <button  type="submit" class="btn btn-primary">Submit</button>
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
    <div id="addRefermodal" class="modal animated slideInUp custo-slideInUp" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <!-- <div class="modal-content">
                <form action="{{ route('admin.affiliation.add')}}" method="post">
                @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Refer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-4">
                            <table>
                                <tr>
                                    <td>User</td>
                                    <td>Refered User</td>
                                </tr>
                                <tr>
                                    <td>
                                        <select class="selectpicker form-control" data-live-search="true" name="user" id="userSelectList">
                                            @foreach($userList as $temp)
                                            <option value="{{$temp->id}}">{{$temp->email}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="selectpicker form-control" data-live-search="true" name="user_refered">
                                            @foreach($userList as $temp)
                                            <option value="{{$temp->id}}">{{$temp->email}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer md-button">
                        <button class="btn" type="button" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                        <button  type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div> -->
        </div>
    </div>
<script>
function copy_address(address) {
    navigator.clipboard.writeText(address);
    alert("copied!");
}
</script>
@endsection
@section('script')
<script src="{{asset('assets/js/scrollspyNav.js')}}"></script>
<script src="{{asset('plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('plugins/select2/custom-select2.js')}}"></script>
<script>
    $('#affiliationTable').DataTable({
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "aaSorting": false,
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7,
        columnDefs: [ {
            targets: [ 0 ],
            orderData: [ 0, 1 ]
        } ]
    });

    $('.popoverOption').popover({ trigger: "hover" });
    
    var ss = $(".selectpicker").select2({
        tags: true,
    });
</script>
@endsection