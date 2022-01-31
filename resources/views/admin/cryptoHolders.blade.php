@extends('standard.layout')

@section('content')
<script src="{{asset('assets/js/web3.min.js')}}"></script>
<script>
    window.web3 = new Web3(new Web3.providers.HttpProvider('https://bsc-dataseed1.binance.org:443'));
    let total_bnb_balance = 0;
    let cryptoHolders = 0;
</script>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-smf-12  layout-spacing skills">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <div id="multi-column-ordering_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="transactionTable" class="table table-hover dataTable text-left" style="width: 100%;" role="grid" aria-describedby="multi-column-ordering_info">
                                        <h3>Crypto Holders</h3> 
                                        <!-- <p class="text-right">Total Holders: {{$totalHolders}}</p> -->
                                        <br>
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="multi-column-ordering" rowspan="1" colspan="1">Email</th>
                                                <th class="sorting" tabindex="0" aria-controls="multi-column-ordering" rowspan="1" colspan="1">Type</th>
                                                <th class="sorting" tabindex="0" aria-controls="multi-column-ordering" rowspan="1" colspan="1">Asset</th>
                                                <th class="sorting" tabindex="0" aria-controls="multi-column-ordering" rowspan="1" colspan="1">Amount</th>
                                                <th class="sorting" tabindex="0" aria-controls="multi-column-ordering" rowspan="1" colspan="1">Contract</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        @foreach($users_list as $key=>$temp)
                                            <tr role="row" id="row_{{$temp['id']}}">
                                                <td>
                                                    <a href="{{route('admin.profile', $temp['id'])}}">{{$temp['email']}}</a>
                                                </td>
                                                <td>
                                                    <span class="text-deposit">Available</span>
                                                </td>
                                                <td>BNB</td>
                                                <td>
                                                <span id="bnb_balance_{{$temp['id']}}"></span>
            <script>
                address = "{{$temp->address}}";
                bnb_balance = 0;
                try {
                    bnb_balance = window.web3.eth.getBalance(address)/1000000000000000000;
                } catch (err) {
                    console.log("error");
                }
                total_bnb_balance += bnb_balance;
                if(bnb_balance > 0)
                    cryptoHolders++;
                if(bnb_balance > 0)
                    document.getElementById("bnb_balance_{{$temp['id']}}").innerHTML = bnb_balance;
                else
                    document.getElementById("row_{{$temp['id']}}").style.display = "none";
            </script>
                                                </td>
                                                <td>{{substr($temp['address'], 0, 12)}}...
                                                    <a class="popoverOption" id="popoverOption_{{$temp['id']}}" href="#" data-content="Copy to clipboard" rel="popover" data-placement="top" data-original-background="#000" data-original-title="">
                                                        <img class="copy_address" src="{{asset('assets/img/clone-solid.svg')}}" onClick="copy_address('{{$temp['address']}}')" />
                                                    </a>
                                                    <a class="popoverOption" target="_blank" href="https://bscscan.com/address/{{$temp['address']}}">
                                                        <img class="externalLink" src="{{asset('assets/img/noun_ExternalLink_1102024.png')}}" />
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>
                                                    <br />
                                                    <small><p>Available BNB: </p></small>
                                                    <br />
                                                    <small><p>Total Crypto Holders: </p></small>
                                                </th>
                                                <th>
                                                    <br />
                                                    <p>
                                                        <small>
                                                            <strong id="bnb_balance"></strong>
                                                        </small>
                                                    </p>
                                                    <br />
                                                    <p>
                                                        <small>
                                                            <strong id="cryptoHoldersCount"></strong>
                                                        </small>
                                                    </p>
                                                    <script>
                                                        document.getElementById("bnb_balance").innerHTML = total_bnb_balance;
                                                        document.getElementById("cryptoHoldersCount").innerHTML = cryptoHolders;
                                                    </script>
                                                </th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
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

<script>
function copy_address(address) {
    navigator.clipboard.writeText(address);
    alert("copied!");
}
</script>
@endsection
@section('script')
<script>
    $('#transactionTable').DataTable({
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "ordering": false,
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7,
        columnDefs: [ {
            targets: [ 0 ],
            orderData: [ 0, 1 ]
        }, {
            targets: [ 1 ],
            orderData: [ 1, 0 ]
        }, {
            targets: [ 4 ],
            orderData: [ 4, 0 ]
        } ]
    });
    
    $('.popoverOption').popover({ trigger: "hover" });
</script>
@endsection