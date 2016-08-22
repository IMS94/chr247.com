<script src="{{asset("js/DrugController.js")}}"></script>

<div class="modal fade" id="addDosageModal" ng-controller="DrugController">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add New Drug to Prescription</h4>
            </div>

            <div class="modal-body">

                <div class="form-horizontal container-fluid">
                    <div class="form-group"
                         ng-class="{'has-error':error.drug.has||error.quantityType.has}">
                        <label class="col-md-3 col-xs-12 control-label text-center">Drug</label>

                        <div class="col-md-9 col-xs-12">
                            <div class="row">
                                <span class="help-block" ng-if="error.drug.has">
                                    [[error.drug.msg]]
                                </span>
                                <select class="form-control" size="4" ng-model="drug">
                                    <option value="">None</option>
                                    <option ng-repeat="drug in drugs" value="[[drug.id]]" ng-cloak>
                                        [[drug.name]]
                                    </option>
                                </select>
                            </div>

                            <div class="row text-center">
                                <label class="control-label text-center">or add a new drug</label>
                            </div>

                            <div class="row">
                                <input type="text" class="form-control" required list="drugPredictionList"
                                       ng-change="predictDrug()" ng-model="drugName" placeholder="New drug to be added">
                                <datalist id="drugPredictionList">
                                    <option ng-repeat="drug in drugPredictions">[[drug.trade_name]]</option>
                                </datalist>
                            </div>

                            <div class="row">
                                <span class="help-block" ng-if="error.quantityType.has">
                                    [[error.quantityType.msg]]
                                </span>
                                <input type="text" class="form-control" required list="quantityTypesList"
                                       ng-model="quantityType" placeholder="Quantity type of the drug">
                                <datalist id="quantityTypesList" ng-init="getQuantityTypes()">
                                    <option ng-repeat="q in quantityTypes">[[q.drug_type]]</option>
                                </datalist>
                            </div>

                        </div>
                    </div>

                    <div class="form-group" ng-class="{'has-error':error.dosage.has}">
                        <label class="col-md-3 col-sm-12 control-label">Dosage</label>
                        <div class="col-md-9 col-sm-12">
                            <div class="row">
                                <span class="help-block" ng-if="error.dosage.has">
                                    [[error.dosage.msg]]
                                </span>
                                <select class="form-control" size="4" ng-model="dosage">
                                    <option value="">None</option>
                                    <option ng-repeat="dose in dosages track by dose.id" value="[[dose.id]]"
                                            ng-cloak>
                                        [[dose.description]]
                                    </option>
                                </select>
                            </div>
                            <div class="row text-center">
                                <label class="control-label text-center">or add a new dosage</label>
                            </div>
                            <div class="row">
                                <input type="text" class="form-control" required ng-model="dosageText"
                                       placeholder="New dosage to be added">
                            </div>
                        </div>
                    </div>

                    <div class="form-group" ng-class="{'has-error':error.frequency.has}">
                        <label class="col-md-3 col-sm-12 control-label">Dosage Frequency</label>
                        <div class="col-md-9 col-sm-12">
                            <div class="row">
                                <span class="help-block" ng-if="error.frequency.has">
                                    [[error.frequency.msg]]
                                </span>
                                <select class="form-control" size="4" ng-model="frequency">
                                    <option value="">None</option>
                                    <option ng-repeat="f in frequencies track by f.id" value="[[f.id]]" ng-cloak>
                                        [[f.description]]
                                    </option>
                                </select>
                            </div>
                            <div class="row text-center">
                                <label class="control-label text-center">or add a new frequency</label>
                            </div>
                            <div class="row">
                                <input type="text" class="form-control" required ng-model="frequencyText"
                                       placeholder="New frequency to be added">
                            </div>
                        </div>
                    </div>

                    <div class="form-group" ng-class="{'has-error':error.period.has}">
                        <label class="col-md-3 col-sm-12 control-label">Dosage Period</label>
                        <div class="col-md-9 col-sm-12">
                            <div class="row">
                                <span class="help-block" ng-if="error.period.has">
                                    [[error.period.msg]]
                                </span>
                                <select class="form-control" size="4" ng-model="period">
                                    <option value="">None</option>
                                    <option ng-repeat="p in periods track by p.id" value="[[p.id]]" ng-cloak>
                                        [[p.description]]
                                    </option>
                                </select>
                            </div>
                            <div class="row text-center">
                                <label class="control-label text-center">or add a new period</label>
                            </div>
                            <div class="row">
                                <input type="text" class="form-control" required ng-model="periodText"
                                       placeholder="New period to be added">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 col-xs-12">
                            <div class="row">
                                <button class="btn btn-success pull-right" ng-click="save()">Save</button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="box-footer">
                <button class="btn btn-default" data-dismiss="modal" ng-click="pharmacyDrugs=[];">Cancel</button>
                <button class="btn btn-primary pull-right" data-dismiss="modal">Done</button>
            </div><!-- /.box-footer -->

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>