/* ============================================================
Project Name    : Pyrotech Traders
Created on      : May 2020 
Updated By      : RK
=============================================================== */

/* function CalculateTotal() {
  var content_table = document.getElementById("content");
  var qty_total = 0;
  var str ="row length";
  var amount_total = 0;
  var num_rows = content_table.rows.length;
  
  //for (var i = 1; i < num_rows - 16; i++) {RK
  for (var i = 1; i < num_rows -3; i++) {
    if(content_table.rows[i].cells.length!= 7)
      continue;
      var qty_cell = document.getElementById("content").rows[i].cells[5].children[0].value;
      console.log(qty_cell);
      console.log(str);
      amount_cell = content_table.rows[i].cells[6].innerHTML;
      console.log(amount_cell);
      if (qty_cell != "" && amount_cell != "") {
        qty_total += parseInt(qty_cell);
        console.log(qty_total);
        amount_total += parseFloat(amount_cell);
      }
  }
  console.log(qty_total);

  content_table.rows[num_rows-3].cells[1].innerHTML = qty_total;
  content_table.rows[num_rows-3].cells[2].innerHTML = amount_total.toFixed(2);

  //var discount = 20 / 100.0; RK
  var discount = 50 / 100.0;
  var discount_amount = discount * amount_total;
  var discount_total = amount_total - discount_amount;
  content_table.rows[num_rows-2].cells[1].innerHTML = discount_amount.toFixed(2);
  content_table.rows[num_rows-1].cells[1].innerHTML = discount_total.toFixed(2) ;
  //===========RK====================
  document.getElementById("total").innerHTML ="Total :" + discount_amount.toFixed(2);
}
 */
function CalculateTotal() {
  var content_table = document.getElementById("content");
  var qty_total = 0;
  
  var amount_total = 0;
  var num_rows = content_table.rows.length;
  var num_rows_discount = num_rows-20;
 
  
  for (var i = 1; i < num_rows -20; i++) {
    if(content_table.rows[i].cells.length!= 7)
      continue;
      var qty_cell = document.getElementById("content").rows[i].cells[5].children[0].value;
      amount_cell = content_table.rows[i].cells[6].innerHTML;
      if (qty_cell != "" && amount_cell != "") {
        qty_total += parseInt(qty_cell);
        amount_total += parseFloat(amount_cell);
      }
  }
  

  content_table.rows[num_rows-4].cells[1].innerHTML = qty_total;
  content_table.rows[num_rows-4].cells[2].innerHTML = amount_total.toFixed(2);
  var discount = 50 / 100.0;
  var discount_amount = discount * amount_total;
  var discount_total = amount_total - discount_amount;
  content_table.rows[num_rows-3].cells[1].innerHTML = discount_amount.toFixed(2);
  content_table.rows[num_rows-1].cells[2].innerHTML = discount_total.toFixed(2) ;


  var no_discount_qty_total =0;
  var no_discount_amount_total =0;
  for (var i = 248; i < num_rows -4; i++) {
    if(content_table.rows[i].cells.length!= 7)
      continue;
      var qty_cell = document.getElementById("content").rows[i].cells[5].children[0].value;
      amount_cell = content_table.rows[i].cells[6].innerHTML;
      
      if (qty_cell != "" && amount_cell != "") {
        no_discount_qty_total += parseInt(qty_cell);
        no_discount_amount_total += parseFloat(amount_cell);
      }
  }
  content_table.rows[num_rows-2].cells[1].innerHTML = no_discount_qty_total;
  content_table.rows[num_rows-2].cells[2].innerHTML = no_discount_amount_total.toFixed(2);

  var no_discount_qty         = qty_total + no_discount_qty_total;
  var no_discount_final_total = discount_total + no_discount_amount_total;

  content_table.rows[num_rows-1].cells[1].innerHTML = no_discount_qty;
  content_table.rows[num_rows-1].cells[2].innerHTML = no_discount_final_total.toFixed(2);

  //===========RK====================
  document.getElementById("total").innerHTML ="Total :" + no_discount_final_total.toFixed(2);
}

