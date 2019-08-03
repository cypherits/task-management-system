<input type="file" id="file_id" accept="file_extension|audio/*|video/*|image/*|media_type" style="display:none" style="display:none"  multiple  name="files[]" />
<!--- Modal -->
<div id="copy_file" class="modal fade" role="dialog" style="display:none">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Uploading...</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="run_1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <!--<th>File Name</th>-->
                                <th>Progress</th>

                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button id="upload_modal_close" style="display: none;" type="reset" class="btn btn-success" data-dismiss="modal"><i class="fas fa-3x fa-check"></i></button>
            </div>
        </div>

    </div>
</div>