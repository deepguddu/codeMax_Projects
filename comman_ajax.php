<?php  include('config.php');
$action = $_POST['action'];
switch ($action) {
	
	case "view_data":
		
		$confunc 	= new commanFunction();
		
		$table		=	"cd_modal as cdm, cd_manufacturer as cdman";
		$field 		=	"cdm.*, cdman.manufacturerId, cdman.manufacturer_name";
		$con		=	"WHERE cdm.manufacturer_id = cdman.manufacturerId AND cdm.status = 'available' AND cdm.modal_name = '".$_POST['modelname']."'  ORDER BY cdm.modalid ASC";

		$row_modal	=	$confunc->select_multiplerow($table, $field, $con);
	
		//echo "<pre>";print_r($row_modal);
		$get_html = '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
			<thead>
				<tr>
					<th>Sr No.</th>
					<th>Manufacturer Name</th>
					<th>Name</th>
					<th>Color</th>
					<th>Manufacturing Year</th>
					<th>Note</th>
					<th>Registration No</th>
					<th>Action</td>
				</tr>
			</thead>
			<tbody>';
				$i=1; foreach($row_modal as $rowval){
					
					$modalname	=	"'".trim($rowval['modal_name'])."'";
					$jqeryevent	=	'onclick="Modal_Status('.$rowval['modalid'].','.$modalname.');"';
					
					$get_html .= '<tr class="odd gradeX">
						<td>'.$i.'</td>
						<td>'.$rowval['manufacturer_name'].'</td>
						<td>'.$rowval['modal_name'].'</td>
						<td>'.$rowval['modal_color'].'</td>
						<td>'.$rowval['manufacturing_year'].'</td>
						<td>'.$rowval['note'].'</td>
						<td>'.$rowval['registration_number'].'</td>
						<td class="center"><a href="Javascript:;" '.$jqeryevent.' class="btn btn-success">Sold</a></td>
					</tr>';
					$i++;
				}
			$get_html .= '</tbody>
		</table>';
		echo $get_html;
	break;
	
	case "update_status":
		
		$confunc 	=	new commanFunction();
		
		$table	=	"cd_modal";
		$value	=	"status = 'sold'";
		$con	=	"WHERE modalid = ".$_POST['modalid'];
		
		$getstatus = $confunc->update_data($table,$value,$con);
		
		if($getstatus == "updated"){
			
			$table		=	"cd_modal as cdm, cd_manufacturer as cdman";
			$field 		=	"cdm.*, cdman.manufacturerId, cdman.manufacturer_name";
			$con		=	"WHERE cdm.manufacturer_id = cdman.manufacturerId AND cdm.status = 'available' AND cdm.modal_name = '".$_POST['modelname']."'  ORDER BY cdm.modalid ASC";

			$row_modal	=	$confunc->select_multiplerow($table, $field, $con);
		
			if(is_array($row_modal)){
				$get_html = '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
						<tr>
							<th>Sr No.</th>
							<th>Manufacturer Name</th>
							<th>Name</th>
							<th>Color</th>
							<th>Manufacturing Year</th>
							<th>Note</th>
							<th>Registration No</th>
							<th>Action</td>
						</tr>
					</thead>
					<tbody>';
						$i=1; foreach($row_modal as $rowval){
							
							$modalname	=	"'".trim($rowval['modal_name'])."'";
							$jqeryevent	=	'onclick="Modal_Status('.$rowval['modalid'].','.$modalname.');"';
							
							$get_html .= '<tr class="odd gradeX">
								<td>'.$i.'</td>
								<td>'.$rowval['manufacturer_name'].'</td>
								<td>'.$rowval['modal_name'].'</td>
								<td>'.$rowval['modal_color'].'</td>
								<td>'.$rowval['manufacturing_year'].'</td>
								<td>'.$rowval['note'].'</td>
								<td>'.$rowval['registration_number'].'</td>
								<td class="center"><a href="Javascript:;" '.$jqeryevent.' class="btn btn-success">Sold</a></td>
							</tr>';
							$i++;
						}
					$get_html .= '</tbody>
				</table>';
			}else{
				$get_html = '<span id="invalid">No Records Found.</span><br/>';
			}
			echo $get_html;
			
			
		}else{
			echo 'error';
		}
		
	break;
}	

?>
