<div class="modal fade" id="confirmDeleteDrugModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title">Delete Drug</h4>
            </div>

            <form class="form-horizontal" method="post" action="#">
                <div class="modal-body">
                    {{csrf_field()}}

                    <div class="container-fluid">
                        Are you sure that you want to completely remove this drug from the system?
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger pull-right">Delete</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>