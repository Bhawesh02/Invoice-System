








function cust_change(event) {
	//console.log(event.target.value)
  var cu_email = document.getElementById('cu_email');
  var cu_id = document.getElementById('cu_id');

  cu_email.setAttribute('placeholder',customers[event.target.value]["email"]);
  cu_id.setAttribute('value',customers[event.target.value]["customer_id"]);
  };

  function pro_change(event,no) {
	//console.log(event.target.value)
  var pro_price = document.getElementById('pro_price_'+no);
  var pro_id = document.getElementById('pro_id_'+no);

  pro_price.setAttribute('placeholder',products[event.target.value]["price"]);
  pro_id.setAttribute('value',products[event.target.value]["product_id"]);
  };






var noOfclumb = 4;
$(document).ready(function() {
	//Only needed for the filename of export files.
	//Normally set in the title tag of your page.
	document.title='invoices';
	// DataTable initialisation
	$('#invoices').DataTable(
		{
			"dom": '<"dt-buttons"Bf><"clear">lirtp',
			"paging": false,
			"autoWidth": true,
			"columnDefs": [
				{ "orderable": false, "targets": noOfclumb }
			],
			"buttons": [
				'colvis',
				'copyHtml5',
        'csvHtml5',
				'excelHtml5',
        'pdfHtml5',
				'print'
			]
		}
	);

    $.each(invoices, function(index) {
        
            //console.log(invoices[index]);
        //Create some data and insert it
			var rowData = [];
			var table = $('#invoices').DataTable();
			//Store next row number in array
			
			rowData.push(invoices[index]['invoice_id']);
			//Name
			rowData.push(invoices[index]['name']);
			//Amount column
			rowData.push(invoices[index]['total_pro']);
			rowData.push(invoices[index]['total_amt']);
			//Inserting the buttons ???
			rowData.push('<button type="button" class="btn btn-primary btn-xs dt-edit" style="margin-right:16px;">View</button>');
			//Looping over columns is possible
			//var colCount = table.columns()[0].length;
			//for(var i=0; i < colCount; i++){			}
			
			//INSERT THE ROW
			table.row.add(rowData).draw( false );
			
			
      });
//Add row
$('#add_row_btn').on('click',function(){
    $('#popup').css("display","block");
    $('#add_row_popup').css("display","block");
});




	//Edit row buttons
	$('.dt-edit').each(function () {
		$(this).on('click', function(evt){
			$this = $(this);
            $('#popup').css("display","block");
            $('#edit_row_popup').css("display","block");
			var dtRow = $this.parents('tr');
            console.log(dtRow[0].cells[1].innerHTML);
			var cust_edit_id = dtRow[0].cells[0].innerHTML;
			var cust_edit_name = dtRow[0].cells[1].innerHTML;
			var cust_edit_email = dtRow[0].cells[2].innerHTML;
			var cust_edit_pno = dtRow[0].cells[3].innerHTML;
            $('#edit_name').attr('placeholder',cust_edit_name);
            $('#edit_name').attr('value',cust_edit_name);
			$('#edit_email').attr('placeholder',cust_edit_email);
            $('#edit_email').attr('value',cust_edit_email);
            $('#edit_id').attr('value',cust_edit_id);
            $('#edit_id_h').attr('value',cust_edit_id);
            $('#edit_phone_number').attr('placeholder',cust_edit_pno);
            $('#edit_phone_number').attr('value',cust_edit_pno);
		});
	});
	//Delete buttons
	$('.dt-delete').each(function () {
		$(this).on('click', function(evt){
			$this = $(this);
			var dtRow = $this.parents('tr');
			if(confirm("Are you sure to delete this row?")){
				var table = $('#invoices').DataTable();
				table.row(dtRow[0].rowIndex-1).remove().draw( false );
			}
		});
	});
	$('#myModal').on('hidden.bs.modal', function (evt) {
		$('.modal .modal-body').empty();
	});
});
//popup close

