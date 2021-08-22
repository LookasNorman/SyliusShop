<?php

declare(strict_types=1);

namespace App\Checker;

use Sylius\Component\Core\Model\CustomerInterface;

interface CreditCustomerCheckerInterface
{
    public function check(CustomerInterface $customer): bool;
}
