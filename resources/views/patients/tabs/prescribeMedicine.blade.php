<script src="{{asset('plugins/angularjs/angular.min.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>

<div class="container-fluid" ng-app="HIS">
    <div class="form-horizontal margin" ng-controller="PrescriptionController">

        {{-- Initialize the angular variables in a hidden field --}}
        <input type="hidden" ng-init="baseUrl='{{url("/")}}';token='{{csrf_token()}}';init()">

        <div class="form-group">
            <label class="col-md-3 col-sm-12 control-label">Presenting Complaints</label>
            <div class="col-md-9 col-sm-12">
                <textarea id="presentingComplaints" placeholder="Presenting Complaints" class="form-control"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 col-sm-12 control-label">Investigations</label>
            <div class="col-md-9 col-sm-12">
                <textarea id="prescriptionInvestigations" placeholder="Investigations" class="form-control"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 col-sm-12 control-label">Diagnosis</label>
            <div class="col-md-9 col-sm-12">
                <input id="prescriptionDiagnosis" placeholder="" class="form-control" type="text">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 col-sm-12 control-label">Other Remarks</label>
            <div class="col-md-9 col-sm-12">
                <textarea id="prescriptionRemarks" placeholder="Remarks" class="form-control"></textarea>
            </div>
        </div>

        {{-- Area to add drugs --}}
        <div class="box box-success">
            <div class="box-header">
                <h4 class="box-title">Drugs</h4>
            </div>
            <div class="box-body">

                <div class="col-md-12">
                    <div class="col-md-8 col-md-offset-2">
                        <label class="col-sm-12 text-center">Drugs</label>
                        <div class="col-sm-12">
                            <select id="prescriptionDrug" class="form-control" size="6" ng-model="drug">
                                <option ng-repeat="drug in drugs" value="[[drug.id]]">
                                    [[drug.name]] [[drug.quantity]]
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 margin">
                    <div class="col-md-4">
                        <label class="col-sm-12 text-center">Dose</label>
                        <div class="col-sm-12">
                            <select id="prescriptionDose" class="form-control" size="6" ng-model="dosage">
                                <option ng-repeat="dose in dosages track by dose.id" value="[[dose.id]]">
                                    [[dose.description]]
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="col-sm-12 text-center">Frequency (Optional)</label>
                        <div class="col-sm-12">
                            <select id="prescriptionFrequency" class="form-control" size="6" ng-model="frequency">
                                <option ng-repeat="frequency in frequencies track by frequency.id"
                                        value="[[frequency.id]]">
                                    [[frequency.description]]
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="col-sm-12 text-center">Period (Optional)</label>
                        <div class="col-sm-12">
                            <select id="prescriptionPeriod" class="form-control" size="6" ng-model="period">
                                <option ng-repeat="period in periods track by period.id" value="[[period.id]]">
                                    [[period.description]]
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-danger" ng-click="add()"></button>
        {{-- /Area to add drugs --}}

        {{-- Area to show drugs --}}
        <div class="box box-success">
            <div class="box-header">
                <h4 class="box-title">Prescription</h4>
            </div>
            <div class="box-body">
                <table class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Drug Name</th>
                        <th>Dose</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="drug in prescribedDrugs">
                        <td>[[drug.name]]</td>
                        <td>[[drug.dose]]</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>