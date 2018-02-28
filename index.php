<!DOCTYPE html>
<html>
    <?php require_once 'header.php' ?>
    <body>
        <div id="wrapper">
            <?php require_once 'menu.php' ?>
            <div id="res"></div>
            <div id="page-wrapper" >

                <div class="row">

                    <div class="col-lg-12">
                        <h1 class="page-header">ประวัติการขาย</h1>
                        
                        <?php require_once 'message.php' ?>

                    </div>
                    <!-- /.col-lg-12 -->

                </div>
                <div class="row">
                    <div class="col-lg-12">                    
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                ค้นหาประวัติการขาย
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="alert alert-danger" style="display:none">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <span>กรุณาป้อน ข้อมูลให้ครบ ด้วยค่ะ.</span>
                                </div>
                                <form class="form-horizontal" role="form" id="frmcolor" method="POST">
                                    
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="conditions">ค้นหาจาก :</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" id="conditions" name="conditions">
                                                <option value="all" selected>--- เลือกทั้งหมด ---</option>                                                
                                                <option value="a.customer_name">ชื่อ-นามสกุล</option>
                                                <option value="a.customer_address">ที่อยู่</option>
                                                <option value="a.name_refer">ชื่อแหล่งที่มา</option>
                                                <option value="a.type_product">ประเภทสินค้า</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"  id="txtsearch" name="txtsearch">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="start_date">ช่วงวันที่  :</label>
                                        <div class="col-sm-3"> 
                                            <input type="date" class="form-control" id="start_date" name="start_date" > 
                                        </div>
                                        <label class="control-label col-sm-1" for="end_date">ถึง</label>
                                        <div class="col-sm-3"> 
                                            <input type="date" class="form-control" id="end_date" name="end_date" >
                                        </div>
                                    </div>                            
                                    <div class="form-group"> 
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="btnsave" name="btnsearch" value="1" class="btn btn-success">ค้นหา</button>
                                            <button type="reset" id="cancel" class="btn btn-danger">ยกเลิก</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>

                    
                    <?php
                        $conditions = "";
                        $conditions = "where 1=1 and ";
                        $txtstart = "";
                        $txtend= "";
                        if(!empty($_POST['btnsearch'])){
                            $tempcon = $conditions;
                            $_POST['start_date_befor_replace']=$_POST['start_date'];
                            $_POST['end_date_befor_replace']=$_POST['end_date'];
                            if(!empty($_POST['start_date'])){
//                                $_POST['start_date']  = date('Y-m-01');
                                $tempcon .= "b.sell_date >= '".$_POST['start_date']."' and ";
                            }
                            if(!empty($_POST['end_date'])){
//                                $_POST['end_date']  =  date('Y-m-t');
                                $tempcon .= "b.sell_date <= '".$_POST['end_date']."' and ";
                            }
                            
                            if(!empty($_POST['txtsearch'])){
                                if($_POST['conditions'] == "all"){
                                    $tempcon .= "(a.customer_name like '%".$_POST['txtsearch']."%' or ";
                                    $tempcon .= "a.customer_address like '%".$_POST['txtsearch']."%' or ";
                                    $tempcon .= "a.name_refer like '%".$_POST['txtsearch']."%' or ";
                                    $tempcon .= "a.customer_tumbon like '%".$_POST['txtsearch']."%' or ";
                                    $tempcon .= "a.customer_umpher like '%".$_POST['txtsearch']."%' or ";
                                    $tempcon .= "a.customer_province like '%".$_POST['txtsearch']."%' or ";
                                    $tempcon .= "a.customer_postal like '%".$_POST['txtsearch']."%' or ";
                                    $tempcon .= "a.type_product like '%".$_POST['txtsearch']."%') and ";

                                }else{
                                    if($_POST['conditions'] == "customer_address"){
                                        $tempcon .= "(a.customer_address like '%".$_POST['txtsearch']."%' or ";
                                        $tempcon .= "a.customer_tumbon like '%".$_POST['txtsearch']."%' or ";
                                        $tempcon .= "a.customer_umpher like '%".$_POST['txtsearch']."%' or ";
                                        $tempcon .= "a.customer_province like '%".$_POST['txtsearch']."%' or ";
                                        $tempcon .= "a.customer_postal like '%".$_POST['txtsearch']."%') and ";
                                    }else{
                                        $tempcon .= $_POST['conditions']." like '%".$_POST['txtsearch']."%' and ";
                                    }
                                    
                                }
                            }
                            

//                                                pr($_POST);
//                                                pr($tempcon);
                            $tempcon = substr($tempcon, 0,-4);
//                            pr($tempcon);
                            $results = $database->selects("sell a right join sell_date b on a.sell_date_id = b.sell_date_id and a.status = 1",
                                    $tempcon." order by b.sell_date","distinct(b.sell_date_id),b.sell_date "); 
//                            pr($results);
                            if(!empty($results)){
                                $tempdate = array();                                
                                foreach ($results as $key => $value) {
                                    if(!empty($value['sell_date_id'])){
                                        $tempdate[] = $value['sell_date_id'];
                                    }
                                }
                                $conditions .= "b.sell_date_id IN (".implode(",", $tempdate).") and ";                                
                            }else{
                                $conditions .= "b.sell_date_id IN (0) and ";  
                            }
                            ?>
                         <script type="text/javascript">

                            jQuery(document).ready(function () {
                                $('#txtsearch').val('<?=$_POST['txtsearch']?>');
                                $('#start_date').val('<?=$_POST['start_date_befor_replace']?>');
                                $('#end_date').val('<?=$_POST['end_date_befor_replace']?>');
                                $("#conditions option[value='<?=$_POST['conditions']?>']").prop('selected', true);

                            });
                            </script>
                        <?php
                        }else{
                            $txtstart = date('Y-m-01');
                            $txtend= date('Y-m-t');
                            $conditions .= "b.sell_date >= '".date('Y-m-01')."' and b.sell_date <= '".date('Y-m-t')."' and ";
                        }
                        $conditions = substr($conditions, 0,-4);
