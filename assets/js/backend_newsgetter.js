/*!
 *   Core v0.1
 *   Author: vqt907
!*/
/*
    Custom script for HuiDeFa
----------------------------
*/

$(document).ready(function() {
	if ($("#changepassForm").length > 0) {
		$("#changepassForm").ajaxForm({
			success : function(data) {
				if (data.code == 0) {
					alert("Change password success");
					window.location = "/user/logout/0";
				} else {
					alert(data.description);
				}
			},
			dataType : 'json', // 'xml', 'script', or 'json' (expected server response type)
			clearForm : true,        // clear all form fields after successful submit
		});
	};
});

$("table tbody ").on('click',".deleteRowBtn",function(event) {
	if (confirm("Are you sure to delete this item?")) {
		var row = $(this).closest("tr");
		var table = $(this).closest("table");
		var rowPos = -1;
		if(isDataTable(table[0])){
			rowPos = table.dataTable().fnGetPosition(row[0]);
		}
		$.post(this.href, {"callback": true}, function(data){
			if (data.code == 0) {
				if (rowPos != -1) {
					console.log("herer");
					$(row).fadeOut("slow",function(){
						table.dataTable().fnDeleteRow( rowPos );
					});
				} else{
					row.children('td').animate({ "padding-top": 0, "padding-bottom": 0 }).wrapInner('<div />').children().slideUp(function(){
						row.remove();
					});
				};
			} else{
				alert(data.desc);
			};
		},"json");
	};
	return false;
});

$("#linkgetcontentTable tbody ").on('click', ".getContentBtn" ,function(event) {
	
	var box = $(this).closest(".box");
	var lasttime_col = $(this).closest("tr").children(".col-6");
	box.append("<div class=\"overlay\"></div> <div class=\"loading-img\"></div> " );
	
	var row = $(this).closest("tr");
	var table = $(this).closest("table");
	var rowPos = -1;
	if(isDataTable(table[0])){
		rowPos = table.dataTable().fnGetPosition(row[0]);
	}
	$.post(this.href, function(data){
		alert(data + " articles imported");
		lasttime_col.html("Just done!");
		box.children(".overlay, .loading-img").remove();
	});
	return false;
});

$("#getContentBtn").click(function(event){
	event.preventDefault();
	
	var table = $("#linkgetcontentTable").DataTable();
	// console.log(table.$('input.importcheck:checked').length);
	var data = 0;
	var count = 0;
	var link_count = $("#linkgetcontentTable input.inline-checkbox:checked").length;
	var link_got = 0;
	var box = $(this).closest(".box");
	table.$('input.importcheck:checked').each(function(k,checkbox){
		var getBtn = $(checkbox).closest(".table-row").children(":last-child").children(".getContentBtn")[0];
		
		var lasttime_col = $(getBtn).closest("tr").children(".col-6");
		
		if (box.children(".overlay").length == 0) {
			box.append("<div class=\"overlay\"></div> <div class=\"loading-img\"></div> " );
		};
		
		var row = $(getBtn).closest("tr");
		var table = $(getBtn).closest("table");
		var rowPos = -1;
		if(isDataTable(table[0])){
			rowPos = table.dataTable().fnGetPosition(row[0]);
		}
		$.post(getBtn.href, function(data){
			checkbox.checked = false;
			link_got++;
			lasttime_col.html("Just got "+data+" contents!");
			
			count+= parseInt(data);
			if (link_got == link_count) {
				box.children(".overlay, .loading-img").remove();
				$("#checkall")[0].checked = false;
				alert(count+ " articles imported");
			};
			
		});
	});
	// return false;
});

$("#checkall").change(function(event){
	
	var value = this.checked;
	
	var table = $("table.dataTable").DataTable();
	table.$('input.inline-checkbox').each(function(){
		this.checked = value;
	});
});

$("select#category_select").on("change",function(event) {
	$("select#subcategory_select").load("/admin/resource/subcategoryselect?ctg="+this.value);
});

function imgPreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $("."+input.name).attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$(".img-container img").click(function(){
	$(".fileinput-container input[name="+$(this).attr("class")+"]").trigger("click");
});

$(".fileinput-container > input").change(function(){
    imgPreview(this);
});

$(".dataTable tbody, table.display tbody").on("click", "tr td:not(:last-child):not(.col-noClick)",function(){
	var action = $(this).closest("tr").children("td").children(".nextStep").attr("href");
	if (action) {
		window.location.href = action;
	};
});

// $("td.col-noClick").click(function() {
	// $(this).children("div").children("input").click();
// });
