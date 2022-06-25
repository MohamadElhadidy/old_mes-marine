<?
include "../../config.php";

// Check user login or not
 if(!isset($_SESSION['userid'])){
 header('Location: ../../');
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>          تقرير بتصنيع معدة

</title>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link href="//cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet">
	<link href="../../assets/images/icons/favicon.png" rel="icon">

    <link href="../css/datatable.css" rel="stylesheet">

    <style>
    @import url("//fonts.googleapis.com/css2?family=Changa:wght@600&display=swap");

    html,
    body {
        margin: 0;
        top: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Changa", sans-serif !important;
        font-size: 1.2rem;
        overflow: visible;
        text-align: center !important;
        align-items: center !important;
        justify-content: center !important;
        direction:rtl;
    }

    .bootstrap-select.btn-group .btn .filter-option,
    a {
        text-align: center !important;
        font-size: 1.2rem !important;
    }


@media print {
  #headers{
      visibility: visible !important;
            opacity:1 !important;
}
   table th{
                font-size:1rem;
            }
             table td{
                font-size:1rem;
            }
             table.dataTable  td{
              padding: 0  !important;
              font-size:1rem;
              font-weight: bold;
                     }
                       table.dataTable  th{
              padding: 0  !important;
              font-size:1rem;
              font-weight: bold;
                     }
                     table.dataTable thead th, table.dataTable thead td{
                                       font-weight: bold;

              font-size:1rem;
              padding: 0 !important;
              background:  #000080 !important;
                color: #fff !important;
                border:  1px solid rgb(255, 255, 255) !important;
                  }
               
               
table.dataTable tfoot th, table.dataTable tfoot td {
   font-size:1rem;
              padding: 0 !important;
              background:  #000080 !important;
                color: #fff !important;
                 border:  none ;
} 
table.dataTable tfoot th.yes, table.dataTable tfoot td.yes {
               border:  1px solid rgb(255, 255, 255) !important;

}      
  
}
  
    </style>
</head>

<body>
     
<img src="../../assets/images/headers/equipments/mn-report.png" width="100%">

        <div id="headers"></div>
        <table id="table">
            <thead>
                <tr>
                <th>كود المُعـــــده </th>
                <th>اسم المُعـــــده</th>
                <th>تاريخ بداية التصنيع </th>
                <th>ملاحظات</th>
                <th></th>
                </tr>
            </thead>
        </table>

</body>

</html>

<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>

<script src="https://kit.fontawesome.com/715e93c83e.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script>
$(document).ready(function() {
        $('#table').DataTable({
            'dom': 'lBfrtip',
            'processing': true,
            'serverSide': true,
            'responsive': true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "الكل"]
            ],
            'language': {
                "searchPlaceholder": "ابحث",
                "sSearch": "",
                "sProcessing": "جاري التحديث...",
                "sLengthMenu": "أظهر مُدخلات _MENU_",
                "sZeroRecords": "لم يُعثر على أية سجلات",
                "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مُدخل",
                "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجلّ",
                "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                "sInfoPostFix": "",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "الأول",
                    "sPrevious": "السابق",
                    "sNext": "التالي",
                    "sLast": "الأخير"
                }
            },
            'serverMethod': 'post',
            'ajax': {
                'url': '../../datatables/pre_report.php',
            },

            'columns': [{
                    data: 'code'
                },
                {
                    data: 'name'
                },
                	{
                    data: 'start_date'
                },
                {
                    data: 'notes'
                }, 
			
                {
                    data: 'show'
                },
            ],
            buttons: [

                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"> طباعة',
                    messageTop: '<img src="../../assets/images/headers/equipments/mn-report.png"  style="position:relative;width:100%;" />',
                    autoPrint: true,
                    title:'',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    },
                    customize: function(win) {
                    $(win.document.body).find('table.dataTable  td')
                            .css('text-align', 'center')
                            .css('padding', '0px')
                            .css('font-size', '1rem');
                        $(win.document.body).find('table.dataTable  th')
                            .css('text-align', 'center')    
                            .css('padding', '0px')
                            .css('font-size', '1rem');
                            $(win.document.body).find('table.dataTable')
                            .css('width', '100%');

                    }
                },
            ]
        });

    });

</script>
</html>


