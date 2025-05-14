#### Story
Wir wollen ein Event Driven Symfony Microservice bauen der Anfragen per Webhook erhält und als Proxy dient um die Rohdaten
in notwendige schöne Daten für das Kundensystem (CDP) bereitzustellen.

## Wir benötigen das endgültige Format, wie müssen die Daten für das CDP aussehen?

   Wir erzeugen ein Array das diesen Daten entspricht. Jede Benutzeraktion (Seitenbesuch,neues Abonnement, Produktkauf) soll
   als "track" Nachricht. In bestimmten Fällen (Benutzerregistrierung, Abschluss eines Abbos) geht unser Proxy-Dienst noch einen Schritt weiter und   
   sendet eine "identiy" Nachricht.  Diese Nachricht hilft der CDP, den Benutzer zu erkennen und aufzuzeichnen und seine Aktionen mit einem 
   eindeutigen Profil zu verknüpfen.


## JOURNAL
- ModelInterface erstellt und 2 anonyme Model-Klassen die ein identify und track Array zurückliefern (DEMODATEN)
- benutzerdefinierten Http-Client erstellt, zum Testen (senden) von Identifkations- und Trackdaten
- PHP Unit konfiguriert und mit WebhookControllerTest den ersten Test geschrieben, mit KernelBrowser (simuliert einen Browser) alternativ zu Postman
- Webhook DTO erstellt, darin wird der Eventname und der Payload gemappt