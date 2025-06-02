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

- SubscriptionStartMapperr mit dem wir das Identify-Model auf das NewsletterWebhook mappen können (aufruf im SubscriptionStartForwarder), damit auch andere Objekte gemappt werden könne, erstellen wir ein SubscriptionSourceInterface, welches vom NewsletterWebhook implements wird, damit die Methoden (getProduct,getEventDate...) im NewsletterWebhook aufgerufen werden können, um das Object zu befüllen

- CdpClient erhält ein CdpClientInterface mit 2 Methoden track und identify

- Testumgebung für isolierte korrekte Vearbeitung schaffen:
  - Unit-Tests könnte zeigen das alle Einzelteile funktionieren, aber Gewissheit gibt es nicht
  - Anfragen an den Dienst richten und dann im Verwaltungsbereich der Kundenplattform nachsehen, ist ist das eine Praxis in der Entwicklung?
  - Wir sollten in der Lage sein, zu testen, ob unser Dienst isoliert korrekt funktioniert, ohne die Dienste mit denen er interagiert prüfen zu müssen

   - Dazu erzeugen wir einen benutzerdefinierten CdpClient, registrieren das Interface als Alias (service.yaml)
     ```
     # Services which will be doubled for tests, better to use the test environment as multiple requests to the Frontend
    App\CDP\Http\CdpClientInterface: '@App\CDP\Http\CdpClient'
     ```

- FakeCdpClient.php, ein Testclient mit dem wir Anfragen simulieren
- FakeCdpClient in service.yaml registriert, damit der Container ihn finden kann, der er im Test-Ordner und somit ausserhalb von src-Ordner liegt

- PhpUnit Test, WebhooksControllerTest ist mit WebTestCase extended und kann somit auf den Container zugreifen, damit laden wir den den Container und das CdpClientInterface, welches in Testumgebung automatisch den FakeCdpClient lädt...cool oder
    ```
      $this->container = $this->webTester-    >getContainer();
      $this->cdpClient = $this->container->get(CdpClientInterface::class);
    
  ```


- PHPUnit Integrations Test, SubscriptionStartForwarder sendet identifyModel Daten per CdpClient, wir prüfen Aufruf und Daten
  ```  docker compose exec app vendor/bin/phpunit ```

- InditifyModel um Asserts ergänzt (NotBlank,etc) und einen ModelValidator erstellt mit dem 
die Models auf Constraints geprüft werden können

- ModelValidator (Validator) und ModelValidatorTest (PHPUnit Test auf valides und invalides Model)

- ModelValidator nach Test nun im Projekt eingesetzt im SubscriptionStartForwarder der das Model nun validiert und wenn keine Exception geworfen wird, eine Identify Anfrage per CdpClient absetzt


- Jetzt benötigen eine Forwarder für eine Track Weiterleitung

- SubscritionFowarder erstellt, Track Model erstellt mit Validation Asserts (Not Blank etc, Regex)
- SubscritionMapper und SubscriptionSourceInterface erstellt, der das übergebene Webhook auf das Track Model mappt
- NewsletterWebhook implementiert das SubscriptionSourceInterface, nutze DateInterval um Subscription Standardmässig um 1 Jahr zu verlängern
- WebhooksControllerTest (PHPUnit Test) erweitert um den Track-Daten Test



  Zwischendurch mal Codeoptimierungen machen:
  docker compose exec app vendor/bin/phpstan
  docker compose exec app vendor/bin/phpcbf 
  docker compose exec app vendor/bin/phpunit
  docker compose exec app vendor/bin/phpcs


