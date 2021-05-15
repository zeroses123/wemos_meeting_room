<?php

$raumanzahl = 4; // Total Number of rooms / sensors

for ($i = 1; $i <= $raumanzahl; $i++) {
	$filename = "raum" . $i . ".txt"; // Dateiname in dem Belegt oder Frei steht
	$filetime = filemtime ($filename); // Wann fand die letzte Änderung der Datei statt?
	$timediff = time() - $filetime; // Differenz zur jetzigen Zeit in sek
	
	if(($timediff) < 300) { // Wenn die letzte Änderung unter 5 min statt fand, ist der Sensor ONLINE
		${'status' . $i} = file_get_contents( $filename ); //Bsp.: status1 = Belegt
		if (${'status' . $i} == "Frei") ${'class' . $i} ="frei"; //grünes Fenster
	
		if (${'status' . $i} == "Belegt") ${'class' . $i} = "belegt"; // rotes Fenster
	
		} else {
			${'status' . $i} = "OFFLINE"; // keine Änderung seit 5 min: OFFLINE
			${'class' . $i} = "belegt"; // und rotes Fenster
		}
		
		${'filetime' . $i} = $filetime; //Bsp $filetime3 = 392293293 Sek
		${'timediff' . $i} = $timediff;	
}
$minletzteakt = max ($filetime1,$filetime2,$filetime3,$filetime4); //
$letzteakt = date('d.m.Y H:i:s', $minletzteakt); // Größter Wert der letzten Aktualisierung
?>

<html>
<head>
	 <meta http-equiv="refresh" content="30" />
	<style>
		body{
		   margin: 0;
		    padding: 0;
		    font-size: 24px;
		    zoom: 1;
		    cursor: default;
		    background: white;
			font- family: "Roboto";
			font-weight: 500;
		}
		.header {
		    letter-spacing: -0.02em;
		}
		.grnVLine {
		    background: #61be41;
		}
		.vLine {
		    display: block;
		    width: 6px;
		    height: 101px;
		}
		#roomName {
		    position: absolute;
		    left: 7px;
		    top: 2px;
		    display: block;
		}
		.label_RoomName {
		    font-size: 72px !important;
		    line-height: 101px;
		    margin-left: 18px;
		    white-space: nowrap;
		}
		.label_RoomName, .label_NoMeetings {
		    font-weight: normal;
		    letter-spacing: -0.03em;
		    padding: 0;
		}
		.wrapper {
		    position: absolute;
		    z-index: 1;
		    left: 42px;
		    top: 40px;
		    right: 42px;
		}
		#currentTimePanel {
		    display: none;
		}#currentTime {
		    display: block;
		    position: absolute;
		    top: 62px;
		    right: 57px;
		    letter-spacing: 0.0em;
		}
		.timeDisp {
		    font-size: 55px;
		    color: #ebebeb;
		    margin-top: 16px;
		}body, a, h1, .timeDisp, .label_RoomName, .clearBtn, #imgExtendButtonInner, #imgConfirmButtonInner, #imgExtendButtonConfirmInner, .label_Button, .button2, .button1, .buttonC {
		    font-family: 'Roboto';
		}
		/* Added styles */
		.homeMain{
		  margin: 100px 10px;
		}

		.frei{
		  text-align: center;
		  border:1px solid #fff;
		  cursor: pointer;
		  background-color: #81a163;
		  display:inline-block;
		  width: 200px;
		  height: 180px;
		  margin: 20px;
		  padding: 10px;
		  text-decoration: none;
		}
		.belegt{
		  text-align: center;
		  border:1px solid #fff;
		  cursor: pointer;
		  background-color: #ffb38a;
		  display:inline-block;
		  width: 200px;
		  height: 180px;
		  margin: 20px;
		  padding: 10px;
		  text-decoration: none;
		}
		.roomCard:active{
		  box-shadow: 1px 1px 20px #fff;
		}
		.mini {font-size: 10pt;}
		.roomCard h1{
		  color: #fff;
		}
		</style>
		
</head>
<body>
  <div class="wrapper">
    <div id="currentTimePanel" class="timeDisp" style="display: block;"><span id="currentTime"></span>
    </div>
    <div class="header">
      <span id="meetingStatusBar" class="vLine grnVLine"></span>
      <span id="roomName" class="label_RoomName">Meeting Raum Verfügbarkeit</span>
    </div>
    <div class="homeMain">
      <?php
      	for ($i = 1; $i <= $raumanzahl; $i++) { 
			//if (${'timediff' . $i} < 300) { // Blende Raum aus wenn OFFLINE
			echo '<a class="'.${'class' . $i}.'" href="" target="_blank">
					<h1>Raum '.$i.' '.${'status' . $i}.'</h1>
			      </a>';
				  //}
		}
	?>
	
		<p class='mini'>Letzte Aktualisierung am <?php echo $letzteakt ?></p><p></p>

	</div>
  </div>
</body>

</html>
