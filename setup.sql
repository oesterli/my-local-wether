-- Create DB
CREATE DATABASE meine_website;
CREATE USER mein_user WITH ENCRYPTED PASSWORD 'mein_passwort';
GRANT ALL PRIVILEGES ON DATABASE meine_website TO mein_user;


-- Create Table
CREATE TABLE wetterdaten (
    id SERIAL PRIMARY KEY,
    zeitpunkt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    temperatur FLOAT,
    luftdruck FLOAT,
    feuchtigkeit FLOAT
);