//                        pr($conditions);
                        $results = $database->selects("sell a right join sell_date b on a.sell_date_id = b.sell_date_id and a.status=1",
                        $conditions." group by b.sell_date_id order by b.sell_date DESC",
                        "a.*,sum(`profit`) as sum_profit,sum(`customer_pay`) as sum_customer_pay,b.*"); 
                        $txtprofit = 0;
                        $sum_customer_pay = 0;
                        foreach ($results as $key => $result) {                            
                            $result['sum_customer_pay'] = empty($result['sum_customer_pay']) ? 0 : $result['sum_customer_pay'];
                            $sum_customer_pay += $result['sum_customer_pay'];                            

                            $result['sum_profit'] = empty($result['sum_profit']) ? 0 : $result['sum_profit'];
                            $txtprofit += $result['sum_profit']-$result['advertise'];                            
                        }
                        ?>
                    
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                ประวัติการขาย 
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                
                                <?php if(!empty($_POST['btnsearch'])){?>
                                    <h3> ประวัติการขาย ของผลการค้นหา กำไร <?=$txtprofit?></h3>
                                <?php }else{?>
                                    <h3> ประวัติการขาย ระหว่างวันที่ <?=DThai_long($txtstart)?> ถึง <?=DThai_long($txtend)?> กำไร <?=$txtprofit?></h3>
                                <?php } ?>
                                <h4>ยอดขาย <?=$sum_customer_pay;?></h4>
                                <br>
                                <div class="table-result-scroll">
                                    <table class="table table-striped table-bordered table-hover" id="tb_pang2">
                                        <thead>
                                            <tr class='alert alert-success'>
                                                <th width="8%" style="text-align:center;">เลือก</th>
                                                <th width="22%" style="text-align:center">วันที่ขาย</th>
                                                <th width="18%"  style="text-align:center">ค่าโฆษณา</th>
                                                <th width="18%"  style="text-align:center">รายได้</th>
                                                <th width="18%"  style="text-align:center">กำไรสุทธิ</th>
                                                <th width="8%"  style="text-align:center">ดูข้อมูล</th>
                                                <th width="8%"  style="text-align:center">ลบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                                                       
                                            foreach ($results as $key => $result) {
                                                $val = $result['sell_date_id'] . "|" . $result['sell_date']. "|" . $result['advertise']. "|" . $result['sum_profit'];
                                                ?>
                                                <tr class="gradeX" style="cursor:pointer;" >
                                                    <td style="text-align:center"><input type="checkbox" name="chk[]" class="checkboxes" value="<?=$result['sell_date_id'];?>" /></td>
                                                    <td style="text-align:center"><?= $result['sell_date']; ?></td>
                                                    <td style="text-align:center"><?= $result['advertise']; ?></td>
                                                    <td style="text-align:center"><?= empty($result['sum_profit']) ? "0" : $result['sum_profit'] ?></td>
                                                    <td style="text-align:center">
                                                        <?php $txtprofit =$result['sum_profit']-$result['advertise'];?>
                                                            <?= $txtprofit < 0 ? "<span style=\"color: #C50B05\">".$txtprofit."</span>" : $txtprofit ?></td>
                                                    <td style="text-align:center"><a  href="detail.php?date=<?=$result['sell_date']?>"  class="btn glyphicon glyphicon-eye-open btn-info"><i></i></a></td>
                                                    <td style="text-align:center"><a href="javascript:void(0)"  onclick="del('<?= $result['sell_date_id']; ?>','<?= $result['sell_date']; ?>')" class="btn glyphicon glyphicon-trash btn-danger"><i></i></a></td>
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

            function del(id,name){
                var selectedItems = new Array();
                $("input[name='chk[]']:checked").each(function() {selectedItems.push($(this).val());}).get().join(",");
                if(selectedItems != ''){                    
                    if(confirm('คุณต้องการลบประวัติการขายที่เลือกหรือไม่ ?')==true){
                    $.post('action.php?go=del_date_all',{'sell_date_id':selectedItems},function(data){
                            $("#res").html(data);
                    });
                    }else{
                            return false;
                    }	
                }else{
                    if(confirm('คุณต้องการลบประวัติการขายวันที่ ' + name +' ใช่หรือไม่ ?')==true){
                        $.post('action.php?go=del_date',{'sell_date_id':id},function(data){
                                $("#res").html(data);
                        });
                    }else{
                            return false;
                    }
                }	
            }
            
            function edit(id,value){
                var data = value.split("|");
                //alert(data);
                $("#h_val_id").val(id); 
                $("#sell_date").val(data[1]);
                $("#advertise").val(data[2]);
				
                $.post('action.php?go=chk_date',$("#frmsellDate").serialize(),function(data){
                        $("#res").html(data);
                });
                $('body,html').animate({
                    scrollTop: 0
                }, 500);
                return false;

            }
        </script>
        <?php require_once 'footer.php' ?>
    </body>
</html>

