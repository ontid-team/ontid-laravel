<?php

namespace App\Services\Auth\Dto;

use App\Services\Auth\Enum\Provider;

class ProviderDto
{
    public int $identity;
    public Provider $provider;

    /**
     * @param int $identity
     * @param Provider $provider
     */
    public function __construct(int $identity, Provider $provider)
    {
        $this->identity = $identity;
        $this->provider = $provider;
    }
}
