<?php

/**
 * This file is part of the ApiPlatformMakerBundle package.
 *
 * (c) Zsolt Restyanszki <rezsolt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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