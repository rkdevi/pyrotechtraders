<!--Import Excel File into MySQL Database using PHP-->

<?php 
$debug = 0;
if(isset($_POST["Import"]))
{
   
    $hostname     = "localhost";
    $username     = "root";
    $password     = "";
    $databasename = "crackersale";

    $conn = mysqli_connect($hostname, $username, $password,$databasename);
   // Check connection
    if (!$conn) {
        die("Error : Unable to Connect database: " . mysqli_connect_error());
    } else {
        if ($debug) {
            echo "Connected successfully";
        }
    }


    
    if(!$conn){
        die('Could not Connect My Sql:' .mysqli_error());
        }
    echo $filename=$_FILES["file"]["tmp_name"];
    if($_FILES["file"]["size"] > 0)
    {
        $file = fopen($filename, "r");
        $count = 0;   
     
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {
            //print_r($emapData);
            $count++;  
  
           if($count>1){  

                $category1    = $emapData[1]; 

                $productname1 = $emapData[2]; 

                $productname2 = str_replace('(','-', $productname1);
                $productname3 = str_replace(')','.', $productname2); 
                $productname4 = str_replace('"',' Inch ', $productname3); 
                $productname5 = str_replace('&','PLUS', $productname4); 
                $productname  = str_replace("'"," ", $productname5); 
                

                $category2 = str_replace('(','-', $category1);
                $category3 = str_replace(')','.', $category2); 
                $category4 = str_replace('"',' Inch ', $category3); 
                $category5 = str_replace('&','PLUS', $category4); 
                $category  = str_replace("'"," ", $category5); 

                $list_name = $_POST['list_name'];
                //echo $list_name;
           
                $sql = "INSERT into Product(SNo,Category,Product_Name,Content_Box,List_price,List_Name) values ('$emapData[0]','$category','$productname',
               '$emapData[3]','$emapData[4]','$list_name')";
           

                // if ($conn->query($sql) === TRUE) {
                //      //echo json_encode("Data Inserted Successfully");
                // }
                // else {
                // echo 'Error: '. $conn->error;
                // }
          
               /*  echo $emapData[0];
                echo "<br>";
                $emapData[1];
                echo "<br>";
                echo $emapData[2];
                echo "<br>";
                $emapData[3];
                echo "<br>";
                echo $emapData[4];
                echo "<br>"; */
            }
        } 

        
        fclose($file);
        echo 'CSV File has been successfully Imported';
        //header('Location: index.php');
        header("Refresh:3");
    } else
        echo 'Invalid File:Please Upload CSV File';
}
?>
<form enctype="multipart/form-data" method="post" role="form" style="padding-left:30%;">
<div class="form-group" >
<h2>Import Excel File into MySQL Database using PHP</h2>
<table style="width:500px;background-color:green;height:25%;color:white;">
<tr>
<td>Upload List Name
</td>
<td>
<input name="list_name" id="list_name" type="text">
</td>
</tr>
<tr>
<td>
    <label for="exampleInputFile">File Upload</label>
 </td>
<td>
 <input type="file" name="file" id="file" size="150">
</td>
</tr>
<tr>
<td><p class="help-block">Only Excel/CSV File Import.</p>
</td>
<td><button type="submit" class="btn btn-default" name="Import" value="Import">Upload</button>
</td>
</tr>
</table>
   
</div>  
</form>