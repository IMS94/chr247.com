<script src="{{asset('plugins/jQueryPrint/printThis.js')}}"></script>
<div class="modal fade" id="issueIDModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">{{$patient->first_name}} {{$patient->last_name}}</h4>
            </div>

            <div class="modal-body">

                {{--The ID to be printed--}}
                <div class="box box-primary box-solid" id="patientID">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>{{$patient->clinic->name}}</h3>
                                <h5>
                                    {{$patient->clinic->address}}<br>
                                    {{$patient->clinic->phone}}<br>
                                    {{$patient->clinic->email}}
                                </h5>

                                <h4>{{$patient->first_name}} {{$patient->last_name}}
                                    <br>
                                    <small>{{$patient->address}}</small>
                                </h4>
                                <?php
                                $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
                                ?>
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-4">
                                        <img src="data:image/png;base64,{{base64_encode($generator->getBarcode($patient->id, $generator::TYPE_CODE_128))}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary pull-right" onclick="printID()">Print ID</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script>
    function printID() {
        $('#patientID').printThis({
            importCSS: true,
            loadCSS: "{{asset('bootstrap/css/bootstrap.min.css')}}"
        });
    }
</script>
