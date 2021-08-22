<?php

declare(strict_types=1);

namespace App\Listener;

use App\Checker\CreditCustomerCheckerInterface;
use Doctrine\ORM\EntityManager;
use SM\Factory\FactoryInterface;
use Sylius\Bundle\PaymentBundle\Doctrine\ORM\PaymentMethodRepository;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\OrderCheckoutTransitions;
use Symfony\Component\EventDispatcher\GenericEvent;

final class CreditOrderListener
{
    /** @var CreditCustomerCheckerInterface */
    private $creditCustomerChecker;

    /** @var FactoryInterface */
    private $stateMachineFactory;

    /** @var PaymentMethodRepository */
    private $payment;

    /** @var \Doctrine\ORM\EntityManager */
    private $manager;

    public function __construct(
        CreditCustomerCheckerInterface $creditCustomerChecker,
        FactoryInterface               $stateMachineFactory,
        PaymentMethodRepository        $payment,
        EntityManager                  $manager)
    {
        $this->creditCustomerChecker = $creditCustomerChecker;
        $this->stateMachineFactory = $stateMachineFactory;
        $this->payment = $payment;
        $this->manager = $manager;
    }

    public function acceptForCreditCustomerGroup(GenericEvent $event)
    {
        /** @var OrderInterface $order */
        $order = $event->getSubject();

        /** @var CustomerInterface $customer */
        $customer = $order->getCustomer();

        if (!$this->creditCustomerChecker->check($customer)) {
            return;
        }

        $paymentMethod = $this->payment->findOneBy(['code' => 'bank_transfer']);
        foreach ($order->getPayments() as $payment) {
            $payment->setMethod($paymentMethod);
        }
        $stateMachine = $this->stateMachineFactory->get($order, OrderCheckoutTransitions::GRAPH);
        $stateMachine->apply(OrderCheckoutTransitions::TRANSITION_SELECT_PAYMENT);
        $this->manager->flush();
        return;
    }
}
