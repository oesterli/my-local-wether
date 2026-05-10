# 🌦️ Sense HAT Wetterstation

Eine vollautomatische Wetterstation auf Basis des Raspberry Pi. Das System misst Temperatur, Luftdruck und Feuchtigkeit, speichert die Daten in einer PostgreSQL-Datenbank und visualisiert sie in Echtzeit auf einem webbasierten Dashboard.

## 🚀 Features

*   **Datenerfassung:** Python-Skript liest Sensordaten vom Sense HAT.
*   **Datenbank:** Speicherung in PostgreSQL mit Zeitstempel.
*   **Automatisierung:** Cronjob-Steuerung für regelmäßige Messungen.
*   **Dashboard:** Web-Interface mit PHP, JavaScript und Chart.js.
*   **Dynamisch:** Live-Updates des Graphen ohne Neuladen der Seite.
*   **Sicherheit:** Vorbereitet für HTTPS und Security Header.

## 🛠️ Hardware-Anforderungen

*   Raspberry Pi (getestet auf RPi 4 / RPi 5)
*   Sense HAT Erweiterungsmodul

## 📂 Struktur

- `/backend`: Python-Skripte zur Sensorabfrage & `.env.example`.
- `/web`: PHP-Dateien für das Web-Dashboard & Chart.js Integration.
- `setup.sql`: Datenbank-Schema.

## ⚙️ Installation

### 1. Datenbank vorbereiten
Erstelle eine PostgreSQL-Datenbank und führe das Setup-Skript aus:
```bash
sudo -u postgres psql -d deine_db -f setup.sql