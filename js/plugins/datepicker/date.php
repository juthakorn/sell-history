<html>
<head>
<title>ฝึก  PHP</title>
<link type="text/css" href="jquery-ui.css" rel="stylesheet" />	
<script type="text/javascript" src="jquery.js"></script>
		<script type="text/javascript" src="jquery-ui.js"></script>
<script type="text/javascript">
		  $(function () {
				// Datepicker
		    $("#datepicker-th").datepicker({ dateFormat: 'dd-mm-yy',dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
			  
			});
		</script>

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

