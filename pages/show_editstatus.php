<?php
ini_set("error_reporting", 1);
session_start();
include("../koneksi.php");

$schema    = 'dbnow_gkj';
$tblUpload = "[$schema].[tbl_upload]";
$modal_id  = isset($_GET['id']) ? $_GET['id'] : '';

$qryUpload = "SELECT status FROM $tblUpload WHERE id=?";
$stmt      = sqlsrv_query($con, $qryUpload, [$modal_id], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
$rowUpload = ($stmt && ($tmp = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))) ? $tmp : ['status' => ''];
?>
<div class="modal-dialog modal-sm">
  <div class="modal-content">
    <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="UbahStatus" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">Update Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($modal_id); ?>">
        <div class="form-group row">
          <label for="sts" class="col-md-3">Status</label>
          <select class="form-control select2bs4" style="width: 100%;" name="sts">
            <option value="">Pilih</option>
            <option value="Open" <?php if ($rowUpload['status'] == "Open") { echo "SELECTED"; } ?>>Open</option>
            <option value="Closed" <?php if ($rowUpload['status'] == "Closed") { echo "SELECTED"; } ?>>Closed</option>
          </select>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
      </div>
    </form>
  </div>
</div>
