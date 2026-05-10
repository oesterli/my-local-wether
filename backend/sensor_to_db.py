#!/usr/bin/env python3
from sense_hat import SenseHat
import psycopg2
import time
from datetime import datetime 
import os
from dotenv import load_dotenv

sense = SenseHat()

# Verbindung zur Datenbank
try:
    load_dotenv()

    conn = psycopg2.connect(
        dbname = os.getenv("DB_NAME"),
        user = os.getenv("DB_USER"),
        password = os.getenv("DB_PASS"),
        host = os.getenv("DB_HOST")
    )
    cur = conn.cursor()

    # Daten auslesen
    temp = sense.get_temperature()
    pres = sense.get_pressure()
    humi = sense.get_humidity()
    time = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

    # In DB schreiben
    cur.execute("INSERT INTO wetterdaten (temperatur, luftdruck, feuchtigkeit) VALUES (%s, %s, %s)",
                (temp, pres, humi))
    
    conn.commit()
    cur.close()
    conn.close()
    print(f"{time} - Daten erfolgreich gespeichert!")
    
    # Optional: Kurze Rueckmeldung auf dem LED-Display
    # Farben definieren (R, G, B)
    rot = (255, 0, 0)
    blau = (0, 0, 255)
    gelb = (255, 255, 0)
    schwarz = (0, 0, 0)
    
    sense.low_light = True  # Spart Strom und schont die Augen

    sense.set_rotation(180)

    sense.show_message("log to DB", text_colour=gelb, back_colour=blau, scroll_speed=0.05)

    sense.clear()

except Exception as e:
    print(f"Fehler: {e}")
