<?php
$title = "Add Model";
include('header.php');

$confunc 	= new commanFunction();

$msg = "";

if(isset($_POST['submit'])){
	
	$table_name	=	"cd_modal";
	$table_value=	"manufacturer_id	=	'".$_POST['manufacturer_id']."',
					modal_name			=	'".$_POST['modal_name']."',
					modal_color			=	'".$_POST['modal_name']."',
					manufacturing_year	=	'".$_POST['manufacturing_year']."',
					note				=	'".$_POST['note']."',
					registration_number	=	'".$_POST['registration_number']."',
					status				=	'available',
					addedate			=	NOW()";
	
	
	$insert_query = $confunc->insert_id_data($table_name, $table_value);
	if(is_numeric($insert_query)){
		
		$mid = $insert_query;
		
		foreach($_POST['uploded_imgname'] as $imageval){
			$table_img	=	"cd_modal_image";
			$img_value	=	"modalid	=	'".$mid."',
							image_name	=	'".$imageval."',
							addedate			=	NOW()";
			
			$insert_query = $confunc->insert_data($table_img, $img_value);
		}
	
		$msg = '<div class="alert alert-success">Modal added successfully.'.$insert_query.'</div>';	
	}else{
		$msg = '<div class="alert alert-danger">There is an error.</div>';
	}
}


$mtable	=	'cd_manufacturer';
$mfield =	'*';
$mcon	=	'ORDER BY manufacturer_name ASC';	

$get_manufacturer = $confunc->select_multiplerow($mtable, $mfield, $mcon);

//echo "<pre>";print_r($get_manufacturer);
?>

<!------- Ajax image upload js file -------->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="dist/js/ajax_image_upload_script.js"></script>
<!------ end -------------->

<form action="" method="POST" id="adddeveloper" name="adddeveloper" enctype="multipart/form-data" class="form-inner-div">
	<?php echo $msg; ?>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-6">
				<label for="productname" class="loginFormElement">Manufacturer:</label>
				<?php $html = '<select name="manufacturer_id" class="form-control">
				<option value="">Select Manufacturer</option>';
				foreach($get_manufacturer as $manfacturerVal){
					$html .= '<option value="'.$manfacturerVal['manufacturerId'].'">'.$manfacturerVal['manufacturer_name'].'</option>';
				}
				$html .= '</select>';
				echo $html;?>
			</div>
			<div class="col-sm-6">
				<label for="productname" class="loginFormElement">Modal Name:</label>
				<input type="text" name="modal_name" value="" class="form-control" />
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-6">
				<label for="productname" class="loginFormElement">Color:</label>
				<input type="text" name="modal_color" value="" class="form-control" />
			</div>
			<div class="col-sm-6">
				<label for="productname" class="loginFormElement">Manufacturing Year:</label>
				<input type="text" name="manufacturing_year" value="" class="form-control" />
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-6">
				<label for="productname" class="loginFormElement">Note:</label>
				<textarea name="note" value="" class="form-control" ></textarea>
			</div>
			<div class="col-sm-6">
				<label for="productname" class="loginFormElement">Registration Number:</label>
				<input type="text" name="registration_number" value="" class="form-control" />
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-6">
				<label for="productname" class="loginFormElement">Upload Picture:</label>
				<input type="file" name="picture[]" id="upload_picture" value="" class="form-control" />
				<div id="image_preview"></div>
				<div id="getmessage">
					<h4 id="loading">loading..</h4><div id="message"></div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row" id="viewuplodedimg">
					
				</div>
			</div>
		</div>
	</div>
	
	
	
	<button type="submit" id="loginSubmit" name="submit" value="Submit" class="btn btn-success loginFormElement">Submit</button>
</form>
<?php include('footer.php');?>