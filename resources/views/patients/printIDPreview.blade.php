<html>
<head>
    <title>Print ID | Preview</title>
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}" media="print">
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<style>
    @media print {
        .no-print, .no-print * {
            display: none !important;
        }
    }
</style>

<body>
{{--The ID to be printed--}}
<div class="container-fluid">
    <div class="col-md-6 col-md-offset-3 col-xs-12">
        <div class="panel panel-primary" id="patientID">
            <div class="panel-heading">
                <h4 class="panel-title">{{$patient->clinic->name}} - Patient ID</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-3">
                        <h4>Clinic's Information</h4>
                    </div>
                    <div class="col-xs-9">
                        <h5>
                            {{$patient->clinic->address}}<br>
                            {{$patient->clinic->phone}}<br>
                            {{$patient->clinic->email}}
                        </h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-3">
                        <h4>Patient's Information</h4>
                    </div>
                    <div class="col-xs-9">
                        <h4>
                            {{$patient->first_name}} {{$patient->last_name}}<br>
                            @if($patient->address)
                                <small>{{$patient->address}}</small>
                                <br>
                            @endif
                            @if($patient->phone)
                                <small>{{$patient->phone}}</small>
                                <br>
                            @endif
                            @if($patient->nic)
                                <small>{{$patient->nic}}</small>
                                <br>
                            @endif
                            @if($patient->gender)
                                <small>{{$patient->gender}}</small>
                                <br>
                            @endif
                        </h4>
                        <div class="col-md-8 col-md-offset-4 col-xs-9 col-xs-offset-3 pull-left" id="barcode">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row margin-top container-fluid no-print">
    <div class="col-md-2 col-md-offset-3">
        <a href="{{route("patient",['id'=>$patient->id])}}" class="btn btn-primary pull-left">
            <i class="fa fa-chevron-left" aria-hidden="true"></i> Back to Patient
        </a>
    </div>
    <div class="col-md-2 col-md-offset-2">
        <button class="btn btn-primary pull-right" onclick="window.print()">
            <i class="fa fa-print" aria-hidden="true"></i> Print
        </button>
    </div>
</div>

<!-- jQuery 2.1.4 Moved to the top to load without an error-->
<script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
<script src="{{asset("plugins/jQueryBarcode/jquery-barcode.min.js")}}"></script>
<script>
    $(document).ready(function () {
        $('#barcode').barcode("{{$patient->id}}", "code128", {
            barWidth: 3
        });
    });
</script>
</body>
</html>