$('#popup_close').on('click',function(){
    $('#popup').css("display","none");
    $('#add_row_popup').css("display","none");

});



//focused
$(function() {
   
    $(".form-control").on('focus', function(){

        $(this).parents(".form-group").addClass('focused');

    });

    $(".form-control").on('blur', function(){

        $(this).parents(".form-group").removeClass('focused');

    });

});

console.log(customers);

$.each(customers, function(index) {
	console.log(customers[index]);
	$('#add_customer_name').append("<option value="+index+">"+customers[index]["name"]+"</option>");
  });
  

var num_of_pro = document.getElementById('num_of_pro');
var NoOfproductUpdated = 0;
const productList = document.getElementById("products_to_add");
function productInsert(i) { 

    if (i > 0 ){
        document.getElementById("add-more").remove();
    }
    if (i > 1 ){
        document.getElementById("add-less").remove();
    }


    var div = document.createElement('div');
    div.innerHTML=`
	<div class="form-group">
                <label for="Product_name" class="form-label">Product Name</label>
                <select name="Product_name" class="form-control" onchange="pro_change(event,`+(i+1)+`)" id="add_Product_name`+"_"+(i+1)+`">
                    <option disabled value="" selected hidden>Product Name</option>
                </select>
                <input type = "number" name ="product_id`+"_"+(i+1)+`" id="pro_id`+"_"+(i+1)+`" hidden>
            </div>
            <div class="form-group">
                <label for="Product_price" class="form-label">Product Price</label>
                <input class="form-control " id="pro_price`+"_"+(i+1)+`" placeholder="Product Price" disabled>
            </div>
            <div class="form-group">
                <label for="Quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" name="pro_qty`+"_"+(i+1)+`" placeholder="Enter Quantity" required>
            </div>
	`;
	productList.appendChild(div);
	
	$.each(products, function(index) {
		//console.log(products[index]);
		$('#add_Product_name_'+(i+1)).append("<option value="+index+">"+products[index]["name"]+"</option>");
	  });

	  num_of_pro.setAttribute("value",Number(num_of_pro.getAttribute("value"))+1);
    
	console.log(num_of_pro.getAttribute("value"));


    var div = document.createElement('div');
    div.classList.add("form-group");
    productList.appendChild(div);
    var p = document.createElement('p');
    p.setAttribute('class','form-control');
    div.appendChild(p);
    var span1 = document.createElement('span');
    span1.setAttribute('class','add_more');
    span1.setAttribute('id','add-more');
    p.appendChild(span1);
    var span = document.createElement('span');
    span.innerHTML="(+)";
    span1.appendChild(span);
    var span = document.createElement('span');
    span.classList.add('underline');
    span.innerHTML = 'Add More';
    span1.appendChild(span);
    if (i>0)
    {
        var span1 = document.createElement('span');
    span1.setAttribute('class','add_less');
    span1.setAttribute('id','add-less');
    p.appendChild(span1);
    var span = document.createElement('span');
    span.innerHTML="(-)";
    span1.appendChild(span);
    var span = document.createElement('span');
    span.classList.add('underline');
    span.innerHTML = 'Add Less';
    span1.appendChild(span);
    }

    NoOfproductUpdated += 1;
    AddMores();
    if (i > 0) {
        Addlesss();
    }
}



function productRemove(i) {
    document.getElementById('o-'+i).remove();
    document.getElementById("productHarvestDate-"+i).remove();
    document.getElementById("productHarvestTime-"+i).remove();
    NoOfproductUpdated -= 1;
    console.log(NoOfproductUpdated);
    if (NoOfproductUpdated == 1){
        
        document.getElementById("add-less").remove();
    }
}

productInsert(0);
function AddMores() {
    let AddMore = document.getElementById("add-more");
    AddMore.addEventListener("click",()=>{
                    productInsert(NoOfproductUpdated);
                    });
}
function Addlesss() {
    let AddMore = document.getElementById("add-less");
    AddMore.addEventListener("click",()=>{
                    productRemove(NoOfproductUpdated);
                    });
}




