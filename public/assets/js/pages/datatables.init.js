$(document).ready(function(){
$("#datatable").DataTable({responsive:!1,scrollX:!0});
var a=$("#datatable-buttons").DataTable({lengthChange:!1,responsive:!1,scrollX:!0,buttons:["copy","excel","pdf"]});
$("#key-table").DataTable({keys:!0,responsive:!1,scrollX:!0}),$("#responsive-datatable").DataTable({responsive:!1,scrollX:!0}),$("#selection-datatable").DataTable({select:{style:"multi"},responsive:!1,scrollX:!0}),a.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)")});