$(document).ready(function(){
  $("#formChooseProductType").submit(function() {
    try {
      $(this).closest(".box").append("<div class=\"overlay\"></div><div class=\"loading-img\"></div>");

      var from = $("#fromDate").val();
      var to = $("#toDate").val();
      if (!from.length || !to.length)
      {
        $(this).closest(".box").children(".overlay,.loading-img").remove();
        alert('Missing date!');
        return false;
      }
      var date1 = new Date(from);
      var date2 = new Date(to);
      if (from > to)
      {
        $(this).closest(".box").children(".overlay,.loading-img").remove();
        alert('Invalid dates!');
        return false;
      }
      var product_type = $('#selectProductType').val();
      if (!product_type.length)
      {
        $(this).closest(".box").children(".overlay,.loading-img").remove();
        alert('Missing product type!');
        return false;
      }
      loadProductTypeData(from, to, product_type);
    } catch (err) {
      console.log(err);
    }
    return false;
  });

});

function loadProductTypeData (from, to, product_type)
{
  $("#product_type").load("/product/loadProductTypeData/"+from+"/"+to+"/"+product_type,function(){
    $("#formChooseProductType").closest(".box").children(".overlay,.loading-img").remove();
  });
}