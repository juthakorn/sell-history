<!DOCTYPE html>
<html>
    <?php require_once 'header.php' ?>
    <body>
        <div id="wrapper">
            <?php require_once 'menu.php' ?>
            <div id="res"></div>
            <div id="page-wrapper" >

                <div class="row">
<?php
$sum = $database->select("sell" ,"where status=1 and type_pay = 2 and status_pay = 2","sum(customer_pay) as sum");
?>
                    <div class="col-lg-12">
                        <h1 class="page-header"> รายการยังไม่ชำระเงิน สำหรับลูกค้าเก็บเงินปลายทาง <?=$sum['sum']?></h1>
                        <?php require_once 'message.php' ?>

                    </div>
                    <!-- /.col-lg-12 -->

                </div>
                <div class="row">

                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                ข้อมูลวันที่ขาย
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-result-scroll">
                                    <table class="table table-striped table-bordered table-hover" id="tb_pang2" >
                                        <thead>
                                            <tr class='alert alert-success'>
                                                <th style="text-align:center;width: 100px">วันที่ขาย</th>
                                                <th style="text-align:center;width: 200px">ชื่อ-นามสกุล</th>
                                                <th style="text-align:center;width: 450px">ที่อยู่</th>
                                                <th style="text-align:center;width: 100px">ร้านส่ง</th>
                                                <th style="text-align:center;width: 135px">เงินที่ต้องชำระ</th>
                                                <th style="text-align:center;width: 135px">อนุมัติการชำระเงิน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            
                                            
                                            $results = $database->selects("sell a inner join sell_date b on a.sell_date_id = b.sell_date_id"                                                    
                                                    ,"where a.status=1 and a.type_pay = 2 and a.status_pay = 2 order by sell_date_id,sell_id","a.*,b.sell_date");                                            
                                            foreach ($results as $key => $result) {
                                                
                                                    $txttombon = "ตำบล";
                                                    $txtumpher = "อำเภอ";
                                                    if(preg_match("/กทม|กรุงเทพ/i", $result['customer_province'])){
                                                        $txttombon = "แขวง";
                                                        $txtumpher = "เขต";
                                                    }
                                                        
                                                    
                                                ?>
                                                <tr class="gradeX" style="cursor:pointer;" >
                                                    <td style="text-align:center"><?= $result['sell_date']; ?></td>
                                                    <td><?= $result['customer_name']; ?><br><?= $result['refer']." : ".$result['name_refer']; ?></td>
                                                    <td><?= $result['customer_address']." "?>
                                                        <?= !empty($result['customer_tumbon']) ? $txttombon.$result['customer_tumbon']." " : ""; ?>
                                                        <?= !empty($result['customer_umpher']) ? $txtumpher.$result['customer_umpher']." " : ""; ?>
                                                        <?= !empty($result['customer_province']) ? "จังหวัด".$result['customer_province']." ".$result['customer_postal']." " : ""; ?>
                                                        <?= !empty($result['customer_tel']) ? 'เบอร์โทร '.$result['customer_tel'] : ""; ?>
                                                    </td>
                                                    <td style="text-align:center"><?= $result['partner']; ?></td>
                                                    <td style="text-align:center"><?= $result['customer_pay']; ?></td>
                                                    <td style="text-align:center"><a href="javascript:void(0)"  onclick="pay('<?= $result['sell_id']; ?>','<?= $result['customer_name']; ?>')" class="btn glyphicon glyphicon-ok btn-success"><i></i></a></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->

                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>   
                </div>

            </div>
            <!-- /#page-wrapper -->

        </div>
        <script type="text/javascript">
            function pay(id,name){
                if(confirm('ยืนยันการชำระเงินของ คุณ' + name +' ใช่หรือไม่ ?')==true){
                    $.post('action.php?go=payment',{'sell_id':id},function(data){
                            $("#res").html(data);
                    });
                    }else{
                            return false;
                    }	
            }
           
        </script>
        <?php require_once 'footer.php' ?>
    </body>
</html>

