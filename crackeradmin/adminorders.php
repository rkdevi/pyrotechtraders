<?php
/* ============================================================
Project Name    : Pyrotech Traders
File Created By : R.K
Created on      : 13-10-2020
Updated By      : R.K
=============================================================== */
$debug = 0;

$id = !empty($_POST['id']) ? $_POST['id'] : '';
$sid = !empty($_POST['sid']) ? $_POST['sid'] : '';
//echo $sid;
//echo "select * from salesdetail where Payment_Status='$sid'";
/* $payment_status = !empty($_POST['ptype']) ? $_POST['ptype'] : '';
$payment_id = !empty($_POST['rid']) ? $_POST['rid'] : '';

$delivery_status = !empty($_POST['dtype']) ? $_POST['dtype'] : '';
$delivery_id = !empty($_POST['did']) ? $_POST['did'] : '';
 */
// ===========Create local database connection===================
$hostname     = "localhost";
$username     = "root";
$password     = "";
$databasename = "crackersale";  

//============ Create server database connection=================
/* $hostname     = "localhost";
$username     = "octuljuq_rkdevi";
$password     = "Yalini2003";
$databasename = "octuljuq_crackersale"; */  

$conn = mysqli_connect($hostname, $username, $password,$databasename);

// Check connection
if (!$conn) {
    die("Error : Unable to Connect database: " . mysqli_connect_error());
} else {
if ($debug) {
    echo "Connected successfully";
  }
}

// ======================Customer product details================================================
if($id!=""){
 
  $query = "select * from salesdetail where Id=$id" ; 
  $order_result        = mysqli_query($conn, $query);
  while($order_data = mysqli_fetch_row($order_result))
  {   
   
  echo "<h2>Order No : $order_data[0]</h2>
  <table border='0' width = 100%>
    <tr>
      <td width =70%>
        <h4>Customer Name : $order_data[1]</h4>
        <h5>Phone :$order_data[2]</h5>
        <h5>Email : $order_data[3]</h5>
        <h5>Address :$order_data[4]</h5>
      </td>
      <td >
        <h4>Total &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ₹ $order_data[5]</h4>
        <h4>Discount&nbsp;&nbsp; : ₹ $order_data[6]</h4>
        <h4>Final total : ₹ $order_data[7]</h4>
      </td>
    </tr>
   </table> <br>";
}
// ======================Total ordered product details================================================
$result=mysqli_query($conn,"SELECT * from salesproducts where Id =$id");

echo "<table border='1' class='customers'>
      <tr>
       
        <th>S.No</th>
        <th>Category</th>
        <th>Product Name</th>
        <th>No Of Pcs</th>
        <th>Rate</th>
        <th>Qty</th>
        <th>Amount</th>
      </tr>";

      while($data = mysqli_fetch_row($result))
      {   
          echo "<tr>";
          
          echo "<td align=center>$data[1]</td>";
          echo "<td align=left>$data[2]</td>";
          echo "<td align=left>$data[7]</td>";
          echo "<td align=center>$data[3]</td>";
          echo "<td align=right>$data[4]</td>";
          echo "<td align=center>$data[5]</td>";
          echo "<td align=right>$data[6]</td>";
          echo "</tr>";
      }
echo "</table>";

}

// ======================Uppdate payment status================================================

$payment_val =!empty($_POST['payment_val']) ? $_POST['payment_val'] :'';
$payment_status =!empty($_POST['payment_apply']) ? $_POST['payment_apply'] : '' ;

$query1 ="UPDATE salesdetail SET Payment_status ='$payment_status'  where Id ='$payment_val'";
$result=mysqli_query($conn,$query1)or die(mysql_error());

// if($payment_status=="to_pay"){
  
//     $query1 ="UPDATE salesdetail SET Payment_status = 1 where Id ='$payment_id'";
//     $result=mysqli_query($conn,$query1);
// }
// ======================Uppdate payment status================================================

$delivery_val =!empty($_POST['delivery_val']) ? $_POST['delivery_val'] :'' ;
$delivery_status = !empty($_POST['delivery_apply']) ? $_POST['delivery_apply'] :'';

  $query1 ="UPDATE salesdetail SET Delivery_status = '$delivery_status' where Id ='$delivery_val'";
  $result=mysqli_query($conn,$query1)or die(mysql_error());

?>