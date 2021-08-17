<?php

declare(strict_types=1);

namespace App\Context;

use App\Geolocation\UserGeolocationInterface as UserGeolocationInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;

final class LocaleChannelContext implements ChannelContextInterface
{
    /** @var ChannelRepositoryInterface */
    private $channelRepository;

    /** @var UserGeolocationInterface */
    private $userGeolocation;

    public function __construct(ChannelRepositoryInterface $channelRepository, UserGeolocationInterface $userGeolocation)
    {
        $this->channelRepository = $channelRepository;
        $this->userGeolocation = $userGeolocation;
    }


    public function getChannel(): ChannelInterface
    {

        if ('pl-PL' === $this->userGeolocation->getLocation()) {
            return $this->channelRepository->findOneByCode('LOOKAS');
        }

        return $this->channelRepository->findOneByCode('FASHION_WEB');
    }
}
