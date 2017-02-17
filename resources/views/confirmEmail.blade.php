@extends('layouts.app')

@section('content')

<script src="js/sweetalert.min.js"></script> 
<link rel="stylesheet" type="text/css" href="css/sweetalert.css">

@include('sweet::alert')

@if (Session::has('sweet_alert.alert'))
    <script>
        swal({!! Session::get('sweet_alert.alert') !!});
    </script>
@endif

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    
                    
                    <h4 style="text-align: center;margin: 2% 0 0 0;">Please confirm your email address</h4>
                    <h4 style="text-align: center;margin: 2% 0 0 0;">Confirmation email was send.</h4>
                    <h4 style="text-align: center;margin: 2% 0 0 0;"><a href="/sendConfirmationEmail">Send Again</a></h4>
                    
                    
            </div>
        </div>
    </div>
</div>
</div>

@endsection