<?php
namespace App\Payments;

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Resources\Preference;

class MercadoPagoPayment
{
    protected string $mpAccessToken;
    protected string $mpPublicKey;

    protected array $items = [];
    protected array $backUrls = [];
    protected bool $autoReturn = false;

    public function __construct()
    {
        // Levantamos las claves del config().
        $this->mpAccessToken = config('mercadopago.access_token');
        $this->mpPublicKey = config('mercadopago.public_key');

        if(strlen($this->mpAccessToken) == 0) {
            throw new \Exception("No está configurada el token de acceso. Revisá el archivo [config/mercadopago.php] o la clave MERCADOPAGO_ACCESS_TOKEN en el [.env].");
        }
        if(strlen($this->mpPublicKey) == 0) {
            throw new \Exception("No está configurada la clave pública. Revisá el archivo [config/mercadopago.php] o la clave MERCADOPAGO_PUBLIC_KEY en el [.env].");
        }

        // Inicializamos la API de MercadoPago.
        MercadoPagoConfig::setAccessToken($this->mpAccessToken);
    }

    public function getPublicKey(): string
    {
        return $this->mpPublicKey;
    }

    /**
     * Cada ítem del array debe ser un array que tenga las siguientes claves:
     * - title: El nombre del ítem.
     * - unit_price
     * - quantity
     */
    public function setItems(array $items)
    {
        $this->items = $items;
    }

    public function setBackURLs(?string $success = null, ?string $pending = null, ?string $failure = null)
    {
        if(is_string($success)) $this->backUrls['success'] = $success;
        if(is_string($pending)) $this->backUrls['pending'] = $pending;
        if(is_string($failure)) $this->backUrls['failure'] = $failure;
    }

    public function withAutoReturn()
    {
        $this->autoReturn = true;
    }

    public function getPreference(): Preference
    {
        if(count($this->items) == 0) {
            throw new \Exception("Es obligatorio definir los 'items' a cobrar.");
        }

        $config = [];

        $config['items'] = $this->items;
        if(count($this->backUrls) > 0) {
            $config['back_urls'] = $this->backUrls;
            if($this->autoReturn) $config['auto_return'] = "approved";
        }

        $factory = new PreferenceClient();
        return $factory->create($config);
    }
}
