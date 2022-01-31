@extends('standard.layout')
@section('style')
<style>
#profileBtnGroup {
    /* position: absolute; */
    bottom: 0;
}
#profileBtnGroup .btn {
    margin: 10px;
}
.btn-bonus {
    background: #30be50;
    color: #fff !important;
}
.btn-bonus:hover {
    background: #30be50;
    color: #fff !important;
}
</style>
@endsection
@section('content')

<div id="content" class="main-content">
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible fade show">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
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
                    <div class="col-xl-12 col-lg-12 col-smf-12  layout-spacing skills">
                        <div class="widget-content widget-content-area br-6">
                            <div class="table-responsive mb-4 mt-4">
                                <div id="multi-column-ordering_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                    <div class="containers">
                                        <div class="">
                                            <h3>
                                                User Profile
                                                @if($user_data->deleted_at)
                                                <span class="badge badge-danger">Deleted</span>
                                                @else
                                                <span class="badge badge-primary">Active</span>
                                                @endif
                                            </h3>
                                            <div class="col-sm-12 text-right">
                                                <a href="{{route('admin.index')}}" class="btn btn-info">Back</a>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 row">
                                            <div class="col-md-6">
                                                <ul>
                                                    <label>Name: </label><span>{{$user_data->name}}</span>
                                                </ul>
                                                <ul>
                                                    <label>Number: </label><span>{{sprintf('%04s', $user_data->id)}}</span>
                                                </ul>
                                                <ul>
                                                    <label>Email: </label><span><strong> {{$user_data->email}}</strong></span>
                                                </ul>
                                                <ul>
                                                    <label>Country: </label><span><strong> {{$user_data->country}}</strong></span>
                                                </ul>
                                                <ul>
                                                    <label>Phone number:&nbsp</label><span><strong>{{$user_data->phone}}</strong></span>
                                                </ul>
                                                <ul>
                                                    <label>Telegram username: </label><span><strong> {{$user_data->tg_name}}</strong></span>
                                                </ul>
                                                <ul>
                                                    <label>Slamchat username: </label><span><strong> {{$user_data->slam_name}}</strong></span>
                                                </ul>
                                                <ul>
                                                    <label>Join Date: </label><span><strong> 
                                                        {{ \Carbon\Carbon::parse($user_data->created_at)->format('Y-m-d H:i:s')}}
                                                    </strong></span>
                                                </ul>
                                                <ul>
                                                    <a href="{{route('admin.affiliation', ['type' => 'affiliation', 'user_id'=>$user_data->id])}}"><label>Affilation count: </label><span><strong> {{$user_data->refer($user_data->id)}}</strong></span></a>
                                                </ul>
                                                <ul>
                                                    <a href="{{route('admin.affiliation', ['type' => 'affiliation', 'user_id'=>$user_data->id])}}"><label>Affiliation 10%: </label><span><strong> {{$user_data->totalAffiliation($user_data->id)}} $SLM</strong></span></a>
                                                </ul>
                                                <ul>
                                                    <label>Holding Funds: </label><span><strong id="balance_output">{{$user_data->ethBalance}} Eth / {{$user_data->bnbBalance}} BNB</strong></span>
                                                </ul>
                                                <ul>
                                                    <label>Holding $SLM: </label><span><strong> {{$user_data->exchange($user_data->id)}}</strong></span>
                                                </ul>
                                                <ul>
                                                    <label>Contract: </label>
                                                    <span>
                                                        <strong> 
                                                            <!-- {{substr($user_data->address, 0, 12)}}... -->
                                                            {{$user_data->address}}
                                                        </strong>
                                                    </span>
                                                    <a id="popoverOption" href="#" data-content="Copy to clipboard" rel="popover" data-placement="top" data-original-background="#000" data-original-title="">
                                                        <img class="copy_address" id="copy_address" src="{{asset('assets/img/clone-solid.svg')}}" />
                                                    </a>
                                                </ul>

                                            </div>
                                            <div class="col-md-6">
                                            <form method="post" action="{{route('admin.profile_update', $user_data->id)}}">
                                                @csrf
                                                <ul>
                                                    <p>Name</p>
                                                    <input type="text" name="name" class="form-control" value="{{$user_data->name}}" placeholder="Name" required>
                                                </ul>
                                                
                                                <!-- <ul>
                                                    <div class="col-md-12">
                                                        <div id="memo_toast" class="toast toast-danger fade hide" role="alert" data-delay="6000" aria-live="assertive" aria-atomic="true">
                                                            <div class="toast-header text-right">
                                                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="toast-body">
                                                                <p id="memo_toast_alert"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </ul> -->

                                                <ul class="">
                                                    <p>Slam Username</p>
                                                    <input type="text" name="slam_name" class="form-control" value="{{$user_data->slam_name}}" placeholder="Slam Username" required>
                                                </ul>
                                                
                                                <ul class="">
                                                    <p>Telegram Username</p>
                                                    <input type="text" name="tg_name" class="form-control" value="{{$user_data->tg_name}}" placeholder="Telegram Username" required>
                                                </ul>

                                                <ul class="">
                                                    <p>Add memo:</p>
                                                    <textarea class="form-control" id="memo_text" rows="5">{{$user_data->memo}}</textarea>
                                                    <!-- <div class="text-right">
                                                        <button class="btn btn-success" onclick="validateMemo()">Save</button>
                                                    </div> -->
                                                </ul>

                                                <!-- <ul>
                                                    <div class="col-md-12">
                                                        <div id="password_toast" class="toast toast-danger fade hide" role="alert" data-delay="6000" aria-live="assertive" aria-atomic="true">
                                                            <div class="toast-header text-right">
                                                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="toast-body">
                                                                <p id="password_toast_alert"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </ul> -->

                                                <ul>
                                                    <input name="password" type="password" class="form-control" placeholder="Enter new password" />
                                                </ul>
                                                <ul>
                                                    <input name="password_confirmation" type="password" class="form-control" placeholder="Confirm password" />
                                                </ul>

                                                <ul>
                                                    <button class="btn btn-bonus">Save</button>
                                                    <!-- <button class="btn btn-success" onclick="validatePassword();">Save</button> -->
                                                </ul>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <ul id="profileBtnGroup">
                                                    <a class="btn btn-warning" href="{{route('admin.forceswap', $user_data->id)}}" onClick="if(!confirm('Do you really force swap?')) return false">Force Swap</a>
                                                    @if($user_data->deleted_at)
                                                    <a class="btn btn-success" href="{{route('admin.retrieve', $user_data->id)}}" onClick="if(!confirm('Do you really retrieve?')) return false">Retrieve Account</a>
                                                    @else
                                                    <a class="btn btn-danger" href="{{route('admin.destroy', $user_data->id)}}" onClick="if(!confirm('Do you really delete?')) return false">Delete Account</a>
                                                    @endif
                                                    <a class="btn btn-primary" href="{{route('admin.transaction', ['user_id' => $user_data->id, 'type' => 'transaction'])}}">All Transactions</a>
                                                    <a class="btn btn-bonus" data-toggle="modal" data-target="#bonusModal">Bonus</a>
                                                </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="bonusModal" class="modal animated slideInUp custo-slideInUp" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <form action="{{ route('admin.bonus')}}" method="post">
                    @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Transfer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>
                        <div class="modal-body">
                            Please enter transfer amount for {{$user_data->email}}
                            <div class="input-group mb-4">
                                <input type="number" class="form-control" mins="0" step="0.00001" placeholder="Transfer Amount" name="bonus" required>
                                <input type="hidden" class="form-control" name="user_id" value="{{$user_data->id}}" required>
                            </div>
                        </div>
                        <div class="modal-footer md-button">
                            <button class="btn" type="button" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                            <button  type="submit" class="btn btn-primary">Transfer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
