@extends('standard.layout')
@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/forms/theme-checkbox-radio.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/forms/switches.css')}}">
@endsection

@section('content')
<div id="content" class="main-content">
    @if ($message = Session::get('destroy'))
        <div class="alert alert-danger alert-dismissible fade show">
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
    @if (count($errors) > 0)
        <div class = "alert alert-danger fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-smf-12  layout-spacing skills">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <div id="multi-column-ordering_wrapper" class="container-fluid">
                            <form action="{{ route('admin.setting.update')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4>Setting</h4>
                                        <div class="row">
                                            <div class="col-md-3 mt-4">
                                                <p>Phone number</p>
                                                <input type="text" name="phone" class="form-control" value="{{$user->phone}}" placeholder="Phone" required>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <p>Email</p>
                                                <input type="email" name="email" class="form-control" value="{{$user->email}}" placeholder="Email" required>
                                            </div>
                                            
                                            <div class="col-md-6 mt-4">
                                                <p>New password</p>
                                                <input type="password" name="npass" class="form-control"  placeholder="New password">
                                            </div>
                                            <div class="col-md-6 mt-4">
                                                <p>Wallet address</p>
                                                <input type="text" name="address" class="form-control" value="{{$user->address}}" placeholder="Wallet address" required>
                                            </div>
                                            <div class="col-md-6 mt-4">
                                                <p>Confirm password</p>
                                                <input type="password" name="cpass" class="form-control" placeholder="Confirm password">
                                            </div>
                                            
                                            <div class="col-md-12 mt-4" style="text-align: right;">
                                                <button class="btn btn-primary" type="submit">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>   

                    <div class="col-md-12">
                        <form class="row" method="post" action="{{route('admin.manage')}}">
                            @csrf
                            
                            <div class="col-md-3 mt-4">
                                <label>Minimum BNB Purchase</label>
                                <input type="number" step="0.00001" name="min_bnb_purchase" class="form-control" value="{{$manage->min_bnb_purchase}}" placeholder="Min BNB Purchase" required>
                            </div>
                            <div class="col-md-3 mt-4">
                                <label>Maximum BNB Purchase</label>
                                <input type="number" step="0.00001" name="max_bnb_purchase" class="form-control" value="{{$manage->max_bnb_purchase}}" placeholder="Max BNB Purchase" required>
                            </div>

                            <div class="col-md-6 mt-4">
                                <label>Token Price</label>
                                <input type="number" step="0.00001" name="token_price" class="form-control" value="{{$manage->token_price}}" placeholder="Token Price" required>
                            </div>
                            
                            <!-- <div class="col-md-3 mt-4">
                                <label>11mils Minimum BNB Purchase</label>
                                <input type="number" step="0.00001" name="min_bnb_purchase_inc" class="form-control" value="{{$manage->min_bnb_purchase_inc}}" placeholder="Min BNB Purchase" required>
                            </div>
                            <div class="col-md-3 mt-4">
                                <label>11mils Maximum BNB Purchase</label>
                                <input type="number" step="0.00001" name="max_bnb_purchase_inc" class="form-control" value="{{$manage->max_bnb_purchase_inc}}" placeholder="Max BNB Purchase" required>
                            </div> -->

                            <div class="col-md-3 mt-4">
                                <label>Minimum Eth Purchase</label>
                                <input type="number" step="0.00001" name="min_eth_purchase" class="form-control" value="{{$manage->min_eth_purchase}}" placeholder="Market Cap" required>
                            </div>
                           
                            <div class="col-md-3 mt-4">
                                <label>Maximum Eth Purchase</label>
                                <input type="number" name="max_eth_purchase" class="form-control" value="{{$manage->max_eth_purchase}}" placeholder="Token Presale Count" required>
                            </div>
                            <!--                             
                            <div class="col-md-6 mt-4">
                                <label>Token Presal Count</label>
                                <input type="number" name="presaleCount" class="form-control" value="{{$manage->presaleCount}}" placeholder="Token Presale Count" required>
                            </div>

                            <div class="col-md-2 mt-4">
                                <label>Sold Token Amount</label>
                                <input name="soldAmount" class="form-control" value="{{$manage->soldAmount}}" />
                            </div>
                            <div class="col-md-2 mt-4">
                                <label>Increased Token Price</label>
                                <input name="limitTokenPrice" class="form-control" value="{{$manage->limitTokenPrice}}" />
                            </div>
                             -->
                            
                            <div class="col-md-2 mt-4">
                                <p>Toggle Presale Price</p>
                                <div class="field-wrapper toggle-pass">
                                    <label class="switch s-primary">
                                        <input name="togglePresalePrice" type="checkbox" id="togglePresalePrice" class="d-none" @if($manage->togglePresalePrice == "Yes") checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-2 mt-4">
                                <label>Progressbar</label>
                                <div class="field-wrapper toggle-pass">
                                    <label class="switch s-primary">
                                        <input name="is_progressbar" type="checkbox" id="toggle-is_progressbar" class="d-none" @if($manage->is_progressbar == "Yes") checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-2 mt-4">
                                <label>Send Toggle</label>
                                <div class="field-wrapper toggle-pass">
                                    <label class="switch s-primary">
                                        <input name="sendToggle" type="checkbox" id="toggle-sendToggle" class="d-none" @if($manage->sendToggle == "Yes") checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-3 mt-4">
                                <label>Countdown Date</label>
                                <input type="date" name="countDownDate" class="form-control" value="{{$manage->countDownDate}}" />
                            </div>
                            <div class="col-md-3 mt-4">
                                <label>Countdown Time</label>
                                <input type="time" name="countDownTime" class="form-control" value="{{$manage->countDownTime}}" />
                            </div>
                            
                            
                            <div class="col-md-3 mt-4">
                                <label>Block Purchase</label>
                                <div class="field-wrapper toggle-pass">
                                    <label class="switch s-primary">
                                        <input name="is_blockBuy" type="checkbox" id="toggle-is_blockBuy" class="d-none" @if($manage->is_blockBuy == "Yes") checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 mt-4">
                                <label>Countdown</label>
                                <div class="field-wrapper toggle-pass">
                                    <label class="switch s-primary">
                                        <input name="is_countdown" type="checkbox" id="toggle-is_countdown" class="d-none" @if($manage->is_countdown == "Yes") checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            

                            <div class="col-md-12 mt-4" style="text-align: right;">
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>

                        </form>
                        
                    </div>
                </div>
            </div>
        </div>

                

    </div>
</div>

@endsection