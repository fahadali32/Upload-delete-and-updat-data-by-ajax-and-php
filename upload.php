<?php
	include 'db.php';
   if(!empty($_POST['pname']) || !empty($_POST['plink']) || !empty($_POST['image'])|| !empty($_FILES['pdes'])){
   	  $errors= array();
      $name = htmlspecialchars(stripslashes(trim(mysqli_real_escape_string($con,$_POST['pname']))));
      $link = htmlspecialchars(stripslashes(trim(mysqli_real_escape_string($con,$_POST['plink']))));
    
      
      $des = htmlspecialchars(stripslashes(trim(mysqli_real_escape_string($con,$_POST['pdes']))));
      

      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
      $fileinfo=PATHINFO($file_name);
      $newFilename=$fileinfo['filename'] ."_". time() . "." . $fileinfo['extension'];
      $location="uploads/" . $newFilename;
      
      
      $extensions= array("jpeg","jpg","png","gif");
      
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"uploads/".$newFilename);
         
         $query = "INSERT INTO uploading (pname, plink, pdes, image) VALUES ('$name', '$link', '$des', '$location')";
        
         mysqli_query($con,$query);
         
         echo "Success";
         }
      else{
          print_r($errors);
      }
        
  }
?>
<!DOCTYPE html>
<html>
<head>
<title>Data table</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css">
<script src="jquery.min.js"></script>
</head>
<body>
<div>
<table id="table" >
  <tr>
   <th>Portfolio Name</th>
   <th>Portfolio Image</th>
   <th>Portfolio Link</th>
   <th>Portfolio Description</th>
   <th>Portfolio Edit</th>	
  </tr>
  
<!--table's data showing php started-->


<?php

$query = "select * from uploading";
		$result=mysqli_query($con,$query);
		while($row = mysqli_fetch_array($result)){
?>

<!--table started-->
<tr id="<?php echo $row['id']; ?>">


<td class="name" data-target="name">
<?php echo $row['pname']?>
</td>


<td class="image" data-target="image">
<img src="<?php echo $row['image']; ?>" class="table-image"/>
</td>

<td class="link" data-target="link">
<?php echo $row['plink']; ?>
</td>

<td class="des" data-target="des">
<?php echo $row['pdes']; ?>
</td>

<td>
<div class="button">
<button id="edit" data-id="<?php echo $row['id']; ?>">Update</button>
<button id="delete" data-id="<?php echo $row['id']; ?>">Delete</button>

</div>
</td>




</tr>
<?php }?>


<!--table stopped-->
</table>
</div>

<!--modal box script started-->
<script>


$(document).ready(function(){
$(document).on('click',"#edit",function(){
	//alert($(this).data('id'));
$("#modal").css("display","block");
	var id = $(this).data('id');
	var name = $('#'+id).children('td[data-target=name]').text();
	var link = $('#'+id).children('td[data-target=link]').text();
	var des = $('#'+id).children('td[data-target=des]').text();


$("#pname").val(name);
$("#plink").val(link);
$("#pdes").val(des);
$("#userId").val(id);
});
//Create update via ajax

$(document).ready(function (e) {

$("#update").on('submit',(function(e) {
e.preventDefault();

$.ajax({

url: "update.php",
type: "POST",
data:  new FormData(this),
contentType: false,
cache: false,
processData:false,

success: function(data)	{
$("#modal").css("display","none");
refresh();
},  
});
}));
});


$("#close").click(function(){
	$("#modal").css("display","none");
});
});


</script>
<!--modal box script stopped-->

<script>
function refresh(){
$.ajax({
//display:1,
//url:'upload.php',
type:'POST',

success:function(data){
$("#table").html(data);
} 
});
}
</script>

<script type="text/javascript">
$(document).ready(function(){
$(document).on('click','#delete',function(){
	//alert($(this).data('id'));
	var id = $(this).data('id');
	$.ajax({
	url:'delete.php',
	type:'POST',
	data:{id:id},
	success:function(data){
	refresh();
	}
	});
});
});
</script>

<!--modal started-->
<div class="modal" id="modal" >

<div class="modalbox" >
<span id="close" >x</span>
<!--modal input or update input form-->
<div id="up-in">

<form id="update" method="post"  enctype="multipart/form-data" > 

<input type="hidden" name="id" id="userId"  ></input> 
<input type="name" id="pname" placeholder="Name" name="pname" ></input>
<input type="file" name="image" ></input>
<input type="text" id="plink"  placeholder="link" name="plink"></input>
<textarea id="pdes" name="pdes" placeholder="Description" ></textarea>
<input type="submit" value="SUBMIT">

</form>
</div>
</div> 
</div>

<!--modal stopped-->

</body>
</html>
		