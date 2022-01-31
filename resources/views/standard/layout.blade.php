<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Slamcoin Backend</title>
    <link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon.svg')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&amp;display=swap" rel="stylesheet">
    <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet" type="text/css">
    
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- plugin -->
    <link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet" type="text/css">
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/custom_dt_html5.css')}}">
    <link href="{{asset('assets/css/users/account-setting.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/dropify/dropify.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/elements/alert.css')}}">
    <style>
        @font-face {
            font-family: 'SFProText' ;
            src: url({{asset('assets/font/FontsFree-Net-SFProText-Regular.ttf')}}) format('truetype');
        }
        * {
            font-family:SFProText !important;
        }
        .copy_address, .externalLink {
            width: 15px;
            cursor: pointer;
        }
        .copy_address {
            opacity: 0.3;
        }
        .text-bonus {
            color: #1b55e3;
        }
        .text-deduct {
            color: #e31b1b;
        }
        .text-affiliate {
            color: #1b55e3;
        }
        .text-swap {
            color: #e31b1b;
        }
        .text-deposit {
            color: #12dd0e;
        }
        .table > tbody tr {
            height: 60px !important;
        }
        .referform {
            margin-top: 50px;
            margin-bottom: 50px;
        }
    </style>
    @yield('style')
    <!-- END PAGE LEVEL STYLES -->
</head>
<body class="">
    
    <!--  BEGIN NAVBAR  -->
    @include('standard.navbar')
  
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container" style="margin-top:20px;">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        @include('standard.sidebar')
    
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        @yield('content')
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->
    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('bootstrap/js/popper.min.js')}}"></script>
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>
    
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ asset('plugins/table/datatable/datatables.js')}}"></script>
    <script src="{{ asset('plugins/table/datatable/button-ext/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('plugins/table/datatable/button-ext/jszip.min.js')}}"></script>   
    <script src="{{ asset('plugins/table/datatable/button-ext/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('plugins/table/datatable/button-ext/buttons.print.min.js')}}"></script>

    <script src="{{ asset('plugins/input-mask/jquery.inputmask.bundle.min.js')}}"></script>
    <!--<script src="{{asset('plugins/input-mask/input-mask.js')}}"></script>-->
    <!-- <script>
        $('#html5-extension').DataTable( {
            dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn' },
                    { extend: 'csv', className: 'btn' },
                    { extend: 'excel', className: 'btn' },
                    { extend: 'print', className: 'btn' }
                ]
            },
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 7 
        } );
    </script> -->
    <script src="{{asset('assets/js/forms/bootstrap_validation/bs_validation_script.js')}}"></script>
    <script src="{{asset('assets/js/users/account-settings.js')}}"></script>
    <script src="{{asset('plugins/dropify/dropify.min.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        var j = 0;
        function select_all(){
            j++;
            var selected = document.getElementsByClassName('chk-parent');
            if(j%2 == 0){
                var i = 0;
                for(i=0;i<selected.length;i++){
                    selected[i].checked = false;
                }        
            }else{
                var i = 0;
                for(i=0;i<selected.length;i++){
                    selected[i].checked = true;
                }  
            }
        }
        
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }
                form.classList.add('was-validated');
              }, false);
            });
        }, false);
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->
@yield('script')
</body></html>