#### Story
Wir wollen ein Event Driven Symfony Microservice bauen der Anfragen per Webhook erhält und als Proxy dient um die Rohdaten
in notwendige schöne Daten für das Kundensystem (CDP) bereitzustellen.

1. Wir benötigen das endgültige Format, wie müssen die Daten für das CDP aussehen?

   Wir erzeugen ein Array das diesen Daten entspricht. Jede Benutzeraktion (Seitenbesuch,neues Abonnement, Produktkauf) soll
   als "track" Nachricht. In bestimmten Fällen (Benutzerregistrierung, Abschluss eines Abbos) geht unser Proxy-Dienst noch einen Schritt weiter und   
   sendet eine "identiy" Nachricht.  Diese Nachricht hilft der CDP, den Benutzer zu erkennen und aufzuzeichnen und seine Aktionen mit einem 
   eindeutigen Profil zu verknüpfen.


Model Interface erstellt, das