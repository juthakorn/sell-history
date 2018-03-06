
<?php session_start();
      require_once 'include/connect.php';
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Kanit:300&subset=thai,latin' rel='stylesheet' type='text/css'>
    <!-- Page-Level Plugin CSS - Blank -->

    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <style>
        @media print {
            body{margin: 0mm 0mm 0mm 0mm;}
            .page-break {page-break-after: always;}
            @page { margin: 0.2cm; }

        }

        page[size="A4"] {  
          width: 21cm;
        }
        body{background: rgb(204,204,204);font-size: 16px;font-family: 'Kanit', sans-serif;padding: 0;}
        page{
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
        }
        .panel{border: 0; box-shadow: none;border-radius:0;margin-bottom: 0px;border-right: 1px solid #000;border-bottom: 1px solid #000}
        .one .panel{border-left: 1px solid #000;}
        .top .panel{border-top: 1px solid #000}
        .container{padding: 5px;width: 100%;}
        .col-50{padding: 0;width: 50%; vertical-align: top;float: left;}
        .recipient{font-weight: 600;padding-bottom: 10px;}
        .panel-body{padding: 28px 10px 20px 35px;}        
        .cod{font-weight: 600; padding-top: 18px;font-size: 18px;text-align: center;}
        
        .order{ line-height: 8px;font-size: 11px;border-top:1px solid #000;padding: 6px 35px;}
        .order p:last-child{margin-bottom: 0}
        div a{display: none;}
    </style>
</head>
<?php
    
    if(isset($_GET['sell_id'])){
        $datas = $database->selects("sell a inner join sell_date b on a.sell_date_id = b.sell_date_id and a.status=1",
                    "where a.sell_id in (". str_replace("-", ",", $_GET['sell_id']).") order by a.sell_id DESC"); 
    }else{
        $datas = $database->selects("sell a inner join sell_date b on a.sell_date_id = b.sell_date_id and a.status=1 
                        inner join sell_detail d ON a.sell_id = d.sell_id",
                    "where b.sell_date ='".$_GET['date']."' group by a.sell_id order by a.sell_id DESC"); 
    }
    
                                        
    ?>
<body>
    <page size="A4">
        <div class="container" >   
                
            <?php           
            foreach ($datas as $key => $value) {
                
                $txttombon = "ตำบล";
                $txtumpher = "อำเภอ";
                $txtprovince = "จังหวัด";
                if(preg_match("/กทม|กรุงเทพ/i", $value['customer_province'])){
                    $txttombon = "แขวง";
                    $txtumpher = "เขต";
                    $txtprovince = "";
                }
                $sell_details = $database->selects("sell_detail", "where sell_id ='".$value['sell_id']."'");
                        
                if(($key) % 8 == 0 && ($key != 0)){ 
                    echo "<div class=\"page-break\"></div>";
                }  

                
             ?>


                <div class="col-50 <?=$key%2 == 0 ? "one" : "two"?> <?=$key == 0 || $key == 1 ? "top" : ""?>"> 
                    <div class="panel panel-default">                       
                        <div class="panel-body">   
                            <div class="recipient">ผู้รับ</div>
                            คุณ<?=$value['customer_name']."<br />"?>
                            <?=$value['customer_address']."<br />"?>                        
                            <?= !empty($value['customer_tumbon']) ? $txttombon.$value['customer_tumbon']." " : ""; ?>
                            <?= !empty($value['customer_umpher']) ? $txtumpher.$value['customer_umpher']."<br />" : ""; ?>                            
                            <?=$txtprovince.$value['customer_province']." ".$value['customer_postal']."<br />"?>
                            <?= !empty($value['customer_tel']) ? 'เบอร์โทร '.$value['customer_tel']."<br />" : ""; ?>

                            <?php if($value['type_pay'] == 2){  ?>
                                <div class="cod"> ยอดเงิน COD <?=number_format($value['customer_pay'])?> บาท</div>
                            <?php } ?>
                            

                        </div>
                        <div class="order">
                            <?php foreach ($sell_details as $key1 => $product) { 
                                echo '<p>'.$product['p_name'].' '.$product['p_qty'].' ตัว</p>';
                            } 
                            if(empty($sell_details)){
                                echo "<div>ไม่มีรายการสินค้าที่ส่งเอง</div>";
                            }
                            ?>

                        </div>
                    </div>
                    <!-- /.panel -->
                </div>
            <?php } ?>
                

                
                



            
        </div>
    </page>    

<script src="js/jquery-1.10.2.js"></script>

<script type="text/javascript">
    

    equalheight = function(container){

        var currentTallest = 0,
             currentRowStart = 0,
             rowDivs = new Array(),
             $el,
             topPosition = 0;
        $(container).each(function() {

            $el = $(this);
            $($el).height('auto')
            topPostion = $el.position().top;

            if (currentRowStart != topPostion) {
             for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
               rowDivs[currentDiv].height(currentTallest);
            }
             rowDivs.length = 0; // empty the array
             currentRowStart = topPostion;
             currentTallest = $el.height();
             rowDivs.push($el);
            } else {
             rowDivs.push($el);
             currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
            }
           for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
             rowDivs[currentDiv].height(currentTallest);
           }
        });
    }
    
    $(window).load(function() {
      equalheight('.panel-default');
      <?php if(isset($_GET['p'])){ echo 'window.print();'; }?>
    });
</script>
</body>

</html>
