$(document).ready(function() {
$("#employee_id").change(function(event) {
    var name = $("#employee_id option:selected").text();
    name = name.replace(/[^a-zA-Z ]/g, '');
    console.log(name);
 $("#emp_name").val(name);
});
// $(".select2").select2();
});


// Alternate

 name = name.replace(/\d+|([-])|/g, '');


 /**
  * The above line replaces only - symbol \d is to remove digit
  */
