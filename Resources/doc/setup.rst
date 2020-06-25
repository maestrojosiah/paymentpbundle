Setup
=====

Requirements
------------
This plugin depends on MaestrojosiahPaymentCoreBundle_ so you'll need to setup it up first. Please follow its `setup instructions`_ and come back to this document once you're done.

.. _MaestrojosiahPaymentCoreBundle: http://maestrojosiahpaymentcorebundle.readthedocs.io
.. _setup instructions: http://maestrojosiahpaymentcorebundle.readthedocs.io/en/stable/setup.html

Installation
-------------
Install with composer:

.. code-block :: bash

    composer require maestrojosiah/payment-paypal-bundle

And register the bundle in your ``AppKernel.php``:

.. code-block :: php

    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Maestrojosiah\Payment\CoreBundle\MaestrojosiahPaymentCoreBundle(),
            new Maestrojosiah\Payment\PaypalBundle\MaestrojosiahPaymentPaypalBundle(),
        );
    }

Configuration
-------------
You need to supply at least the following configuration. See `PayPal's documentation`_ (*Create an API signature* section) for information on how to obtain the credentials.

.. _PayPal's documentation: https://developer.paypal.com/docs/classic/api/apiCredentials/

.. code-block :: yaml

    # app/config/config.yml

    maestrojosiah_payment_paypal:
        username: your_api_username # not your account username
        password: your_api_password # not your account password
        signature: your_api_signature

.. tip ::

    See :ref:`usage-available-options` for information on all configuration options.
