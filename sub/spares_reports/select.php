<?php
include "../../config.php";

// Check user login or not
 if(!isset($_SESSION['userid'])){
 header('Location: ../../');
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>          تقرير الحركة علي الصنف
</title>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet"
        href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
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



  
    </style>
</head>

<body>
<img src="../../assets/images/headers/spares_store/sapre_move-report.png" width="100%">

        <div id="headers"></div>
        <table id="table">
            <thead>
                <tr>
               <th>كود الصنف</th>
                <th>اسم الصنف</th>
                <th>الرصيد الحالي</th>
                <th>الوِحده</th>
                <th>متوسط السعر</th>
                <th>حد الطلب</th>
                <th>ملاحظات</th>
                <th></th>
                </tr>
            </thead>
        </table>

</body>

</html>

<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/3.3.7/js/dataTables.bootstrap.min.js"></script>
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
                'url': '../../datatables/select_spare.php',
            },

            'columns': [
                {
                    data: 'code'
                },
                {
                    data: 'name'
                },
                {
                    data: 'balance'
                },
                {
                    data: 'unit'
                },
                {
                    data: 'price'
                },
                {
                    data: 'lmit'
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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"> طباعة',
                    messageTop: '<img src="../../assets/images/headers/spares_store/sapre_move-report.png"  style="position:relative;width:100%;" />',
                    autoPrint: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    customize: function(win) {
                        $(win.document.body).addClass('body_content');
                        $(win.document.body).find('table th')
                            .css('border', 'solid 1px black')
                            .css('background', 'rgb(24, 143, 190)')
                            .css('margin', '0px');
                        $(win.document.body)
                            .css('direction', 'rtl !important')
                            .css('width', '100%');
                        $(win.document.body).find('h1')
                            .css('display', 'none');
                        $(win.document.body).find('table tr td')
                            .css('text-align', 'center')
                            .css('font-size', '1.3rem')
                            .css('padding', '5px');
                        $(win.document.body).find('table th')
                            .css('text-align', 'center')
                            .css('color', '#fff')
                            .css('font-size', '1.3rem !important');
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit')
                            .css('margin-right', 'auto')
                            .css('margin-left', 'auto');

                    }
                },
            ]
        });

    });

</script>