
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
			rowData.push(invoices[index]['email']);
			rowData.push(invoices[index]['phone_number']);
			//Inserting the buttons ???
			rowData.push('<button type="button" class="btn btn-primary btn-xs dt-edit" style="margin-right:16px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>');
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