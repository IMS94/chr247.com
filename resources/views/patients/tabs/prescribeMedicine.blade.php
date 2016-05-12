<div class="container-fluid" ng-app="HIS">

    {{--Main Box--}}
    <div class="box box-default box-solid margin" ng-controller="PrescriptionController">
        <div class="box-header">
            <h4 class="box-title">Prescription</h4>
        </div>

        {{--Main Box Body--}}
        <div class="box-body">

            <div class="alert alert-danger alert-dismissable" ng-show="hasError" ng-cloak>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Oops!</h4>
                [[error]]
            </div>

            <div class="alert alert-success alert-dismissable" ng-show="hasSuccess" ng-cloak>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                Prescription saved successfully.
            </div>

            <div class="form-horizontal margin">
                {{-- Initialize the angular variables in a hidden field --}}
                <input type="hidden"
                       ng-init="baseUrl='{{url("/")}}';id={{$patient->id}};token='{{csrf_token()}}';init()">

                <div class="form-group">
                    <label class="col-md-3 col-sm-12 control-label">Presenting Complaints</label>
                    <div class="col-md-9 col-sm-12">
                <textarea id="presentingComplaints" placeholder="Presenting Complaints" ng-model="complaints"
                          class="form-control"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 col-sm-12 control-label">Investigations</label>
                    <div class="col-md-9 col-sm-12">
                <textarea id="prescriptionInvestigations" placeholder="Investigations" ng-model="investigations"
                          class="form-control"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 col-sm-12 control-label">Diagnosis</label>
                    <div class="col-md-9 col-sm-12">
                        <input id="prescriptionDiagnosis" placeholder="" ng-model="diagnosis" class="form-control"
                               type="text">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 col-sm-12 control-label">Other Remarks</label>
                    <div class="col-md-9 col-sm-12">
                <textarea id="prescriptionRemarks" ng-model="remarks" placeholder="Remarks"
                          class="form-control"></textarea>
                    </div>
                </div>

                {{-- Area to add drugs --}}
                <div class="box box-success box-solid">
                    <div class="box-header">
                        <h4 class="box-title">Drugs</h4>
                    </div>

                    <div class="box-body">

                        <div class="alert alert-danger alert-dismissable" ng-show="hasDrugError" ng-cloak>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Oops!</h4>
                            [[error]]
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-8 col-md-offset-2">
                                <label class="col-sm-12 text-center">Drug</label>
                                <div class="col-sm-12">
                                    <select id="prescriptionDrug" class="form-control" size="6" ng-model="drug">
                                        <option value="">None</option>
                                        <option ng-repeat="drug in drugs" value="[[drug.id]]">
                                            [[drug.name]] [[drug.quantity | number:0]]
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
                                        <option value="">None</option>
                                        <option ng-repeat="dose in dosages track by dose.id" value="[[dose.id]]">
                                            [[dose.description]]
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="col-sm-12 text-center">Frequency (Optional)</label>
                                <div class="col-sm-12">
                                    <select id="prescriptionFrequency" class="form-control" size="6"
                                            ng-model="frequency">
                                        <option value="">None</option>
                                        <option ng-repeat="f in frequencies track by f.id"
                                                value="[[f.id]]">
                                            [[f.description]]
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="col-sm-12 text-center">Period (Optional)</label>
                                <div class="col-sm-12">
                                    <select id="prescriptionPeriod" class="form-control" size="6" ng-model="period">
                                        <option value="">None</option>
                                        <option ng-repeat="p in periods track by p.id" value="[[p.id]]">
                                            [[p.description]]
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button class="btn btn-success btn-lg pull-right" ng-click="add()">
                            Add
                        </button>
                    </div>
                </div>
                {{-- /Area to add drugs --}}

                {{-- Area to show drugs --}}
                <div class="box box-success box-solid">
                    <div class="box-header">
                        <h4 class="box-title">Prescribed Drugs</h4>
                    </div>
                    <div class="box-body">
                        <table class="table table-condensed table-bordered table-hover text-center">
                            <thead>
                            <tr>
                                <th>Drug Name</th>
                                <th>Dose</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="d in prescribedDrugs track by $index">
                                <td>[[d.drug.name]]</td>
                                <td>
                                    [[d.dose.description]]<br>[[d.frequency.description]]<br>[[d.period.description]]
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger" ng-click="removeDrug([[$index]])">
                                        <i class="fa fa-recycle"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{--/Main Box Body--}}

        {{-- Overlay to be shown when submitted --}}
        <div class="overlay" ng-show="submitted" ng-cloak>
            <i class="fa fa-refresh fa-spin"></i>
        </div>
        {{-- /Overlay --}}

        <div class="box-footer">
            <button class="btn btn-primary btn-lg pull-right" ng-click="savePrescription()">
                Save Prescription
            </button>
            <button class="btn btn-danger btn-lg" ng-click="clearPrescription()">
                Cancel Prescription
            </button>
        </div>
    </div>
    {{--/Main Box--}}
</div>