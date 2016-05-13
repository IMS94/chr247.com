<div class="container-fluid margin" ng-controller="IssueMedicineController">

    {{-- Initialize the angular variables in a hidden field --}}
    <input type="hidden"
           ng-init="baseUrl='{{url("/")}}';id={{$patient->id}};token='{{csrf_token()}}';loadPrescriptions()">

    <div class="alert alert-success alert-dismissable" ng-show="hasSuccess" ng-cloak>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        Prescription saved successfully.
    </div>

    {{--Prescription--}}
    <div class="box box-primary box-solid" ng-repeat="prescription in prescriptions track by $index">
        <div class="box-header">
            <h4 class="box-title">
                [[prescription.created_at]]
            </h4>
            <button class="btn btn-sm btn-danger pull-right" ng-click="deletePrescription([[$index]])">
                Delete Prescription
            </button>
        </div>

        <div class="box-body">

            <div class="alert alert-danger alert-dismissable" ng-show="prescription.hasError" ng-cloak>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Oops!</h4>
                [[error]]
            </div>

            <table class="table table-hover table-condensed table-bordered text-center">
                <thead>
                <tr>
                    <th class="col-sm-4">Drug</th>
                    <th class="col-sm-5">Dose</th>
                    <th class="col-sm-3">Quantity</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="prescribedDrug in prescription.prescription_drugs">
                    <td>[[prescribedDrug.drug.name]] ([[prescribedDrug.drug.quantity_type.drug_type]])</td>
                    <td>
                        [[prescribedDrug.dosage.description]]<br>
                        [[prescribedDrug.frequency.description]]<br>
                        [[prescribedDrug.period.description]]
                    </td>
                    <td>
                        <input class="form-control" type="number" step="0.01"
                               ng-model="prescribedDrug.issuedQuantity" min="0">
                    </td>
                </tr>
                </tbody>
            </table>

            {{--Input to add payment information--}}
            <div class="container-fluid col-sm-12 margin">
                <label class="col-sm-3 control-label text-right">Payment</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" min="0" ng-model="prescription.payment"
                           step="0.01">
                </div>
            </div>
            <div class="container-fluid col-sm-12 margin">
                <label class="col-sm-3 control-label text-right">Remarks</label>
                <div class="col-sm-9">
                    <textarea class="form-control" ng-model="prescription.paymentRemarks"></textarea>
                </div>
            </div>


        </div>

        <div class="box-footer">
            <button class="btn btn-lg btn-success pull-right" ng-click="issuePrescription([[$index]])">
                Mark as Issued
            </button>
        </div>
    </div>


</div>