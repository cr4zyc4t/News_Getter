/*!
 *   Core v0.1
 *   Author: vqt907
 !*/
/*
 Custom script for HuiDeFa
 ----------------------------
 */

isSelectedAll = false;
$(document).ready(function(){
	$('#listContentTable').dataTable( {
    	dom:"<'row'T>" +
    		"<'row'<'col-sm-6'l><'col-sm-6'f>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-6'i><'col-sm-6'p>>",
        columns: [
		            { data: "check", orderable: false },
		            { data: "title" },
		            { data: "source" },
		            { data: "description" },
		            { data: "updated_time" },
		            { data: "sort" },
		            { data: "control",orderable: false },
		        ],
        oTableTools: {
            sRowSelect: "multi",
			sSwfPath: "/assets/plugins/datatable_1.10.1/extensions/TableTools/swf/copy_csv_xls.swf",
			sRowSelector: 'td:first-child',
            aButtons: [
            	{
	                "sExtends":    "select_all",
	                "sButtonClass": "btn btn-default",
               	},
               	{
	                "sExtends":    "select_none",
	                "sButtonClass": "btn btn-default",
               	},
            	{
	                "sExtends":    "select",
	                "sButtonText": "Move",
	                "sButtonClass": "btn btn-warning",
                    "fnClick": function ( nButton, oConfig, oFlash ) {
                        moveSelected();
                    },
               	},
               	{
	                "sExtends":    "select",
	                "sButtonText": "Delete",
	                "sButtonClass": "btn btn-danger",
                    "fnClick": function ( nButton, oConfig, oFlash ) {
                        deleteSelected();
                    }
               	},
               	{
	                "sExtends":    "select",
	                "sButtonText": "Prefix fix",
	                "sButtonClass": "btn btn-info",
                    "fnClick": function ( nButton, oConfig, oFlash ) {
                        prefixSelected();
                    }
               	},
               	{
	                "sExtends":    "select",
	                "sButtonText": "Fix Order",
	                "sButtonClass": "btn btn-primary",
                    "fnClick": function ( nButton, oConfig, oFlash ) {
                        fixOrderSelected();
                    }
               	},
               	// {
	                // "sExtends":    "text",
	                // "sButtonText": "&nbsp;",
	                // "sButtonClass": "btn disabled",
               	// },
               	// {
	                // "sExtends":    "text",
	                // "sButtonText": "Import",
	                // "sButtonClass": "btn btn-primary pull-right standalone",
                    // "fnClick": function ( nButton, oConfig, oFlash ) {
                        // importForm();
                    // }
               	// }
            ]
        }
    } );
});


function importForm() {
	$("#playlist_url").val("");
	// CLEAR FORM
	$("#form_alert").hide();
	$('#myModal').modal({
		keyboard : false,
		backdrop : 'static'
	});
};

var import_count = 0;
var total_count = 0;
var conflict_count = 0;
var error_count = 0;

function sendImportRequest(url, subctg_id) {
	$("#playlist_url").val("");
	// CLEAR FORM
	$("#form_alert").hide();

	var postData = {
		"url" : url,
		"subcategory_id" : subctg_id
	};

	$.post("/youtube/import/playlist2", postData, function(response) {
		if (response.success) {
			import_count += parseInt(response.count);
			total_count = parseInt(response.total);
			conflict_count += parseInt(response.conflict);
			error_count += parseInt(response.error);

			printResult(total_count, import_count, conflict_count, error_count);

			if ('next' in response) {
				sendImportRequest(response.next, subctg_id);
			} else {
				// $(".form-container").hide();
				// $(".progress-container").hide();
				// $(".result-container").show();
				$(".progress-container > .modal-header > .model-title").html("Import Result");

				$(".progress-container > .modal-body > .progress").slideUp();
				$(".progress-container > .modal-footer").slideDown();
			};
		} else {
			$(".form-container").show();
			$(".progress-container").hide();
			$("#form_alert").html(response.info).show();
		};
	}, "json");
}

function importInit(subctg_id) {
	$(".form-container").hide();
	$(".progress-container").show();

	sendImportRequest($("#playlist_url").val(), subctg_id);
};

function printResult(total, success, conflict, error) {
	$(".total_count").html(total);
	$(".success_count").html(success);
	$(".conflict_count").html(conflict);
	$(".error_count").html(error);

	$(".progress-bar.progress-bar-primary").removeClass("progress-bar-primary").addClass("progress-bar-success");
	$(".progress-bar").css("width", Math.round((success + conflict + error) * 100 / total) + "%");
}

