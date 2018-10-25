<?php $title = "View Inventory";
include('header.php');

$confunc 	= new commanFunction();

$table		=	"cd_modal as cdm, cd_manufacturer as cdman";
$field 		=	"cdm.modalid, cdm.modal_name, cdm.manufacturer_id, cdman.manufacturerId, cdman.manufacturer_name";
$con		=	"WHERE cdm.manufacturer_id = cdman.manufacturerId AND cdm.status = 'available' GROUP BY cdm.modal_name ORDER BY cdm.modalid ASC";

$row_modal	=	$confunc->select_multiplerow($table, $field, $con); ?>
<div class="panel-body">
		<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
			<thead>
				<tr>
					<th>Serial Number</th>
					<th>Manufacturer Name</th>
					<th>Model Name</th>
					<th>Count</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=1;
				if(is_array($row_modal)){
					foreach($row_modal as $rowval){
						
						$getcount 	=	$confunc->get_row_count('cd_modal','COUNT(modal_name) as totalcount','WHERE modal_name = "'.$rowval['modal_name'].'" AND status = "available" GROUP BY modal_name');
						$modalname	=	"'".trim($rowval['modal_name'])."'";
						$jqeryevent	=	'onclick="view_all_data('.$modalname.','.$rowval['manufacturer_id'].');"';
						
						echo '<tr class="odd gradeX">
							<td>'.$i.'</td>
							<td>'.$rowval['manufacturer_name'].'</td>
							<td>'.$rowval['modal_name'].'</td>
							<td class="center">'.$getcount.'</td>
							<td class="center"><a href="Javascript:;" '.$jqeryevent.' ><i class="fa fa-eye"></i></a></td>
						</tr>';
						$i++;
					}
				}?>
			</tbody>
	</table>
	
	<!--popup -->

<!-- Trigger the modal with a button -->


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Details</h4>
      </div>
	  <div id="status_msg"></div>
      <div class="modal-body" id="modal_details">
      </div>
    </div>
  </div>
</div>
<!-- end popup -->
</div>
<!-- /.panel -->

<script type="text/javascript">
function view_all_data(modalname,manufacturerId){
	$('.modal').show();
	$('.modal').addClass('in');
	
	var datastring = "action=view_data&modelname="+modalname+"&manufacturerId="+manufacturerId;
	
	$.ajax({
		type: "POST",
		url: 'comman_ajax.php',
		data: datastring,
		cache: false,
		success: function(result){
			//console.log(result);
			$('#modal_details').html(result);
		}
	});
}

$(".close").click(function() {
	$('.modal').hide();
	$('.modal').removeClass('in');
	location.reload();
});

function Modal_Status(mid,mname){
	
	
	var a = confirm("Are you sure, you want to changed the status to sold ?");
	
	if(a){
		var datastring = "action=update_status&modalid="+mid+'&modelname='+mname;
		
		$.ajax({
			type: "POST",
			url: 'comman_ajax.php',
			data: datastring,
			cache: false,
			success: function(result){
				//console.log(result);
				if(result == "error"){
					$('#status_msg').html('<span id="invalid">There is an error.</span><br/>');
				}else{
					$('#modal_details').html(result);
					$('#status_msg').html('<span id="success">Modal Sold Successfully...!!</span><br/>');
				}	
			}
		});
	}
}

</script>
<?php include('footer.php');?>
