#include <Arduino.h>

#include <WiFiManager.h>
#include <WiFi.h>
#include <HTTPClient.h>
//Libraries
#include <SPI.h>
#include <MFRC522.h>

#define SS_PIN 5
#define RST_PIN 0
#define buzzer 2

String gate = "masuk";
const char* ssid = "alldone";            // Change this to your WiFi SSID
const char* password = "putrabangsa42";  // Change this to your WiFi password
String host = "192.168.1.104:8001";


unsigned long time_waiting_tap;
String data_rfid = "";

//Variables
byte nuidPICC[4] = { 0, 0, 0, 0 };
MFRC522::MIFARE_Key key;
MFRC522 rfid = MFRC522(SS_PIN, RST_PIN);


// WiFiManager wm;
void setup() {
  WiFi.mode(WIFI_STA);
  WiFiManager wm;

  pinMode(buzzer, OUTPUT);
  Serial.begin(9600);
  Serial.println(F("Initialize System"));
  //rfid
  SPI.begin();
  rfid.PCD_Init();
  Serial.print(F("Reader :"));
  rfid.PCD_DumpVersionToSerial();
  //wifi
  Serial.print("Connecting to ");
  Serial.println(ssid);
  bool res;
  res = wm.autoConnect("smart", "smart123");
  if (!res) {
    Serial.println("Failed to connect");
    digitalWrite(buzzer, 0);
    // ESP.restart();
  } else {
    //if you get here you have connected to the WiFi
    Serial.println("connected");
    digitalWrite(buzzer, 1);
  }
}

void loop() {

  if (WiFi.status() == WL_CONNECTED) {
    readRFID();
  } else {
    Serial.println("reconnect");
  }
}

void readRFID(void) {
  for (byte i = 0; i < 6; i++) {
    key.keyByte[i] = 0xFF;
  }
  if (!rfid.PICC_IsNewCardPresent())
    return;
  if (!rfid.PICC_ReadCardSerial())
    return;
  String datarfid = "";
  for (byte i = 0; i < 4; i++) {
    nuidPICC[i] = rfid.uid.uidByte[i];
    datarfid += nuidPICC[i] < 0x10 ? "0" : "";
    datarfid += nuidPICC[i];
  }


  if (millis() - time_waiting_tap > 5000 || datarfid != data_rfid) {
    HTTPClient http;
    Serial.println("http://" + host + "/logtap/tap?rfiddata=" + datarfid + "&keterangan=" + gate);
    http.begin("http://" + host + "/logtap/tap?rfiddata=" + datarfid + "&keterangan=" + gate);  //HTTP
    int httpCode = http.GET();
    Serial.println(httpCode);
    if (httpCode > 0) {
      if (httpCode == HTTP_CODE_OK) {
        String payload = http.getString();
        Serial.println(payload);
        digitalWrite(buzzer, 0);
        delay(100);
        digitalWrite(buzzer, 1);
        delay(100);
        digitalWrite(buzzer, 0);
        delay(100);
        digitalWrite(buzzer, 1);
        delay(100);
      }
    }
    http.end();
    data_rfid = datarfid;
    Serial.println(datarfid);

    time_waiting_tap = millis();
  }
  rfid.PICC_HaltA();
  rfid.PCD_StopCrypto1();
}
