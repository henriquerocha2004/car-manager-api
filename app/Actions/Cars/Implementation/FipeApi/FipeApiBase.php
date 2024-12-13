<?php

namespace App\Actions\Cars\Implementation\FipeApi;

use DeividFortuna\Fipe\IFipe;

abstract class FipeApiBase
{
    protected int $quantityRequestAllowed = 800;

    public function __construct()
    {
        $this->setup();
    }

    public function setup(): void
    {
        $token = env('FIPE_TOKEN');
        IFipe::setCurlOptions([
            CURLOPT_HTTPHEADER => ["X-Subscription-Token: {$token}"],
        ]);
    }
}
