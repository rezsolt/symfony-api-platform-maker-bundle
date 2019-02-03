<?php

namespace Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi;

use Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi\Components\Schemas;

class Components
{
    /**
     * @var Schemas
     */
    private $schemas;

    public function __construct(
        Schemas $schemas
    ) {
        $this->schemas = $schemas;
    }

    /**
     * @return Schemas
     */
    public function getSchemas(): Schemas
    {
        return $this->schemas;
    }
}