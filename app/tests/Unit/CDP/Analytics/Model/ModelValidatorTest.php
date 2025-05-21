<?php

declare(strict_types=1);

use App\CDP\Analytics\Model\ModelValidator;
use App\CDP\Analytics\Model\Subscription\Identify\IdentifyModel;
use App\Error\WebhookException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

class ModelValidatorTest extends TestCase
{
    private ModelValidator $unit;


   // Methode wird ausgeführt, bevor jeder Testfall ausgeführt wird
    protected function setUp(): void
    {
        // Create a validator instance und aktivieren Sie die Attributzuordnung
        // (dies ist erforderlich, um die Validierung mit Attributen zu ermöglichen)
        // in den Modellen, die Sie testen möchten.
        $validator = Validation::createValidatorBuilder()
          ->enableAttributeMapping()
          ->getValidator();
        // Set up any necessary dependencies or state before each test


        $this->unit = new ModelValidator($validator);
    }

    /**
     * @Description("Wir testen ein invalides Modell, das nicht validiert werden kann und eine Exception auslöst")   
     */
    public function testInvalidIdentifyModelFailsValidation(): void
    {
        $model = new IdentifyModel();
        $model->setProduct('');             // Invalid product
        $model->setEmail('not-an-email');   // Invalid email
        $model->setEventDate('12-12-2001'); // Invalid event date YYYY-MM-DD
        $model->setSubscriptionId('12334');
        $model->setId('some-id');

        try {
            $this->unit->validate($model);
            // Wir erwarten, dass eine Ausnahme ausgelöst wird
            // If no exception is thrown, the test should fail
            $this->fail('No exception was thrown');
        } catch (WebhookException $exception) {
            $this->assertEquals(
                'Invalid IdentifyModel properties: product, eventDate, email',
                $exception->getMessage()
            );
        }
    }

    /**
     * @Description("Alle Attribute sind gültig und wir erwarten, dass die Validierung wird erfolgreich durchgeführt wird")   
     */
    public function testValidIdentifyModelPassesValidation(): void
    {
        $model = new IdentifyModel();
        $model->setProduct('some-product');
        $model->setEmail('email@example.com');
        $model->setEventDate('2025-01-01');
        $model->setSubscriptionId('12334');
        $model->setId('some-id');

        try {
            $this->unit->validate($model);
            $this->assertTrue(true, 'No WebhookException was thrown');
        } catch (WebhookException) {
            $this->fail('Unexpected exception thrown');
        }
    }

}
