<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">แก้ไขข้อมูลการขาย</h4>
            </div>

            <div class="modal-body">
                <?php require_once 'form_sell.php' ?>
            </div>




            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script type="text/javascript">
    function selectID(id, name, tel) {
        $('#my_name').val(name);
        $('#insurance_id').val(id);
        $('#tel').val(tel);
        $('#myModal').modal('hide');
    }
</script>