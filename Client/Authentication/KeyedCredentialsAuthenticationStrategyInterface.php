<?php

namespace Maestrojosiah\Payment\PaypalBundle\Client\Authentication;

use Maestrojosiah\Payment\CoreBundle\BrowserKit\Request;

interface KeyedCredentialsAuthenticationStrategyInterface
{
    /**
     * @param Request $request
     * @param         $key
     */
    public function authenticateWithKeyedCredentials(Request $request, $key);
}
