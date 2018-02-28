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
                        <h1 class="page-header">คำนวณสินเชื่อรถมือสอง</h1>
                    </div>
                    <!-- /.col-lg-12 -->

                </div>
                <div class="row">
                    <div class="col-lg-12">                    
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                ฟอร์มคำนวณสินเชื่อรถ
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="alert alert-danger" style="display:none">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <span>กรุณาป้อน ข้อมูลให้ครบ ด้วยค่ะ.</span>
                                </div>
                                <form class="form-horizontal" role="form" id="frmcal">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="sell_date">ราคารถ(บาท) :</label>
                                        <div class="col-sm-4 "> 
                                            <input type="text" class="form-control check" id="price" name="price" >                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="advertise">เงินดาวน์(บาท) :</label>
                                        <div class="col-sm-4  "> 
                                            <input type="text" class="form-control check" id="payment" name="payment" >                                            
                                        </div>                                        
                                        <label class="control-label col-sm-1" for="advertise">หรือ ดาวน์ (%) </label>
                                        <div class="col-sm-1   " > 
                                            <input type="text" class="form-control check" id="payment_percent1" name="payment_percent1" >                                           
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="sell_date">ระยะเวลาผ่อนชำระ(เดือน) <span style="color:#d9534f"> *</span> :</label>
                                        <div class="col-sm-4 ">                                             
                                            <select class="form-control" name="time" id="time">
                                                <option value="1">12</option>
                                                <option value="1.5">18</option>
                                                <option value="2">24</option>
                                                <option value="3">36</option>
                                                <option value="4">48</option>
                                                <option value="5">60</option>
                                                <option value="6">72</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="sell_date">อัตราดอกเบี้ยต่อปี(%) <span style="color:#d9534f"> *</span> :</label>
                                        <div class="col-sm-4 "> 
                                            <input type="text" class="form-control" id="interest_rate" name="interest_rate">
                                            
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group"> 
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="button" id="btncal" class="btn btn-success" >คำนวณ</button>
                                            <button type="reset" id="reset" class="btn btn-danger">ยกเลิก</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>

                     
                </div>
                
                <div class="row">
                    <div class="col-lg-12">                    
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                ผลลัพธ์
                            </div>
                            <div class="panel-body">
                                
                                <form class="form-horizontal" role="form" id="frmcal">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="sell_date">Vat 7% ต่อเดือน :</label>
                                        <div class="col-sm-4 "> 
                                            <input type="text" class="form-control" id="result7" name="result2" readonly="" >                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="sell_date">ค่างวด :</label>
                                        <div class="col-sm-4 "> 
                                            <input type="text" class="form-control" id="result0" name="result2" readonly="" >                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="sell_date">ค่างวด + Vat 7% :</label>
                                        <div class="col-sm-4 "> 
                                            <input type="text" class="form-control" id="result07" name="result2" readonly="" >                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="sell_date">ยอดจัด :</label>
                                        <div class="col-sm-4 "> 
                                            <input type="text" class="form-control" id="result1" name="result1" readonly="">                                            
                                        </div>
                                    </div>                                    
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="sell_date">ดอกเบี้ยทีั่เสีย :</label>
                                        <div class="col-sm-4 "> 
                                            <input type="text" class="form-control" id="result2" name="result2" readonly="">                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="sell_date">รวมยอดจัด + ดอกเบี้ยทีั่เสีย  :</label>
                                        <div class="col-sm-4 "> 
                                            <input type="text" class="form-control" id="result3" name="result2" readonly="">                                            
                                        </div>
                                    </div>                                    
                                </form>
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
            Number.prototype.format = function(n, x) {
                var re = '(\\d)(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
                return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$1,');
            };
            $(function(){
                $('#payment').change(function(){
                    if($('#price').val() != "" && $('#payment').val() != ""){
                        var percent = (parseFloat($('#payment').val()) * 100) / parseFloat($('#price').val()); 
                        $('#payment_percent1').val(percent.format(2));
                    }
                });
                $('#payment_percent1').change(function(){
                    if($('#price').val() != "" && $('#payment_percent1').val() != ""){
                        var percent = (parseFloat($('#price').val()) * parseFloat($('#payment_percent1').val())) / 100; 
                        $('#payment').val(percent);
                    }
                });
                $('#price').change(function(){
                    if($('#price').val() != "" ){
                        if($('#payment').val() != "" ){
                            var percent = (parseFloat($('#payment').val()) * 100) / parseFloat($('#price').val()); 
                            $('#payment_percent1').val(percent.format(2));
                        }else if($('#payment_percent1').val() != "" ){
                            var percent = (parseFloat($('#price').val()) * parseFloat($('#payment_percent1').val())) / 100; 
                            $('#payment').val(percent);
                        }
                    }
                    
                });
                
                $('#btncal').click(function(){
                    if($('#price').val() != "" && $('#payment_percent1').val() != "" 
                         && $('#payment').val() != "" && $('#interest_rate').val() != ""){
                            let toprated = parseFloat($('#price').val()) - parseFloat($('#payment').val());
                            let result2 = toprated * (parseFloat($('#interest_rate').val())/100) * parseFloat($('#time').val())
                            
                            let result0 = (toprated+result2) / parseInt($('#time').val()*12);
                            let vat7 = (result0*7)/100;
                            let result07 = result0+vat7;
                            let result22 = result2 + (vat7*(parseFloat($('#time').val()) * 12));
                            $('#result7').val(vat7.format(2));
                            $('#result0').val(result0.format(2));
                            $('#result07').val(result07.format(2));
                            $('#result1').val(toprated.format(2));
                            $('#result2').val(result22.format(2));
                            $('#result3').val((toprated+result22).format(2));
                        }
                });
            });
            
        </script>
        <?php require_once 'footer.php' ?>
    </body>
</html>

