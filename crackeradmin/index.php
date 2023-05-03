<?php
/* ============================================================
Project Name    : Pyrotech Traders
File Created By : R.K 
Created on      : 13-10-2020
Updated By      : R.K 
=============================================================== */
include_once 'adminorders.php';

?>
<!DOCTYPE HTML>
<html>

<head>
  <title>PyroTech</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
  <link rel="stylesheet" type="text/css" href="style/style.css" title="style" />

   <script  language="JavaScript" type="text/javascript"  src="js/jquery.min.js"></script> 
   <script src="js/script.js"></script>
   <script type="text/javascript">
    $(document).ready(function(){
        $("input[name='payment_status']:checkbox").on("change", function () {
            var val = $(this).val();
            var apply = $(this).is(':checked') ? 1 : 0;
            $.ajax({type: "POST",
                url: "adminorders.php",
                data: {payment_val: val, payment_apply: apply},
                success :function(data){
                  window.alert("Payment status updated successfully");
                }
            });
        });
        $("input[name='delivery_status']:checkbox").on("change", function () {
            var val = $(this).val();
            var apply = $(this).is(':checked') ? 1 : 0;
            $.ajax({type: "POST",
                url: "adminorders.php",
                data: {delivery_val: val, delivery_apply: apply},
                success : function(data){
                     window.alert("Delivery status updated successfully");
                }
            });
        });

       
       
   });
   
   $(function () {
        $("#search").change(function () {
            var selectedText = $(this).find("option:selected").text();
            var selectedValue = $(this).val();
            alert("Selected Text: " + selectedText + " Value: " + selectedValue);
           // window.location.href="index.php?sid="+selectedValue;
            //$("#order_menu").click();
           // GoToOrders()
          // $_SESSION['search']= selectedValue;
           //sessionStorage.setItem("MyId", 123);
   // var value = sessionStorage.getItem("MyId");
   Session['search'] = selectedValue; 
  //  alert(value);
            //$.session.set('search',selectedValue)
           // $.session.set("search",selectedValue);
//alert($.session.get("search"));
//@Session["search"]=selectedValue;
        });
    });
   // $("#search").bind("change",function(){
    // var val =this.val();
   // window.alert(val);
     //form.submit();
    // $.session.set("compareLeftContent",val);
//alert($.session.get("compareLeftContent"));
  // }) 
   
 </script> 
  
</head>
<?php 
//$sid = !empty($_POST['sid'])? $_POST['sid']:'';
//echo "hi";

//echo $sid;
//echo $selected = !empty($_POST['search'])? $_POST['search']:'';
 if(isset($_POST["search"])){
   $_SESSION['search'] = $_POST["search"];
   $myCar = $_SESSION['search'] ;
  echo "session" . $myCar;

 } 
//$myCar = $_SESSION['search'] ;
  //echo $myCar;
  //echo $_GET['sid'];