@section('script')
<script>
$(function () {
    $('.helloWorld').click(function () {
        alert('hello world');
    });
    // prettyPrint();

    // $('.modalPopover').modalPopover({target:'#methodTarget', placement:'left'});
});

function validatePassword() {
	var password = document.getElementById("password").value;
	var retype = document.getElementById("password_confirmation").value;
	
	if (password.length <= 6) {
        document.getElementById("password_toast_alert").innerHTML = "Password should be at least 6 characters.\n";
        $('#password_toast').toast('show');
        return false;
    }
    
	if (password != retype)  {
        document.getElementById("password_toast_alert").innerHTML = "Passwords do not match.\n";
        $('#password_toast').toast('show');
        return false;
    }
		
    $.ajax({
        method: "POST",
        url: "{{route('admin.password_update')}}",
        data: {user_id: {{$user_data->id}}, password: password, password_confirmation: retype},
        success: function(res) {
            document.getElementById("password_toast_alert").innerHTML = res;
            $('#password_toast').toast('show');
        }
    });
}

function validateMemo() {
	var memo = document.getElementById("memo_text").value;
    
	if (memo.length <= 5) {
        document.getElementById("memo_toast_alert").innerHTML = "Memo should be at least 5 characters.\n";
        $('#memo_toast').toast('show');
        return false;
    }

    $.ajax({
        method: "POST",
        url: "{{route('admin.memo')}}",
        data: {user_id: {{$user_data->id}}, memo: memo},
        success: function(res) {
            document.getElementById("memo_toast_alert").innerHTML = res;
            $('#memo_toast').toast('show');
        }
    });
}
</script>
<!-- <script src="{{asset('assets/js/web3.min.js')}}"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/web3js-cdn@1.3.0/web3.min.js" integrity="sha512-mYc+D+NmmyR0Gcrzyae7q5HguBCS4cBHAsIk7gGhu0/ZyGg4z2YZDjyR2YQA/IMCMTNs4mnlw3vVdERzewpekQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<!-- <script type="text/javascript">
    var address, wei, balance, bnb_balance
    window.addEventListener('load', function () {
        // if (typeof web3 !== 'undefined') {
        //     console.log('Web3 Detected! ' + web3.currentProvider.constructor.name)
        //     window.web3 = new Web3(web3.currentProvider);
        // } else {
        //     console.log('No Web3 Detected... using HTTP Provider')
        // }
        window.web3 = new Web3(new Web3.providers.HttpProvider("https://mainnet.infura.io/v3/8a1115e747524e11b2928a22a19a6388"));
        window.web3_bnb = new Web3(new Web3.providers.HttpProvider('https://bsc-dataseed1.binance.org:443'));
        console.log(web3.version, "web version")
        getBalance();
    });

    function getBalance() {
        address = "{{$user_data->address}}";
        
        try {
            bnb_balance = web3_bnb.eth.getBalance(address);
            
            web3.eth.getBalance(address, function (error, wei) {
                if (!error) {
                    balance = web3.fromWei(wei, 'ether');
                    document.getElementById("balance_output").innerHTML = bnb_balance/1000000000000000000+" BNB/"+balance+" ETH";
                }
            });
            
        } catch (err) {
            document.getElementById("balance_output").innerHTML = err;
        }

    }

    $(document).on('click', '#copy_address', function() {
        navigator.clipboard.writeText("{{$user_data->address}}");
        alert("copied!");
    })
    
    $('#popoverOption').popover({ trigger: "hover" });
</script> -->
@endsection