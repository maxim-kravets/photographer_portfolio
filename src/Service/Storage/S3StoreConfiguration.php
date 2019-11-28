<?php

namespace App\Service\Storage;


class S3StoreConfiguration
{
    private $version;
    private $region;
    private $base_url;
    private $bucket;
    private $access_key;
    private $secret_key;

    public function __construct(
        string $version,
        string $region,
        string $base_url,
        string $bucket,
        string $access_key,
        string $secret_key
    ) {
        $this->version = $version;
        $this->region = $region;
        $this->base_url = $base_url;
        $this->bucket = $bucket;
        $this->access_key = $access_key;
        $this->secret_key = $secret_key;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function getBaseUrl(): string
    {
        return $this->base_url;
    }

    public function getBucket(): string
    {
        return $this->bucket;
    }

    public function getAccessKey(): string
    {
        return $this->access_key;
    }

    public function getSecretKey(): string
    {
        return $this->secret_key;
    }

}
