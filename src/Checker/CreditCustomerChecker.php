<?php

declare(strict_types=1);

namespace App\Checker;

use Sylius\Component\Core\Model\CustomerInterface;

final class CreditCustomerChecker implements CreditCustomerCheckerInterface
{
    public function check(CustomerInterface $customer): bool
    {
        if(null === $customer->getGroup()){
            return false;
        }
        $group = $customer->getGroup()->getCode();
        if (null === $group || 'CREDIT' !== $group) {
            return false;
        }
        return true;
    }
}
