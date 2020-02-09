<?php

namespace CleaningCRM\Common\Infrastructure\Serializer;

use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;

class SerializerFactory
{
    private string $cacheDir;

    private string $debug;

    private array $metadataDir;

    public function __construct(string $cacheDir, string $debug, array $metadataDir)
    {
        $this->cacheDir = $cacheDir;
        $this->debug = $debug;
        $this->metadataDir = $metadataDir;
    }

    public function create(): SerializerInterface
    {
        $builder = SerializerBuilder::create();

        $builder->setCacheDir($this->cacheDir)
            ->setDebug($this->debug);

        foreach ($this->metadataDir as $dir) {
            $builder->addMetadataDir($dir);
        }

        return $builder->build();
    }
}
