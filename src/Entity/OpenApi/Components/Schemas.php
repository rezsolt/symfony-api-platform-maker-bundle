<?php

namespace Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi\Components;

use Rezsolt\ApiPlatformMakerBundle\Entity\CollectionInterface;
use Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi\Components\Schemas\Schema;

class Schemas extends \ArrayIterator implements CollectionInterface
{
    /**
     * Schemas constructor.
     *
     * @param Schema[] $array
     * @param int $flags
     */
    public function __construct(
        array $array = [],
        int $flags = 0
    ) {
        parent::__construct($array, $flags);
    }
}