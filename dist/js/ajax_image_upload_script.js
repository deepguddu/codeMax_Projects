$(document).ready(function (e) {
	/*$("#uploadimage").on('submit',(function(e) {
		e.preventDefault();
		$("#message").empty();
		$('#loading').show();
		$.ajax({
			url: "ajax_php_file.php", // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			success: function(data)   // A function to be called if request succeeds
			{
			console.log(data);
			$('#loading').hide();
			$("#message").html(data);
			}
		});
	}));*/

	
	// Function to preview image after validation
	$(function() {
		$("#upload_picture").change(function() {
			
			$("#message").empty(); // To remove the previous error message
			var file = this.files[0];
			var imagefile = file.type;
			var match= ["image/jpeg","image/png","image/jpg"];
			if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))){
				$('#previewing').attr('src','noimage.png');
				$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
				return false;
			
			}else{
				var reader = new FileReader();
				reader.onload = imageIsLoaded;
				reader.readAsDataURL(this.files[0]);
			}
		});
	});

	function imageIsLoaded(e) {
		//alert(e.target.result);
		$("#upload_picture").css("color","green");
		$('#image_preview').css("display", "block");
		$('#image_preview').html('<img id="previewing" src="'+e.target.result+'" /><a href="Javascript:;" class="btn btn-success upload_Button" onclick="uploadimage();" >Upload Image</a>');
		//$('#previewing').attr('src', e.target.result);
		$('#previewing').attr('width', '250px');
		$('#previewing').attr('height', '230px');
	};
});


function uploadimage(){
	var file_data = $('#upload_picture').prop('files')[0];   
	var form_data = new FormData();                  
	form_data.append('file', file_data);
	$.ajax({
		url: "ajax_php_file.php",
		type: "POST",
		data: form_data,
		contentType: false,
		cache: false,
		processData:false,
		success: function(data){
			console.log(data);
			if(data != "error"){
				$('#viewuplodedimg').append('<div class="col-sm-6"><img src="upload/'+data+'" id="uploded_imgCss"><input type="hidden" name="uploded_imgname[]" value="'+data+'"></div>');
				$('#image_preview').hide();
				$('#message').html('<span id="success">Image Uploaded Successfully...!!</span><br/>');
			}else{
				$('#message').html('<span id="invalid">Invalid file Size or Type<span>');
			}
		}
	});
}

function isNumber(evt) {
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if ( (charCode > 31 && charCode < 48) || charCode > 57) {
		return false;
	}
	return true;
}
