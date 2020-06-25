<?php

namespace Maestrojosiah\Payment\PaypalBundle\Tests\Functional\Plugin;

use Maestrojosiah\Payment\CoreBundle\Entity\ExtendedData;
use Maestrojosiah\Payment\CoreBundle\Entity\FinancialTransaction;
use Maestrojosiah\Payment\CoreBundle\Entity\Payment;
use Maestrojosiah\Payment\CoreBundle\Entity\PaymentInstruction;
use Maestrojosiah\Payment\CoreBundle\Plugin\Exception\ActionRequiredException;
use Maestrojosiah\Payment\PaypalBundle\Plugin\ExpressCheckoutPlugin;
use Maestrojosiah\Payment\PaypalBundle\Tests\Functional\FunctionalTest;

class ExpressCheckoutPluginTest extends FunctionalTest
{
    public function testApproveNoUserActionByDefault()
    {
        $plugin = new ExpressCheckoutPlugin(
            'http://example.com',
            'http://example.com',
            $this->getClient()
        );

        $transaction = $this->getTransaction();

        try {
            $plugin->approve($transaction, $retry = false);
        } catch (ActionRequiredException $ex) {
            $action = $ex->getAction();
            $this->assertInstanceOf('Maestrojosiah\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl', $action);
            $this->assertNotContains('useraction', $action->getUrl());
        }
    }

    public function testApproveWithUserAction()
    {
        $plugin = new ExpressCheckoutPlugin(
            'http://example.com',
            'http://example.com',
            $this->getClient(),
            null,
            'commit'
        );

        $transaction = $this->getTransaction();

        try {
            $plugin->approve($transaction, $retry = false);
        } catch (ActionRequiredException $ex) {
            $action = $ex->getAction();
            $this->assertInstanceOf('Maestrojosiah\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl', $action);
            $this->assertContains('useraction=commit', $action->getUrl());
        }
    }

    public function testApproveWithUserActionInExtendedData()
    {
        $plugin = new ExpressCheckoutPlugin(
            'http://example.com',
            'http://example.com',
            $this->getClient()
        );

        $transaction = $this->getTransaction();
        $transaction->getExtendedData()->set('useraction', 'commit');

        try {
            $plugin->approve($transaction, $retry = false);
        } catch (ActionRequiredException $ex) {
            $action = $ex->getAction();
            $this->assertInstanceOf('Maestrojosiah\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl', $action);
            $this->assertContains('useraction=commit', $action->getUrl());
        }
    }

    private function getTransaction()
    {
        $amount = 123.45;
        $instruction = new PaymentInstruction($amount, 'EUR', 'foo', new ExtendedData());
        $payment = new Payment($instruction, $amount);

        $transaction = new FinancialTransaction();
        $transaction->setPayment($payment);
        $transaction->setRequestedAmount($amount);

        return $transaction;
    }
}