$("#checkallpage").change(function(event){
	
	var value = this.checked;
	
	$('input.inline-checkbox').each(function(){
		this.checked = value;
		if(value){
			$(this).closest("tr").addClass('selected');
		}else{
			$(this).closest("tr").removeClass('selected');
		}
	});
});

$('.dataTable tbody').on( 'change', 'input.inline-checkbox', function () {
	if(this.checked){
		$(this).closest("tr").addClass('selected');
	}else{
		$(this).closest("tr").removeClass('selected');
	}
});

function getSelected(){
	// return $('table tbody tr.active input.inline-checkbox').map(function(_, el) {
        // return $(el).val();
    // }).get();
    var selected = [];
    var oTT = TableTools.fnGetInstance( 'listContentTable' );
    $(oTT.fnGetSelected()).children("td").children("input.inline-checkbox").each(function(key,value){
    	selected.push(value.value);
    });
    // console.log(selected);
    return selected;
}

$('#submitOrderBtn').click(function(e){
 	e.preventDefault();
 	var l = Ladda.create(this);
 	l.start();
 	
 	var table = $('#listContentTable').dataTable();
	
	var order_arr = []; 
	table.$(".intable-input").each(function(key, value){
		var row_data = {
			id : value.getAttribute("rel"),
			order : value.value
		};
		order_arr.push(row_data);		
	});
	$.post("/admin/manage/reordercontent",{order_data: JSON.stringify(order_arr)},function(response){
		// console.log(response);
		if(response != ''){
			alert(response);
		}
	}).always(function() { l.stop(); });
 	return false;
});

function moveSelected(){
	var selected = getSelected();
	if(selected.length){
		$("#myModal2 .modal-body").load("/admin/manage/moveform",function(){
			$('#myModal2').modal('show');
			$("select#category_select").on("change",function(event) {
				$("select#subcategory_select").load("/admin/resource/subcategoryselect?ctg="+this.value);
			});
		});
	}else{
		alert("Select some item first!");
	}
}

function fixOrderSelected(){
	var selected = getSelected();
	if(selected.length){
		if (confirm("This feature will extract the first number in title and save as sort field?")) {
			$.post("/admin/manage/fixorder",{'ids': getSelected()}, function(response){
				window.location.reload();
			});
		}
	}else{
		alert("Select some item first!");
	}
}

function deleteSelected(){
	var selected = getSelected();
	if(selected.length){
		if (confirm("Are you sure to delete these items?")) {
			$.post("/admin/manage/deletecontent",{'ids': getSelected()}, function(response){
				if (response.code == 0) {
					// alert(response.count + " items have been deleted");
					// window.location.reload();
					
					var table = $("table.dataTable").DataTable();
					
					// $('input.inline-checkbox:checked').each(function(k,checkbox){
						// var row = $(checkbox).closest("tr");
						// var table = $(checkbox).closest("table");
						// var	rowPos = table.dataTable().fnGetPosition(row[0]);
						$("table tbody tr.active").fadeOut("slow",function(){
							table.rows('.active').remove().draw( false );
						});
					// });
					
				} else{
					alert(response.desc);
				};
			},"json");
		};
	}else{
		alert("Select some item first!");
	}
}

function prefixSelected(){
	var selected = getSelected();
	if(selected.length){
		$("#mainModal").load("/admin/manage/prefixform",{'ids': getSelected()}, function(response){}).modal("show");
	}else{
		alert("Select some item first!");
	}
}

function fixNameItem(){
	var selected = getSelected();
	if(selected.length){
		$.post("/admin/manage/fixname",{'ids': getSelected(), 'prefix': $("#prefix").val(), 'option': $('input[name="prefixOption"]:checked').val()}, function(response){
			if (response.code == 0) {
				$("#mainModal").html('').modal("hide");
				window.location.reload();
			} else{
				alert(response.desc);
			};
		},"json");
	}else{
		alert("Select some item first!");
	}
}

function moveItem(){
	$.post("/admin/manage/movecontent", {"subcategory_id": $("select#subcategory_select").val(), "ids": getSelected()}, function(response){
		$(".modal").modal("hide");
		if (response.code == 0) {
			alert("Move Success");
			// window.location.reload();
			if('redirect' in response){
				window.location = response.redirect;
			}else{
				var table = $(this).closest("table.dataTable").DataTable();
				$("table tbody tr.active").fadeOut("slow",function(){
					table.rows('.active').remove().draw( false );
				});
			}
			
		} else{
			alert(response.desc);
		};
	},'json');
}