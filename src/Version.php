<?php declare(strict_types=1);


namespace MarvinCaspar\Composer;


class Version
{
    public function __construct(
        private string $version
    )
    {
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function isDevVersion(): bool
    {
        return str_starts_with($this->version, "dev-");
    }

    public function isWildcardVersion(): bool
    {
        return str_ends_with($this->version, "*");
    }

    public function getDownloadVersion(): string
    {
        if ($this->isWildcardVersion()) {
            return "wildcard";
        }
        return $this->version;
    }
}
