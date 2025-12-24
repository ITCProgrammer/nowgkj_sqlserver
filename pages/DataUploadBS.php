<?php
// Params
$Buyer1  = isset($_POST['buyer']) ? $_POST['buyer'] : '';
$Project = isset($_POST['project']) ? $_POST['project'] : '';
$POno    = isset($_POST['pono']) ? $_POST['pono'] : '';
$Item    = isset($_POST['itemno']) ? $_POST['itemno'] : '';
$NoWarna = isset($_POST['warnano']) ? $_POST['warnano'] : '';
$Zone    = isset($_POST['zone']) ? $_POST['zone'] : '';

// Schema aliases
$schema       = 'dbnow_gkj';
$tblUploadBS  = "[$schema].[tbl_upload_bs]";
$tblStokfullBS = "[$schema].[tbl_stokfull_bs]";

// Helpers
$sqlErrors = [];
function formatSqlsrvDate($value) {
    return ($value instanceof DateTime) ? $value->format('Y-m-d H:i:s') : $value;
}
function logSqlError($stmt, $label = '', $line = null) {
    global $sqlErrors;
    if ($stmt !== false) {
        return;
    }
    $err = sqlsrv_errors();
    if (!empty($err)) {
        $msg = $label !== '' ? $label . ': ' : '';
        if ($line !== null) {
            $msg = "[line $line] " . $msg;
        }
        $msg .= $err[0]['message'];
        $sqlErrors[] = $msg;
        echo "<script>console.error('SQLSRV error: " . addslashes($msg) . "');</script>";
    }
}
function fetchOrDefault($stmt, $default = [], $label = '', $line = null) {
    if ($stmt === false) {
        logSqlError($stmt, $label, $line);
        return $default;
    }
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    return $row ?: $default;
}
?>
<!-- Main content -->
      <div class="container-fluid">
        <?php if (!empty($sqlErrors)) { ?>
        <div class="alert alert-danger">
            <strong>SQL Error:</strong>
            <ul style="margin-bottom:0;">
                <?php foreach ($sqlErrors as $errMsg) { ?>
                    <li><?php echo htmlspecialchars($errMsg); ?></li>
                <?php } ?>
            </ul>
        </div>
        <?php } ?>
		  
	    <div class="card card-pink">
              <div class="card-header">
                <h3 class="card-title">Detail Data Upload</h3>
				<a href="AddUploadBS" class="btn btn-success float-right"><i class="fa far-plus"> </i>Add Upload</a>  
          </div>
              <!-- /.card-header -->
              <div class="card-body">
          <table id="example4" class="table table-sm table-bordered table-striped" style="font-size:13px;">
                  <thead>
                  <tr>
                    <th style="text-align: center">No</th>
                    <th style="text-align: center">Tgl Upload</th>
                    <th style="text-align: center">Nama File</th>
                    <th style="text-align: center">Data</th>
                    <th style="text-align: center">Details</th>
                    <th style="text-align: center">Status</th>
                    <th style="text-align: center">Upload</th>
                    <th style="text-align: center">Hapus</th>
                    </tr>
                  
                  </thead>
                  <tbody>
				  <?php
					$no=1; 
          $qryUpload = "SELECT * FROM $tblUploadBS ORDER BY id DESC";
					$sql = sqlsrv_query($con, $qryUpload, [], ["Scrollable" => SQLSRV_CURSOR_KEYSET]);					  
          logSqlError($sql, 'list upload bs', __LINE__);
	  				while($sql && ($rowd = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC))){
            $qryCount = "SELECT COUNT(*) AS JML FROM $tblStokfullBS WHERE id_upload=?";
						$sql1 = sqlsrv_query(
              $con,
              $qryCount,
              [$rowd['id']],
              ["Scrollable" => SQLSRV_CURSOR_KEYSET]
            );					  
            logSqlError($sql1, 'count stokfull bs per upload', __LINE__);
	  					$rowd1 = fetchOrDefault($sql1, ['JML'=>0], 'fetch stokfull bs per upload', __LINE__);
						if($rowd['status']=="Open" and (isset($rowd1['JML']) ? $rowd1['JML'] : 0)==0){
							$stts="<small class='badge badge-success '><i class='far fa-clock'></i> Open</small>";
						}else if($rowd['status']=="Open" and (isset($rowd1['JML']) ? $rowd1['JML'] : 0)>0){
							$stts="<a href='#' id='".$rowd['id']."' class='show_editstatus'><small class='badge badge-warning'><i class='far fa-clock'></i> Open, In Progress</small></a>";
						}else{
							$stts="<a href='#' id='".$rowd['id']."' class='show_editstatus'><small class='badge badge-danger'><i class='far fa-clock'></i> Closed</small></a>";
						}
		  		  ?>
				  		<tr>
                    <td style="text-align: center"><?php echo $no;?></td>
                    <td style="text-align: center"><?php echo formatSqlsrvDate($rowd['tgl_upload']);?></td>
                    <td style="text-align: center"><?php echo $rowd['nama_file'];?></td>
                    <td style="text-align: center"><?php echo $rowd1['JML'];?></td>
                    <td style="text-align: center"><a href="CheckStockBS-<?php echo $rowd['id'];?>" class="btn btn-xs btn-info"><small class="fas fa-link"> </small></a></td>
                    <td style="text-align: center"><?php echo $stts;?></td>
                    <td style="text-align: center"><a href="UploadDataBS-<?php echo $rowd['id'];?>" class="btn btn-xs btn-warning <?php if($rowd1['JML']>0){ echo "disabled";}?> " ><small class="fas fa-plus"> </small></a></td>
                    <td style="text-align: center"><a href="#" class="btn btn-xs btn-danger <?php if($rowd1['JML']==0){ echo "disabled";}?>" onclick="confirm_delete('DelUploadBS-<?php echo $rowd['id'] ?>');" ><small class="fas fa-trash"> </small></a></td>
                  </tr>	 
				<?php
						$no++;
					} 
				?>
				  </tbody>
                <tfoot>
                  </tfoot>  
                </table>
            </div>
              <!-- /.card-body -->
        </div>        
</div><!-- /.container-fluid -->
    <!-- /.content -->

<div id="EditStatusUpload" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>

<div class="modal fade" id="delBuyer" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content" style="margin-top:100px;">
                  <div class="modal-header">
					<h4 class="modal-title">INFOMATION</h4>  
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    
                  </div>
					<div class="modal-body">
						<h5 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h5>
					</div>	
                  <div class="modal-footer justify-content-between">
                    <a href="#" class="btn btn-danger" id="delete_link">Delete</a>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
            </div>

<script>
	$(function () {
		//Datepicker
    $('#datepicker').datetimepicker({
      format: 'YYYY-MM-DD'
    });
    $('#datepicker1').datetimepicker({
      format: 'YYYY-MM-DD'
    });
    $('#datepicker2').datetimepicker({
      format: 'YYYY-MM-DD'
    });
	
});		
</script>
<script type="text/javascript">
              function confirm_delete(delete_url) {
                $('#delBuyer').modal('show', {
                  backdrop: 'static'
                });
                document.getElementById('delete_link').setAttribute('href', delete_url);
              }
</script>
