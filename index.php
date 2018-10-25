<?php session_start();

$title = "Add Manufacturer";
include('header.php');

$confunc 	= new commanFunction();

$msg = "";

if(isset($_POST['submit'])){
	
	$manufacturer_name = ucfirst(trim($_POST['manufacturer_name']));
	
	$table_name	=	"cd_manufacturer";
	$table_value=	"manufacturer_name	=	'".$manufacturer_name."',
					addedate			=	NOW()";
	
	
	$insert_query = $confunc->insert_data($table_name, $table_value);
	if($insert_query = "inserted"){
		$msg = '<div class="alert alert-success">Manufacturer added successfully.</div>';	
	}else{
		$msg = '<div class="alert alert-danger">There is an error.</div>';
	}
	
}


?>
<form action="" method="POST" name="adddeveloper" class="form-inner-div">
	<?php echo $msg; ?>
	<div class="form-group">
		<label for="productname" class="loginFormElement">Manufacturer Name:</label>
		<input class="form-control" id="name" type="text" name="manufacturer_name" value="" required />
	</div>
	<button type="submit" id="loginSubmit" name="submit" value="Submit" class="btn btn-success loginFormElement">Submit</button>
</form>
<?php include('footer.php');?>