<?php session_start();
      require_once 'include/connect.php';
?>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ประวัติการขาย</title>

    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="js/plugins/jquery-ui/jquery-ui.css" rel="stylesheet">
    <!-- Page-Level Plugin CSS - Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <link href="css/plugins/timeline/timeline.css" rel="stylesheet">
    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css?var=5" rel="stylesheet">

    <!--<link rel="stylesheet" type="text/css" href="js/plugins/datepicker/jquery-ui.css">-->
    <link rel="stylesheet" type="text/css" href="js/plugins/jquery-ui/jquery-ui.min.css">
    
    <script src="js/plugins/wysihtml5/lib/js/jquery-1.11.1.min.js"></script>
        <!--<script src="js/jquery-1.10.2.js"></script>-->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <!--<script type="text/javascript" src="js/plugins/datepicker/jquery-ui.js"></script>-->
    <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>
<!--    <link rel="stylesheet" type="text/css" href="/js/plugins/wysihtml5/src/bootstrap3-wysihtml5.css" />
    <script src="/js/plugins/wysihtml5/dist/wysihtml5x-toolbar.min.js"></script>

    <script src="/js/plugins/wysihtml5/src/bootstrap3-wysihtml5.js"></script>-->
    
    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>
    <script src="js/base64.js"></script>
    <script>
        $(document).ready(function () {
            $('#tb_pang').dataTable();
            $('#tb_pang2').dataTable({'aaSorting': [[0, 'desc']]});
            
//            $('.textarea').wysihtml5({html: true, stylesheets: ["/js/plugins/wysihtml5/dist/bootstrap3-wysihtml5-editor.min.css"]});
        });
    </script>
</head>

