<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Product as BaseProduct;
use Sylius\Component\Product\Model\ProductTranslationInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product")
 */
class Product extends BaseProduct
{
    public const PRODUCT_COLOR = [
        'red' => 'red',
        'blue' => 'blue',
        'green' => 'green'
    ];

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $color;

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor($color): void
    {
        $this->color = $color;
    }

    static public function getProductColor()
    {
        return self::PRODUCT_COLOR;
    }

    protected function createTranslation(): ProductTranslationInterface
    {
        return new ProductTranslation();
    }
}
