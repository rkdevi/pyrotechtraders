
function GoToHome() {
    document.getElementById("Home").style.display = "block";
    document.getElementById("Orders").style.display = "None";
    document.getElementById("Products").style.display = "None";
    document.getElementById("Customers").style.display = "None";
    document.getElementById("Referers").style.display = "None";
    document.getElementById("OrderedProducts").style.display = "None";
    document.getElementById("OrderDetails").style.display = "None";
  }
  
  function GoToOrders() {
    document.getElementById("Orders").style.display = "block";
    document.getElementById("Home").style.display = "None";
    document.getElementById("Products").style.display = "None";
    document.getElementById("Customers").style.display = "None";
    document.getElementById("Referers").style.display = "None";
    document.getElementById("OrderedProducts").style.display = "None";
    document.getElementById("OrderDetails").style.display = "None";
    
  }
  function GoToOrderedProducts() {
    document.getElementById("Orders").style.display = "None";
    document.getElementById("Home").style.display = "None";
    document.getElementById("OrderedProducts").style.display = "block";
    document.getElementById("Products").style.display = "None";
    document.getElementById("Customers").style.display = "None";
    document.getElementById("Referers").style.display = "None";
    document.getElementById("OrderDetails").style.display = "None";
    CalculateTotal()
  }
  function GoToProducts() {
    document.getElementById("Orders").style.display = "None";
    document.getElementById("Home").style.display = "None";
    document.getElementById("Products").style.display = "block";
    document.getElementById("Customers").style.display = "None";
    document.getElementById("Referers").style.display = "None";
    document.getElementById("OrderedProducts").style.display = "None";
    document.getElementById("OrderDetails").style.display = "None";
  }
  function GoToCustomers() {
    document.getElementById("Orders").style.display = "None";
    document.getElementById("Home").style.display = "None";
    document.getElementById("Products").style.display = "None";
    document.getElementById("Customers").style.display = "block";
    document.getElementById("Referers").style.display = "None";
    document.getElementById("OrderedProducts").style.display = "None";
    document.getElementById("OrderDetails").style.display = "None";
  }
  function GoToRefers() {
    document.getElementById("Orders").style.display = "None";
    document.getElementById("Home").style.display = "None";
    document.getElementById("Products").style.display = "None";
    document.getElementById("Customers").style.display = "None";
    document.getElementById("Referers").style.display = "block";
    document.getElementById("OrderedProducts").style.display = "None";
    document.getElementById("OrderDetails").style.display = "None";
  }

  $(document).on('click','#showData',function(e){
    var Id = $(this).data("id")
    document.getElementById("Orders").style.display = "None";
    document.getElementById("OrderDetails").style.display = "block";
   
    $.post("adminorders.php", { 
      id:Id,
     }, function(data, status){
        $("#table-container").html(data); 
       
     });
  }); 
  //===========Ordered products total qty,amount=================================
  function CalculateTotal() {
    var content_table = document.getElementById("OrderProductsTable");
    var qty_total = 0;
    var amount_total = 0;
    var num_rows = content_table.rows.length;
    for (var i = 1; i < num_rows - 1; i++) {
      
      qty_cell = content_table.rows[i].cells[3].innerHTML;
      amount_cell = content_table.rows[i].cells[4].innerHTML;
      if (qty_cell != "" && amount_cell != "") {
        qty_total += parseInt(qty_cell);
        amount_total += parseFloat(amount_cell);
      }
    }
     
    content_table.rows[num_rows-1].cells[1].innerHTML = qty_total;
    content_table.rows[num_rows-1].cells[2].innerHTML = amount_total.toFixed(2);
     
  }
  //===================Order update=================================================
 /*  function save_paymentstatus(checkbox_id, record_id) {
    window.alert("ashdh");
    $.post("adminorders.php", { 
         ptype: checkbox_id,
         rid: record_id,
         }, function(data, status){
           window.alert("Payment status updated successfully");
    });
}
function save_deliverystatus(checkbox_id, record_id) {
    $.post("adminorders.php", { 
         dtype: checkbox_id,
         did: record_id,
         }, function(data, status){
           window.alert("Delivery status updated successfully");
    });
}
 */