function QuantityChange(current_node) {
  
  var childnodes = current_node.parentNode.parentNode.childNodes;
  /* TODO: Remove font tag on per rate cell */
  //var per_rate = parseFloat(childnodes[childnodes.length-8].childNodes[0].innerHTML);
  var per_rate = parseFloat(childnodes[childnodes.length-6].innerHTML);
  var qty_cell = current_node.value;
  var amount_cell = childnodes[childnodes.length-2];
  if (qty_cell != "") {
    var qty = parseFloat(qty_cell);
    var amount = qty * per_rate;
    amount_cell.innerHTML = amount.toFixed(2);
  } else {
    amount_cell.innerHTML = "";
  }
  CalculateTotal();
}

function ToggleDivDisplay(disapper_div, appear_div) {
  document.getElementById(disapper_div).style.display = "None";
  document.getElementById(appear_div).style.display = "block";
}

function CopyRowFromContentToCart(content_row, cart_row) {
  for (var i = 0; i < content_row.cells.length; i++) {
    cart_row_cell = cart_row.insertCell(i);
    if (i == 1)  { 
      cart_row_cell.classList.add("category");
    }else if(i==2){
      cart_row_cell.classList.add("description");
    }else{
      cart_row_cell.classList.add("numbers");
    }
    //if (i == 4) {
    if (i == 5) {
      cart_row_cell.innerHTML = content_row.cells[i].childNodes[0].value;
    } else {
      cart_row_cell.innerHTML = content_row.cells[i].innerHTML;
    }
  }
} 


function ClearCart() {
  var cart_table = document.getElementById("cart-table");
  var num_cart_rows = cart_table.rows.length;
  for (var i = 1; i < num_cart_rows - 4; i++) {
    cart_table.deleteRow(1);
  }
}

function AddToCart() {

  var content_table = document.getElementById("content");
  var num_rows = content_table.rows.length;
  var val =content_table.rows[num_rows-4].cells[2].innerHTML;
  //console.log(val);
  //window.alert(val);
  //if(val=="") { window.alert("Please choose items"); return false };


  ToggleDivDisplay("product-list", "cart");

  ClearCart();

  var content_table = document.getElementById("content");
  var cart_table = document.getElementById("cart-table");
  var num_content_rows = content_table.rows.length;
  for (var i = 1; i < num_content_rows - 4; i++) {
    
    if(content_table.rows[i].cells.length != 7)
    continue;
    //var amount_cell = content_table.rows[i].cells[5].innerHTML;
     var amount_cell = content_table.rows[i].cells[6].innerHTML;
    if (amount_cell != "") {
      var content_row = content_table.rows[i];
      var cart_row = cart_table.insertRow(cart_table.rows.length-4);
      CopyRowFromContentToCart(content_row, cart_row);
    } 
    
  }

  var num_cart_rows = cart_table.rows.length;

 /*  cart_table.rows[num_cart_rows-3].cells[1].innerHTML =
                  content_table.rows[num_content_rows-3].cells[1].innerHTML;
  cart_table.rows[num_cart_rows-3].cells[2].innerHTML =
                  content_table.rows[num_content_rows-3].cells[2].innerHTML;

  cart_table.rows[num_cart_rows-2].cells[1].innerHTML =
                  content_table.rows[num_content_rows-2].cells[1].innerHTML;
  cart_table.rows[num_cart_rows-1].cells[1].innerHTML =
                  content_table.rows[num_content_rows-1].cells[1].innerHTML; */


  cart_table.rows[num_cart_rows-4].cells[1].innerHTML =
                  content_table.rows[num_content_rows-4].cells[1].innerHTML;
  cart_table.rows[num_cart_rows-4].cells[2].innerHTML =
                  content_table.rows[num_content_rows-4].cells[2].innerHTML;

 cart_table.rows[num_cart_rows-3].cells[1].innerHTML =
                  content_table.rows[num_content_rows-3].cells[1].innerHTML;
  cart_table.rows[num_cart_rows-2].cells[1].innerHTML =
                  content_table.rows[num_content_rows-2].cells[1].innerHTML;
  cart_table.rows[num_cart_rows-2].cells[2].innerHTML =
                  content_table.rows[num_content_rows-2].cells[2].innerHTML;                   
  cart_table.rows[num_cart_rows-1].cells[1].innerHTML =
                  content_table.rows[num_content_rows-1].cells[1].innerHTML; 
  cart_table.rows[num_cart_rows-1].cells[2].innerHTML =
                  content_table.rows[num_content_rows-1].cells[2].innerHTML;              
}
//========================RK==========================

