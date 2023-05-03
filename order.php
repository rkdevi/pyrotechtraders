<?php
/* ============================================================
Project Name    : Pyrotech Traders
Created on      : May 2020
Updated By      : RK
=============================================================== */

$debug = 0;

$cus_name   = $_POST["name"];
$cus_phone  = $_POST["phone"];
$cart_table = $_POST["cart_table"];

//=======RK=====================================================
$cus_email   = $_POST['email'];
$cus_address = $_POST['address'];
$total       = $_POST['sales_total'];
$discount    = $_POST['sales_discount'];
$final_total = $_POST['sales_final_total'];

$json = $_POST['data'];
$data = json_encode($json);
//echo $data;

// ===========Create local database connection===================
/* $hostname     = "localhost";
$username     = "root";
$password     = "";
$databasename = "crackersale";    */

//============ Create server database connection=================
$hostname     = "localhost";
$username     = "octuljuq_rkdevi";
$password     = "Yalini2003";
$databasename = "octuljuq_crackersale";

$connection = mysqli_connect($hostname, $username, $password,$databasename);

// Check connection
if (!$connection) {
    die("Error : Unable to Connect database: " . mysqli_connect_error());
} else {
if ($debug) {
    echo "Connected successfully";
  }
}

if($_POST['name']){
  
      // =====================Sales Detail table updation======================================================
      $q             = "INSERT INTO salesdetail (CustomerName,Phone, Email, Address,Total,Discount,FinalTotal) VALUES ('$cus_name','$cus_phone',
      '$cus_email', '$cus_address',$total,$discount,$final_total)";

      $sql_query         = mysqli_query($connection, $q);
      //echo $q;
      //echo "<br>";
      //==========================Get the last Id from Sales datail table=======================================
      $last_id_query = "select Id from salesdetail order by Id desc limit 1" ; 
      $result        = mysqli_query($connection, $last_id_query);
      //echo $last_id_query;
      //echo "<br>";
      if (mysqli_num_rows($result) > 0) {
          while($rowData = mysqli_fetch_array($result)){
                $id      = $rowData[0];
        }
      }
    //======================= Sales Products table updation===================================================
    foreach($json as $item) { 
          $sno          = $item[0];
          $category1    = $item[1];
          $productname1 = $item[2];
          $noofpcs      = $item[3];
          
          $perrate     = floatval($item[4]);
          $qty         = floatval($item[5]);
          $amount      = floatval($item[6]);

          $productname2 = str_replace('(','-', $productname1);
          $productname3 = str_replace(')',' ', $productname2); 
          $productname4 = str_replace('"',' Inch', $productname3); 
          $productname5 = str_replace('&','PLUS', $productname4); 
          $productname  = str_replace("'"," ", $productname5); 
           

          $category2 = str_replace('(','-', $category1);
          $category3 = str_replace(')',' ', $category2); 
          $category4 = str_replace('"',' Inch', $category3); 
          $category5 = str_replace('&','PLUS', $category4); 
          $category  = str_replace("'"," ", $category5); 
        
          //echo $productname;
          //echo "<br>";
          //echo $category;
          //echo "<br>";
          $query       = "INSERT INTO salesproducts (Id,Sno, ProductName, NoOfpcs,PerRate,Qty,Amount,Category) VALUES (
          $id,
          '$sno',
          '$productname',
          '$noofpcs',
           $perrate,
           $qty,
           $amount,
          '$category')";
          //echo $query;
          //echo "<br>";
          // $query = mysqli_query($connection, $query);
   
          if ($connection->query($query) === TRUE) {
              //echo json_encode("Data Inserted Successfully");
          }
          else {
            echo 'Error: '. $connection->error;
          }
      }
              
        /* if($query){
          if ($debug) {
            echo json_encode("Data Inserted Successfully");
          }
        } else {
            echo json_encode('problem');
        } */
  }
  $connection->close();
              
//===============================================================


$mail_debug = 0;

$email = "";
$name = "Test";
$email_from = "pyrotechtraders@gmail.com";
$name_from = "PyroTech Traders";
$email_password = "";

#$email = "pyrotechtraders@gmail.com";
#$name = "PyroTech Traders";

$email = $cus_email;
$name = $cus_name;
$email_from = "pyrotechtraders@gmail.com";
$name_from = "PyroTech Traders";
$email_password = "Sarvesh_2011";

function SendMail($mail, $from, $from_name, $to, $to_name, $subject, $message) {

  $mail->SetFrom($from, $from_name);
  $mail->addAddress($to, $to_name);
  $mail->Subject = $subject;
  $mail->Body = $message;
  $mail->IsHTML(true);

  try{
      $mail->Send();
      if ($mail_debug) {
        echo "Mail sent to " . $to;
      }
  } catch(Exception $e){
      //Something went bad
      if ($mail_debug) {
        echo "Fail - " . $mail->ErrorInfo;
      }
  }
}

if ($email) {

  require("./libs/PHPMailer/src/Exception.php");
  require("./libs/PHPMailer/src/PHPMailer.php");
  require("./libs/PHPMailer/src/SMTP.php");

  $mail = new PHPMailer\PHPMailer\PHPMailer(true);

  $send_using_gmail = 1;

  //Send mail using gmail
  if($send_using_gmail){
      $mail->IsSMTP(); // telling the class to use SMTP
      $mail->SMTPDebug = 0;
      $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
      $mail->SMTPAuth = true; // enable SMTP authentication
      $mail->SMTPSecure = "tls"; // sets the prefix to the servier
      $mail->CharSet = "UTF-8";
      $mail->Port = 587; // set the SMTP port for the GMAIL server

      $mail->Username = $email_from; // GMAIL username
      $mail->Password = $email_password; // GMAIL password
  }


  $subject = "Order Recieved";
  $message = "<h3>Customer Details</h3>";
  $message = "<p>Name : " . $cus_name . "</p>";
  $message = $message . "<p>Phone : " . $cus_phone . "</p>";
  $message = $message . "<p>Address : " . $cus_address . "</p>";
  $message = $message . "<br><h3>Order Details</h3>";
  $message = $message . $cart_table;

  $cus_mail = $mail;
  $cus_subject = "Order Placed";
  $cus_message = $cart_table;
  $cus_message = $cus_message . "<br><br><p> <i>** Disclamier : It's an automated mail. This message is sent to you because your mail address was entered in our website. If you didn't enter your mail address, just ignore, it should be a mistake **</i></p>";
  
  /* To Vendor */
  SendMail(clone $mail, $email_from, $name_from, $email_from, $name_from, $subject, $message);

  /* To Customer */
  SendMail(clone $mail, $email_from, $name_from, $cus_email, $cus_name, $cus_subject, $cus_message);

} else {
  echo "Warning : Email Address not provided!";
}

echo "Order Placed Successfully!<br><br>";
echo "An email with the order details has been sent to you.";

?>