<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Print Prescription | Preview</title>
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
    @if($prescription->prescriptionPharmacyDrugs()->count()>0)
        <div class="col-md-6 col-md-offset-3 col-xs-12">
            <div class="panel panel-default" id="patientID">
                <div class="panel-heading">
                    <h4 class="panel-title"><strong>{{$patient->clinic->name}}</strong></h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <h4>
                                {{$patient->first_name}} {{$patient->last_name}}
                                @if($patient->gender) ({{$patient->gender}}) @endif
                                <small class="pull-right">Age : {{Utils::getAge($patient->dob)}}</small>
                            </h4>
                        </div>
                        <table class="table text-center table-responsive col-xs-12">
                            <tbody>
                            @foreach($prescription->prescriptionPharmacyDrugs as $index=>$pharmacyDrug)
                                <tr>
                                    <td class="col-xs-1">{{$index+1}}.</td>
                                    <td class="col-xs-4">{{$pharmacyDrug->drug}}</td>
                                    <td class="col-xs-7">{{$pharmacyDrug->remarks}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="col-xs-12">
                            <h5>
                                Inspected By : {{$prescription->creator->name}}
                            </h5>
                            <h4>
                                <small>
                                    {{$patient->clinic->address}}<br>
                                    {{$patient->clinic->phone}}<br>
                                    {{$patient->clinic->email}}
                                </small>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Info message if there are no prescriptions to be issued --}}
        <div class="col-xs-6 col-xs-offset-3">
            <div class="alert alert-info" ng-if="prescriptions.length==0" ng-cloak>
                <h4><i class="icon fa fa-info"></i> Sorry!</h4>
                There's no pharmacy drugs in this prescription to be printed.
            </div>
        </div>
    @endif
</div>

<div class="row margin-top container-fluid no-print">
    <div class="col-md-2 col-md-offset-3">
        <button class="btn btn-primary pull-left" onclick="window.close()">
            <i class="fa fa-close" aria-hidden="true"></i> Close
        </button>
    </div>
    @if($prescription->prescriptionPharmacyDrugs()->count()>0)
        <div class="col-md-2 col-md-offset-2">
            <button class="btn btn-primary pull-right" onclick="window.print()">
                <i class="fa fa-print" aria-hidden="true"></i> Print
            </button>
        </div>
    @endif
</div>

</body>
</html>