$(document).ready(function(){
  $("#selectYearForm").submit(function() {
    try {
      $("#selectYearForm").closest(".box").append("<div class=\"overlay\"></div><div class=\"loading-img\"></div>");

      var year = $("#year_select").val();
      if (!year.length)
      {
        $("#selectYearForm").closest(".box").children(".overlay,.loading-img").remove();
        alert('Missing date!');
      }
      loadInChargeData(year);
    } catch (err) {
      console.log(err);
    }
    return false;
  });
});

function loadInChargeData (year)
{
  $("#incharge").load("/incharge/loadDepartment/"+year+"/1",function(){
    $("#selectYearForm").closest(".box").children(".overlay,.loading-img").remove();
  });
}
