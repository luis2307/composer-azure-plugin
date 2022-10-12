<?php declare(strict_types=1);


namespace MarvinCaspar\Composer;


class Artifact
{
    public function __construct(
        private string  $name,
        private Version $version,
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): Version
    {
        return $this->version;
    }
}
