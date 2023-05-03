<?php

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

// Create database connection
/* $hostname     = "localhost";
$username     = "root";
$password     = "";
$databasename = "crackersale"; */

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
  
  // Sales Detail table updation
  $q             = "INSERT INTO salesdetail (CustomerName,Phone, Email, Address,Total,Discount,FinalTotal) VALUES ('$cus_name','$cus_phone',
  '$cus_email', '$cus_address',$total,$discount,$final_total)";

  $sql_query         = mysqli_query($connection, $q);
  //echo $q;
  echo "<br>";
  //Get the last Id from Sales datail table
  $last_id_query = "select Id from salesdetail order by Id desc limit 1" ; 
  $result        = mysqli_query($connection, $last_id_query);
  //echo $last_id_query;
  echo "<br>";
  if (mysqli_num_rows($result) > 0) {
      while($rowData = mysqli_fetch_array($result)){
            $id      = $rowData[0];
    }
  }
  // Sales Products table updation
  foreach($json as $item) { 
    $sno         = $item[0];
    $productname = $item[1];
    //$noofpcs   = $item[2];
    // $perrate  = $item[3];
    // $qty      = $item[4];
    // $amount   = $item[5];
    $noofpcs     = 0;
    $perrate     = floatval($item[4]);
    $qty         = floatval($item[5]);
    $amount      = floatval($item[6]);

    $query       = "INSERT INTO salesproducts (Id,Sno, ProductName, NoOfpcs,PerRate,Qty,Amount) VALUES (
      $id,
      $sno,
      '$productname',
      $noofpcs,
      $perrate,
      $qty,
      $amount)";
      //echo $query;
    // echo "<br>";
    // $query = mysqli_query($connection, $query);

    //$query = "INSERT INTO contacts VALUES ('','$name','$address','$city','$state','$zip','$phone','$email_address','$arrive','$depart','$room','$found','$promocode','$message','$datetimestamp','$ip')";
    // Performs the $query on the server to insert the values
    if ($connection->query($query) === TRUE) {
    //echo 'users entry saved successfully';
    }
    else {
      echo 'Error: '. $connection->error;
    }
  }
          
  if($query){
    if ($debug) {
      echo json_encode("Data Inserted Successfully");
    }
  } else {
      echo json_encode('problem');
  }
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

  $cus_mail = $mail;

  $subject = "Order Recieved";
  $cus_subject = "Order Placed";
  $message = "<h3> Name : " . $cus_name . "</h3>";
  $message = $message . "<h3> Phone : " . $cus_phone . "</h3>";
  $message = $message . "<h3> Address : " . $cus_address . "</h3>";
  $message = $message . $cart_table;
  
  SendMail(clone $mail, $email_from, $name_from, $email_from, $name_from, $subject, $message);
  SendMail(clone $mail, $email_from, $name_from, $cus_email, $cus_name, $cus_subject, $message);

} else {
  echo "Warning : Email Address not provided!";
}

echo "Order Placed Successfully!<br><br>";
echo "An email with the order details has been sent to you.";

?>