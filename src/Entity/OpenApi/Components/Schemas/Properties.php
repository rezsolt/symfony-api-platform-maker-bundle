<?php

namespace Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi\Components\Schemas;

use Rezsolt\ApiPlatformMakerBundle\Entity\CollectionInterface;
use Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi\Components\Schemas\Properties\Property;

class Properties extends \ArrayIterator implements CollectionInterface
{
    /**
     * Properties constructor.
     *
     * @param Property[] $array
     * @param int $flags
     */
    public function __construct(
        array $array = [],
        int $flags = 0
    ) {
        parent::__construct($array, $flags);
    }

}