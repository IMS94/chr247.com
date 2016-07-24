<div class="modal fade" id="addPharmacyDrugsModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add Pharmacy Drugs</h4>
            </div>

            <div class="modal-body">

                <div class="form-horizontal container-fluid">
                    <div class="form-group">
                        <label class="col-md-3 col-sm-12 control-label">Drug</label>
                        <div class="col-md-9 col-sm-12">
                            <input class="form-control" type="text" ng-model="pharmacyDrug" list="drugList"
                                   ng-change="predictDrug()" placeholder="Drug to be taken from a pharmacy">
                            <datalist id="drugList">
                                <option ng-repeat="drug in drugPredictions">[[drug.trade_name]]</option>
                            </datalist>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-sm-12 control-label">Remarks</label>
                        <div class="col-md-9 col-sm-12">
                        <textarea id="presentingComplaints" placeholder="Additional details (Dosages, precautions)"
                                  ng-model="pharmacyDrugRemarks" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-3 col-sm-12">
                            <button class="btn btn-success btn-lg" ng-click="addPharmacyDrug()">Add</button>
                        </div>
                    </div>
                </div>

                {{-- Area to show drugs --}}
                <div class="box box-success box-solid">
                    <div class="box-header">
                        <h4 class="box-title">Pharmacy Drugs</h4>
                    </div>
                    <div class="box-body">
                        {{--table to show pharmacy drugs--}}
                        <table class="table table-condensed table-bordered table-hover text-center"
                               ng-if="pharmacyDrugs.length>0">
                            <thead>
                            <tr class="success">
                                <th>Drug Name</th>
                                <th>Remarks</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="d in pharmacyDrugs track by $index" class="success" ng-cloak>
                                <td>[[d.name]]</td>
                                <td>
                                    [[d.remarks]]
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger" ng-click="removePharmacyDrug([[$index]])">
                                        <i class="fa fa-recycle"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="alert bg-success" ng-if="pharmacyDrugs.length==0" ng-cloak>
                            No Drugs Prescribed!
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