function tableToJson(table) { 
  var data = [];
  var len =table.rows.length-4;
  console.log(len);
  for (var i=1; i<table.rows.length; i++) { 
       if(i<len){
      var tableRow = table.rows[i]; 
      var rowData = []; 
      for (var j=0; j<tableRow.cells.length; j++) { 
          rowData.push(tableRow.cells[j].innerHTML);; 
      } 
      data.push(rowData); 
   }
  } 
  return data; 
}
//====================================================

function Checkout() {
  ToggleDivDisplay("cart", "contact");
  var cart_table = document.getElementById("cart-table")
  var cart_table_json = JSON.stringify(cart_table);
  console.log(cart_table_json);
}

function PlaceOrder() {
  
  var customer_name = document.getElementById("customer-name").value;
  var customer_phone = document.getElementById("customer-phone").value;
  var customer_email = document.getElementById("customer-email").value;
  var customer_address = document.getElementById("customer-address").value;

  //=============================RK==============================================

  if(customer_name==""){window.alert("Please enter the Name");return false};
  if(customer_phone==""){window.alert("Please enter the Phone number");return false};
  if(customer_email==""){window.alert("Please enter the Email Id");return false};
  if(customer_address==""){window.alert("Please enter the Address");return false};
 //=================================================================================

  ToggleDivDisplay("contact", "result");
  
  var cart_table = $("#cart-table");
  var cart_table_str = $(cart_table[0]).clone().wrap('<div>').parent().html();

  /* =========Cart Table Style for the Mail ======================*/
  var html_head = "<html><head><style> \
                  table, td, th {border: 1px solid #000;margin:10px auto;font-size:15px;} \
                  table {border-collapse: collapse;} th, td {text-align: left;padding: 8px;} \
                  tr:nth-child(even){background-color: #ddd} \
                  th {background-color: #C4001A; color: #fff;text-align:center;} \
                  table.center{ margin-left: auto; margin-right: auto;} </style> </head><body>";
  var html_tail = "</body></html>";
  cart_table_str = html_head + cart_table_str + html_tail;
  
 

 // =============Raghu code===========================================
 /*  $.post("order.php", { 
    name: customer_name,
    phone: customer_phone,
    email: customer_email,
    address: customer_address,
    cart_table: cart_table_str,
    }, function(data, status){
      $("#order-status").html(data);
  }); */
  //===========RK=====================================================

  var cart_table = document.getElementById("cart-table");
  var num_cart_rows = cart_table.rows.length;
  

  /* var  total       = cart_table.rows[num_cart_rows-3].cells[2].innerHTML ;
  var  discount    = cart_table.rows[num_cart_rows-2].cells[1].innerHTML;
  var  final_total =cart_table.rows[num_cart_rows-1].cells[1].innerHTML; */
 
  var  discount_item_total       = parseFloat(cart_table.rows[num_cart_rows-4].cells[2].innerHTML) ;
  var no_discount_item_total     = parseFloat(cart_table.rows[num_cart_rows-2].cells[2].innerHTML );

  var total       = discount_item_total + no_discount_item_total;
  var discount    = cart_table.rows[num_cart_rows-3].cells[1].innerHTML;
  var final_total = cart_table.rows[num_cart_rows-1].cells[2].innerHTML;

  /* window.alert("total"+total);
  window.alert("discount"+discount);
  window.alert("final_total"+ final_total); */


  var cart_table = document.getElementById("cart-table");
  var cart_table_data = tableToJson(cart_table);
  var cart_table_json =JSON.stringify(cart_table_data);
  console.log(cart_table_data);
  console.log(JSON.stringify(cart_table_data)); 
  
  
    $.post("order.php", { 
          name: customer_name,
          phone: customer_phone,
          email: customer_email,
          address: customer_address,
          sales_total:total,
          sales_discount:discount,
          sales_final_total:final_total,
          cart_table: cart_table_str,
          data:cart_table_data,
          }, function(data, status){
            $("#order-status").html(data);
           
    });

   
  //=================================================================
}

function GoToHome() {
  document.getElementById("product-list").style.display = "block";
  document.getElementById("cart").style.display = "None";
  document.getElementById("contact").style.display = "None";
  document.getElementById("result").style.display = "None";
}

function GoToCart() {
  document.getElementById("product-list").style.display = "None";
  document.getElementById("cart").style.display = "block";
  document.getElementById("contact").style.display = "None";
  document.getElementById("result").style.display = "None";
 }