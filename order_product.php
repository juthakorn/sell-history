<!DOCTYPE html>
<html>
    <?php require_once 'header.php' ?>
    <style>#sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
    #sortable li { margin: 0 3px 3px 3px; padding: 4px; padding-left: 1.5em; font-size: 1.4em;  }
    #sortable li span { position: absolute; margin-left: -1.3em;margin-top: 4px; }</style>
    <body>
        <div id="wrapper">
            <?php require_once 'menu.php' ?>
            <div id="res"></div>
            <div id="page-wrapper" >

                <div class="row">

                    <div class="col-lg-12">
                        <h1 class="page-header">เพิ่มสินค้า</h1>
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
                                    
                                    <ul id="sortable">
                                        <?php 
                                        $results = $database->selects("products","where 1 =1 order by position ASC");  
                                        foreach ($results as $key => $value) {?>
                                             <li class="ui-state-default" id="<?=$value['id']?>"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?=$value['name']?></li>
                                                                                  
                                        <?php }?>
                                     </ul>
                                    <input type="hidden" name="position" id="ContentPosition"/>
                                    <hr>
                                    <div class="form-group"> 
                                        <div class="col-sm-offset-5">
                                            <button type="button" id="btnsave" class="btn btn-success">บันทึก</button>
                                        </div>
                                    </div>
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
            jQuery(document).ready(function () {
                
                    $( "#sortable" ).sortable({
                        update: function(event, ui) {
                            var result = jQuery(this).sortable('toArray');
                            jQuery("#ContentPosition").val(result.join(","));  
                            flag_update = true; // true, category position is changed
                        }
                    });
                    $( "#sortable" ).disableSelection();
                  
                
                 
                
            });
            
            $('#btnsave').click(function(){
                if(jQuery("#ContentPosition").val() != ""){
                    $.ajax({
                      url: "../action.php?go=order_pro",
                      type: "post",
                      data : {'position':jQuery("#ContentPosition").val()},
                      success: function(ret)
                      {
                          $('#res2').html(ret);
                      }
                   });
                }
                
            });
            
            
                
        </script>
        <?php require_once 'footer.php' ?>
    </body>
</html>

