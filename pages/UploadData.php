<!-- Main content -->
      <div class="container-fluid">
		<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-info"></i> Info</h5>
                  Upload Data Stock Kain Jadi
		</div>  
		<form role="form" method="post" enctype="multipart/form-data" name="form1" >  
		<div class="card card-purple">
          <div class="card-header">
            <h3 class="card-title">Upload Data Persediaan Kain</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">             
			<div class="form-group">
                    <label for="file">File input CSV</label>
                    <div class="input-group">
                      <div class="custom-file">
						<input type="file" name="file" id="file" class="input-large" accept=".csv">
                        <label class="custom-file-label" for="file">Choose file</label>
                      </div>
                      <div class="input-group-append">
						<button type="submit" id="submit" name="submit" class="mb-3 btn btn-primary button-loading" data-loading-text="Loading...">Upload</button>  
                      </div>
                    </div>
                  </div>  
			 
		  </div>
		  <div class="card-footer">
           <a href="DataUpload" class="btn btn-info">Kembali</a>
          </div>
		  <!-- /.card-body -->
          
        </div> 
	</form>
		          
</div><!-- /.container-fluid -->
    <!-- /.content -->
<?php
 
if (isset($_POST['submit']))
{
 
    // Allowed mime types
    $fileMimes = array(
        'text/x-comma-separated-values',
        'text/comma-separated-values',
        'application/octet-stream',
        'application/vnd.ms-excel',
        'application/x-csv',
        'text/x-csv',
        'text/csv',
        'application/csv',
        'application/excel',
        'application/vnd.msexcel',
        'text/plain'
    );
 
    // Validate whether selected file is a CSV file
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileMimes))
    {
 			$nameFile = $_FILES['file']['name'];
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
 
            // Skip the first line
            fgetcsv($csvFile);
 
            // Parse data from CSV file line by line
             // Parse data from CSV file line by line
            while (($getData = fgetcsv($csvFile, 100000, ",")) !== FALSE)
            {
                // Get row data
                $tgl_buat 	= $getData[0];
                $SN 		= $getData[1];
                $KG 		= $getData[2];
                $zone 		= str_replace("'", "''",$getData[3]);
                $lokasi 	= str_replace("'", "''",$getData[4]);
                $nowarna 	= str_replace("'", "''",$getData[5]);
                $warna 		= str_replace("'", "''",$getData[6]);
                $lot 		= str_replace("'", "''", $getData[7]);
				$idUp 		= $_GET['id'];
 				
                mysqli_query($con, "INSERT INTO tbl_stokfull (tgl_buat, SN, KG, zone, lokasi, nowarna, warna, lot, id_upload) 
				VALUES ('" . $tgl_buat . "', '" . $SN . "', '" . $KG . "', '" . $zone . "', '" . $lokasi . "', '" . $nowarna . "', '" . $warna . "', '" . $lot ."', '" . $idUp . "')"); 
               
            }
 			
		  $sqlupdateUP=mysqli_query($con, "UPDATE tbl_upload SET 
		  nama_file='$nameFile',
		  tgl_upload=now()
		  WHERE id='$idUp'");
		
            // Close opened CSV file
            fclose($csvFile);
            echo "<script type=\"text/javascript\">
            alert(\"CSV File berhasil terkirim\");
            window.location = \"DataUpload\"
            </script>";  
    }
    else
    {
        echo "<script type=\"text/javascript\">
        alert(\"CSV/Excel File gagal terkirim\");
        window.location = \"DataUpload\"
    </script>";
    }

}
?>



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