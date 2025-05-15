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
- WebhookController, Serializer umd raw Daten auf ein Webhook Dto zu mappen

- WebhookHandlerInterface als Vorlage für unterschiedliche Handler (supports)
   - support() - Prüft ob dieser Handler, den erhaltenen Webhook handeln kann
   - handle()  - tut was es tun muss, um die richtigen Daten an die Kundenplattform weiterzuleiten
- NewsletterHandler der supports (prüft auf gültigen Event) und handle implementiert hat
- service.yaml, wir registrieren das WebhookHandlerInterface als Tag, um es mit dem #AutoWireIterator einfacher
  durchlaufen zu können
- HandlerDelegator Klasse erstellt, WebhooksController mappt Daten auf Webhook DTO und ruft dann den
  Delegator auf der alle Handler iteriert mit #AutoWireIterator['webhook.handler'] und prüft ob supports Webhook Event unterstüzt und wenn ja, weiter verarbeitet über handle()
- NewsletterWebhook erstellt, sowie Newsletter DTO und User DTO die für das mappen genutzt werden
- NewsletterWebhookFactory erstellt, deserialisiert ankommenden Webhook und mappt ihn auf das            NewsletterWebhook, der Aufruf erfolgt im NewsletterHandler der das HandlerInterface (supports, handle) implementiert, ist der Event gültig (supports), wird handle() mit NewsletterWebhookFactory ein neuer NewsletterWebhook created
- WebhookException erstellt, für eigene Fehlerbehandlung
- ForwarderInterface erstellt (supports, forward), prüft auf gültige Events die dann bspw. ans Kundensystem (CDP) weitergeleitet werden
- PHPStan hatte angekreidet das für #[AutowireIterator] die /** @param */ fehlten
- SubscriptionStartForwarder erstellt, implementiert das ForwarderInterface das prüft ob der Webhook das passende Event hat und leitet
  dann die Daten weiter - Model erstellen und validieren, bevor wir es weiterleiten
- Identify Model Object erstellt und ModelInterface um die Konstanten Identify und Track ergänzt, Model wird dazu genutzt um das NewsletterWebhook zu füllen

- SubscriptionStartMapperr mit dem wir das Identify-Model auf das NewsletterWebhook mappen können (aufruf im SubscriptionStartForwarder), damit auch andere Objekte gemappt werden könne, erstellen wir ein SubscriptionSourceInterface, welches vom NewsletterWebhook implements wird.


  Zwischendurch mal Codeoptimierungen machen:
  docker compose exec app vendor/bin/phpstan
  docker compose exec app vendor/bin/phpcbf 
  docker compose exec app vendor/bin/phpunit
  docker compose exec app vendor/bin/phpcs


