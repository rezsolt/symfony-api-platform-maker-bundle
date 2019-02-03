<?php

namespace Rezsolt\ApiPlatformMakerBundle\Entity\OpenApi;

class Info
{
    private $title;
    private $version;

    public function __construct(
        string $title,
        string $version
    )
    {
        $this->title = $title;
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }
}