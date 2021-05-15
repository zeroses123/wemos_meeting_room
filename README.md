# Presence Detection in Meeting Room
A simple script to check Presence / Availability of a Meeting Room with an ESP8266 (Wemos D1) and send it to a webserver to check the availability. <img width="1101" alt="Bildschirmfoto 2021-05-15 um 22 31 10" src="https://user-images.githubusercontent.com/84248512/118377402-5130ae00-b5cd-11eb-8a28-6ba00b330d48.png">

## Problem?
Meeting Rooms are offen empty, even if the Booking Tool shows the room as occupied. Some meetings end early or some get cancelled. To Check the availability, I have created this simple effective tool to show the availability. 

## Required Hardware
1. Wemos D1 Mini (4 €)
2. AM312 Infrared Sensor (Had problems with HC-SR501) (2€)
3. Wires, Soldering Iron etc. (1 €)
4. A case https://www.thingiverse.com/thing:4738646

## Required Software
1. Arduino IDE

# Installation
1. Solder VCC of the AM312 to 3,3V of Wemos D1
1. Solder Middle Pin of AM312 to D7 of Wemos D1
1. Solder GND of AM312 to GND Pin of Wemos D1
1. Follow Guide to install Arduino IDE and connect Wemos D1 on Windows/MAC/Linux https://averagemaker.com/2018/03/wemos-d1-mini-setup.html2. Change presence_detector.ino according to your settings (Room Number, Your Server, Wifi SSID, Password, Presence Delay) and Upload to Wemos D1
1. Upload status.php and meeting_room.php to your Server (Has to be NON-FORCE-SSL due to the lack of SSL support for now)
1. ENJOY!

If you have any questions, feel free to ask me!