?>
<body onload="javascript:GoToHome()">
  <div id="main">
    <div id="header"  class="noprint">
      <div id="logo" >
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1><a href="index.html">PyroTech<span class="logo_colour">Traders</span></a></h1>
          <h2>Cracker Sellers.</h2>
        </div>
      </div>
      
      <div id="menubar" class="noprint">
        <ul id="menu">
          <li class="selected"><a href="#" onclick="GoToHome()">Home</a></li>
          <li><a href="#" onclick="GoToOrders()" id="order_menu">Orders</a></li>
          <li><a href="#" onclick="GoToOrderedProducts()" >Order Products</a></li>
          <li><a href="#" onclick="GoToProducts()" >Products</a></li>
          <!-- <li><a href="#" onclick="GoToProducts()" >Product Categories</a></li> -->
          <li><a href="#" onclick="GoToCustomers()">Customer Details</a></li>
          <li><a href="#" onclick="GoToRefers()">Referers</a></li>
        </ul>
      </div>
    </div>
     <div id="site_content" >
       <div id="content">
        <!-- insert the page content here -->
         <!-- =============================Home Div================================================ -->
        <div id="Home">
                <h1>Home</h1>
                
                <ul>
                <li>All Orders  : 150</li>
                <li>Received Orders  : 50</li>
                <li>Payment Received Orders  : 50</li>
                <li>Pending Payment Orders :50 </li>
                <li>Dispached Orders :50 </li>
                <li>Pending Dispatch Orders :50</li>
                </ul>
        </div>

        <!-- =============================Order Div================================================ -->
        <div id="Orders">
            <h1 id="OrderHeading">Orders</h1>
            <form action="#" method="post">
            <div class="form_settings">
                <p><span>Select Order Type</span>
                  <select id="search" name="search">
                      <option value="All">All</option>
                      <option value="Payment Received">Payment Received</option>
                      <option value="Payment Pending">Payment Pending</option>
                      <option value="Dispatched">Dispatched</option>
                      <option value="Dispatch Pending">Pending Dispatched</option>
                  </select>  
                  <input class="submit" type="submit" name="name" value="Search" /> 
                  </p>
                  <p style="padding-top: 15px"><span>&nbsp;</span></p>
            </div>
           
            <?php
             $result = mysqli_query($conn,"SELECT * FROM salesdetail where Payment_status='$sid'");
             //echo "SELECT * FROM salesdetail where Payment_status='$id'";
             if (mysqli_num_rows($result) > 0) {

             ?>
            
                <table style="width:100%; border-spacing:0;" class="customers">
                  <tr>
                      <th>S No</th>
                      <th>Customer Name</th>
                      <th>Address</th>
                      <th>Phone</th>
                      <th>Total Amount</th>
                      <th>Payment Status</th>
                      <th>Dispatch Status</th>
                      <th>View Details</th>
                   </tr>
                  <?php
                         
                    $i=0;
                    while($row = mysqli_fetch_array($result)) {
                      $id =$row["Id"];
                        ?>
                        <tr>
                        <td><?php echo $row["Id"]; ?></td>
                        <td><?php echo $row["CustomerName"]; ?></td>
                        <td><?php echo $row["Address"]; ?></td>
                        <td><?php echo $row["Phone"]; ?></td>
                        <td style="text-align: right;"><?php echo $row["FinalTotal"]; ?></td>
                        <td style="text-align: center;" > 
                          <input type="checkbox" name="payment_status" value="<?php echo $id; ?>" <?php if(($row['Payment_status'])=='1') echo "checked='checked'"; ?> data-toggle="checkbox">
                        </td>
                        <td style="text-align: center;">
                           <input type="checkbox" name="delivery_status" value="<?php echo $id; ?>" <?php if(($row['Delivery_status'])=='1') echo "checked='checked'"; ?> data-toggle="checkbox">
                        </td>
                        <td style="text-align: center;"> <a href="#" id="showData" data-id= <?php echo $row['Id'] ?>>View Details </a> </td>
                    </tr>
                    <?php
                        $i++;
                    }
                    ?>
                </table>
               
              <?php
              }
             else{
                  echo "No result found";
             }
              ?>
          
        </div>
          <!-- =============================Order details Div================================================ -->
          <div id="OrderDetails" style="vertical-align:top" class="section-to-print">
            
                  <h1 align="center">PyroTech Traders</h1>
                  <p style="padding-left:90%">
                  <a href="#"  class="noprint" onclick="window.print()">
                  <img src="style/print.png" height=30 width=30  class="noprint">
                  </a>
                  </p> 
                  <div id="table-container"></div>
         </div>
         <!-- =============================Order Products Div================================================ -->
         <div id="OrderedProducts" class="section-to-print">
         <h1 align="center">PyroTech Traders -Order Products</h1>
            
            
                  <a href="#"  onclick="window.print()" class="noprint" style="padding-left:90%" >
                  <img src="style/print.png" height=30 width=30  class="noprint">
                  </a>
            
           
            <!-- <div class="form_settings" class="noprint">
                <p class="noprint" ><span>Select Order Type</span>
                  <select id="id" name="name" class="noprint" >
                      <option value="1">All</option>
                      <option value="2">Payment Received</option>
                      <option value="1">Payment Pending</option>
                      <option value="2">Dispatched</option>
                      <option value="1">Pending Dispatched</option>
                  </select>  
                  <input class="submit" type="submit" name="name" value="Search" /> 
                  </p>
                  <p style="padding-top: 15px"><span>&nbsp;</span></p>
            </div> -->
           
            <?php
            $Product_Query ="SELECT Category,ProductName,sum(Qty),sum(Amount) FROM salesproducts group by ProductName order by Category";
            $result = mysqli_query($conn,$Product_Query);
             if (mysqli_num_rows($result) > 0) {

             ?>
            
                <table style="width:100%; border-spacing:0;margin-top:0" class="customers"  id="OrderProductsTable">
                <thead>  
                <tr>
                  <th>S No</th>
                      <th>Category</th>
                      <th>Product Name</th>
                      <th>Qty</th>
                      <th>Total</th>
                  </tr>
                  </thead>
                  <?php
                         
                    $i=1;
                    while($row = mysqli_fetch_array($result)) {
                        ?>
                    <tbody>
                        <tr>
                        <td style="text-align: center;"><?php echo $i; ?></td>
                        <td><?php echo $row[0]; ?></td>
                        <td><?php echo $row[1]; ?></td>
                        <td style="text-align: center;"> <?php echo $row[2]; ?></td>
                        <td style="text-align: right;"><?php echo $row[3]; ?></td>
                        </tr>
                    </tbody>
                    <?php
                        $i++;
                    }
                    ?>
                   
                      <tr>
                      <td colspan="3" id="total"  style="text-align: right;color: #B60000;"><b>Total :</b?</td>
                      <td style="text-align: right;color: #B60000;"></td>
                      <td style="text-align: right;color: #B60000;"></td>
                  </td>
                  </tr>
                 </table>
               
              <?php
              }
             else{
                  echo "No result found";
             }
              ?>
               <!-- </div> -->
            
        </div>
         <!-- =============================Products Div================================================ -->
        <div id="Products">
                <h1>Product Details</h1>
                
               <?php
            $Product_Query ="SELECT * FROM product  order by Id";
            $result = mysqli_query($conn,$Product_Query);
             if (mysqli_num_rows($result) > 0) {
             
             ?>
           
                <table style="width:100%; border-spacing:0;" class="customers" >
                <thead>  
                <tr>
                  <th>S No</th>
                      <th>Category</th>
                      <th>Product Name</th>
                      <th>Content Box</th>
                      <th>List Price</th>
                      <th>List Name</th>
                  </tr>
                  </thead>
                  <?php
                         
                    $i=1;
                    while($row = mysqli_fetch_array($result)) {
                      $sno =$row[1];
                      if($sno < 1) $sno ="";
                        ?>
                    <tbody>
                        <tr>
                        <td style="text-align: center;"><?php echo $sno; ?></td>
                        <td><?php echo $row[2]; ?></td>
                        <td><?php echo $row[3]; ?></td>
                        <td style="text-align: center;"> <?php echo $row[4]; ?></td>
                        <td style="text-align: right;"><?php echo $row[5]; ?></td>
                        <td style="text-align: right;"><?php echo $row[7]; ?></td>
                        </tr>
                    </tbody>
                    <?php
                        $i++;
                    }
                    ?>
                   
                      
                 </table>
               
              <?php
              }
             else{
                  echo "No result found";
             }
              ?>
        </div>
         <!-- =============================Customers Div================================================ -->
        <div id="Customers">
                <h1>Customer Details</h1>
                
                <?php
            $Product_Query ="SELECT * FROM salesdetail  order by Id";
            $result = mysqli_query($conn,$Product_Query);
             if (mysqli_num_rows($result) > 0) {
             
             ?>
           
                <table style="width:100%; border-spacing:0;" class="customers" >
                <thead>  
                <tr>
                  <th>S No</th>
                      <th>Customer Name</th>
                      <th>Address</th>
                      <th>Email</th>
                      <th>Phone</th>
                     
                  </tr>
                  </thead>
                  <?php
                         
                    $i=1;
                    while($row = mysqli_fetch_array($result)) {
                     
                        ?>
                    <tbody>
                        <tr>
                        <td style="text-align: center;"><?php echo $i; ?></td>
                        <td style="text-align: left;"><?php echo $row[1]; ?></td>
                        <td><?php echo $row[4]; ?></td>
                        <td><?php echo $row[3]; ?></td>
                        <td style="text-align: center;"> <?php echo $row[2]; ?></td>
                      
                        
                        </tr>
                    </tbody>
                    <?php
                        $i++;
                    }
                    ?>
                   
                      
                 </table>
               
              <?php
              }
             else{
                  echo "No result found";
             }
              ?>
        </div>
         <!-- =============================Referer Div================================================ -->
        <div id="Referers">
                <h1>Referers</h1>
                
                <table style="width:100%; border-spacing:0;">
                <tr><th>S No</th><th>Sharathi</th><th>Ref Link</th></tr>
                <tr><td>1</td><td>Arun</td><td>https:pyrotechtraders.shop?id=1</td></tr>
                <tr><td> 2</td><td>Vinod</td><td>https:pyrotechtraders.shop?id=2</td></tr>
                <tr><td> 3</td><td>Rajesh</td><td>https:pyrotechtraders.shop?id=3</td></tr>
                <tr><td> 4</td><td>Sharathi</td><td>https:pyrotechtraders.shop?id=4</td></tr>
                </table>
        </div>
      </div>
    </div>
    <div id="content_footer"></div>
    <div id="footer" class="noprint">
     <a href="https://pyrotechtraders.shop" target=_blank> PyroTech Traders - Shop</a>
    </div>
  </div>
</body>
</html>
