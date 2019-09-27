<!doctype html>
<html>
<head lang="en">
	<meta charset="utf-8">
	<title>Ajax File Upload with jQuery and PHP</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="jquery.min.js"></script>
	<script type="text/javascript">
	
	$(document).ready(function (e) {
	displayFromDatabase();
	$("#form").on('submit',(function(e) {
	e.preventDefault();
	
	$.ajax({
	url: "upload.php",
	type: "POST",
	data:  new FormData(this),
	contentType: false,
	cache: false,
	processData:false,
	
	success: function(data)	{
	displayFromDatabase();
	},
	error: function(e){
	$("#error").html(e).fadeIn();
	}          
	});
	}));
	});
	</script>
	<script type="text/javascript">
	function displayFromDatabase(){
	$.ajax({
	//display:1,
	url:'upload.php',
	type:'POST',
	
	success:function(data){
	$("#demo").html(data);
	} 
	});
	}
	</script>
	<!-- Latest compiled and minified CSS -->

</head>
<body>
<form id="form" method="post" enctype="multipart/form-data" >
<fieldset>
<legend>Edit Your Portfolio<span style="color:red;">*</span></legend>
<input type="name" placeholder="Edit Portfolio Name" name="pname" ></input>
<input type="file" name="image"></input>
<input type="link" placeholder="Portfolio Example Link" name="plink" ></input>
<textarea placeholder="Portfolio Description"  name="pdes" ></textarea>

<input type="submit" value="Upload">
</fieldset>
</form>

<div id="error" ></div>
<div id="result" ></div>
<div id="demo" ></div>
</body>
</html>