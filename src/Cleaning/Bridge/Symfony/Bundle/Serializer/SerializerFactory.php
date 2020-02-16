<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Bridge\Symfony\Bundle\Serializer;

use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;

final class SerializerFactory
{
    private string $cacheDir;

    private bool $debug;

    private array $metadataDirs;

    public function __construct(string $cacheDir, bool $debug, array $metadataDirs)
    {
        $this->cacheDir = $cacheDir;
        $this->debug = $debug;
        $this->metadataDirs = $metadataDirs;
    }

    public function create(): SerializerInterface
    {
        $builder = SerializerBuilder::create();

        $builder->setCacheDir($this->cacheDir)
            ->setDebug($this->debug);

        $builder->addMetadataDirs($this->metadataDirs);

        return $builder->build();
    }
}
