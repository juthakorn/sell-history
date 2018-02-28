<html>
<head>
<title>ฝึก  PHP</title>
<link type="text/css" href="css/jquery-ui-1.10.3.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
<script type="text/javascript">
		  $(function () {
		    var d = new Date();
		    var toDay = d.getDate() + '-'
        + (d.getMonth() + 1) + '-'
        + (d.getFullYear() + 543);

				// Datepicker
		    $("#datepicker-th").datepicker({ dateFormat: 'dd-mm-yy', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
			  $("#datepicker-th-2").datepicker({ changeMonth: true, changeYear: true,dateFormat: 'dd-mm-yy', isBuddhist: true, defaultDate: toDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
			  $("#datepicker-en").datepicker({ dateFormat: 'dd-mm-yy'});
			  $("#inline").datepicker({ dateFormat: 'dd-mm-yy', inline: true });
			});
		</script>
<style type="text/css">  
.ui-datepicker{  
    width:200px;  
    font-family:tahoma;  
    font-size:14px;  
    text-align:center;  
}  
</style>  
</head>
<body>
    <form name="55" method="post" action="">
พ.ศ. <input type="text" id="datepicker-th" name="date1" />
	พ.ศ. แบบมีให้เลือกปี/เดือน <input type="text" id="datepicker-th-2" name="date0" />
  
    <input type="submit" value="ตกลง">
    </form>
    <?php
	//  การบันทึกลงฐานข้อมูล ต้องแปลงจาก 25-11-2556 เป็น 2013-11-25  มีวิธีดังนี้
	//เริ่มแรกรับค่ามาไว้ที่ตัวแปลงก่อน
	$d_begin=$_POST[date1];
	$d_warrant=$_POST[date0];
	
	//--------------แปลงเป็น 2013-11-25 ดังนี้   --------------------
	$part=explode("-",$d_begin);
	$y=$part[2]-543;
	$date_begin="$y"."-"."$part[1]"."-"."$part[0]";

	$part1=explode("-",$d_warrant);
	$y1=$part1[2]-543;
	$date_warrant="$y1"."-"."$part1[1]"."-"."$part1[0]";
	
	//----------ตัวแปรที่จะลง DB คือ -------------
	echo $date_begin."<br>";
        echo  $date_warrant ."<br>";

	?>
</body>
</html>

