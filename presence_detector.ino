#include <ESP8266WiFi.h>
//#include <WiFiClientSecure.h>
#include <WiFiClient.h>
#include <ESP8266mDNS.h>
#include <Time.h>
#include <SPI.h>

const char* ssid = "WLAN-SSID"; // enter Wifi SSID
const char* password = "wifipass"; // enter Wifi Password
const char* host = "your-website.com"; // Host-Domain where to send data (Currently no SSL support)
const int httpPort = 80;
String meetingstatus = "Occupied";
int sensor = D7; // PIN where the sensor is connected. Recommend AM312 Infrared Sensor
String raum = "1"; // Number of the room
//const char fingerprint[] PROGMEM = "DE 3D 5E BD CC DF EB 84 E5 37 A4 94 F2 67 55 0C 35 69 CE F9";
//WiFiClient client;
void send()
{
  Serial.println(); Serial.print("Connecting to ");
  Serial.println(ssid);
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED)
  {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected"); Serial.println("IP address: "); Serial.println(WiFi.localIP());
  int value = 0;

  delay(5000); ++value; Serial.print("connecting to ");
  Serial.println(host); // Use WiFiClient class to create TCP connections
  WiFiClient client;
  //client.setFingerprint(fingerprint);

  if (!client.connect(host, httpPort)) {
    Serial.println("connection failed");
    return;
  }
  // We now create a URI for the request
  //this url contains the informtation we want to send to the server
  //if esp8266 only requests the website, the url is empty
  String url = "/status.php";
  url += "?raumnr=" + raum + "&status=" + meetingstatus;
  /*url += param1;
    url += "?param2=";
    url += param2;
  */
  Serial.print("Requesting URL: ");
  Serial.println(url); // This will send the request to the server
  client.print(String("GET ") + url + " HTTP/1.1\r\n" + "Host: " + host + "\r\n" + "Connection: close\r\n\r\n");
  unsigned long timeout = millis();
  while (client.available() == 0) {
    if (millis() - timeout > 5000)
    { Serial.println(">>> Client Timeout !");
      client.stop(); return;
    }
  } // Read all the lines of the reply from server and print them to Serial
  while (client.available())
  { String line = client.readStringUntil('\r'); Serial.print(line);
  }
  Serial.println();
  Serial.println("closing connection");
}
void setup(void) {
  pinMode(sensor, INPUT);
  Serial.begin(115200);
  WiFi.begin(ssid, password);
  Serial.println("");

  // Wait for connection
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
}

unsigned long zuletzt = millis();
unsigned long wifizuletzt = 200000; // Triggers a connection upon beginning
unsigned long dauer = 300000; // Every Movement in the room triggers the timer of 300000 sec / 5 min
unsigned long wifisend = 60000; // Connects to the Server every minute
int bew = 0;
void loop(void) {
  long state = digitalRead(sensor);
  if (state == HIGH) {
    zuletzt = millis();
    Serial.println("Room occupied");
    meetingstatus = "Belegt";
  } else {
    if (millis() - zuletzt >= dauer) {
      Serial.println("Room Clear");
      meetingstatus = "Frei";
    }
  }

  delay(1000);
  if (millis() - wifizuletzt >= wifisend) {
    send();
    wifizuletzt = millis();
  }
}
