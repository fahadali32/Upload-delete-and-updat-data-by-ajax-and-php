<?php
	include 'db.php';
   if(!empty($_POST['pname']) || !empty($_POST['plink']) || !empty($_POST['pdes'])){

//if(isset($_POST['submit'])){
   	  $errors= array();
   	  $name = mysqli_real_escape_string($con,$_POST['pname']);
      $link = mysqli_real_escape_string($con,$_POST['plink']);
      $des = mysqli_real_escape_string($con,$_POST['pdes']);
      $id = mysqli_real_escape_string($con,$_POST['id']);

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
         
         $query = "UPDATE `uploading` SET `pname`='$name',`plink`='$link',`pdes`='$des',`image`='$location' WHERE id= $id";
        
         mysqli_query($con,$query);
         
         echo "Success";
         }
      else{
          print_r($errors);
      }
        
  }
?>

<!--
<form id="form" method="post"  enctype="multipart/form-data" >
<fieldset>

<input type="name" placeholder="Name" name="pname" ></input>
<input type="file" name="image" ></input>
<input type="text" placeholder="link" name="plink"></input>
<input type="text" name="id" placeholder="Id" ></input>  
<input type="text" name="pdes" placeholder="Description" ></input>  
<input type="submit" name="submit"  value="SUBMIT">
</fieldset>
</form>
-->