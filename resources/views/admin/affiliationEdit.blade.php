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
                                        <h3>Edit Affiliation</h3>
                                        <br />
                                        <div class="">
                                            <form action="{{ route('admin.refer.update', $refer->id)}}" method="post">
                                            @csrf
                                                <div class="modal-body">
                                                    <div class="input-group mb-4">
                                                        <table>
                                                            <tr>
                                                                <td>User</td>
                                                                <td>Refered User</td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <select class="form-control" name="user">
                                                                        @foreach($userList as $temp)
                                                                        <option value="{{$temp->id}}" @if($temp->id == $refer->user_id) selected @endif>{{$temp->email}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control" name="user_refered">
                                                                        @foreach($userList as $temp)
                                                                        <option value="{{$temp->id}}" @if($temp->id == $refer->refer_id) selected @endif>{{$temp->email}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer md-button">
                                                    <a class="btn btn-default" href="{{route('admin.affiliation.manage')}}"><i class="flaticon-cancel-12"></i> Back</a>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
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