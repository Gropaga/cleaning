<?php

namespace CleaningCRM\Todo\Infrastructure\Serializer;

use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;

class SerializerFactory
{
    private $cacheDir;

    private $debug;

    private $metadataDir;

    public function __construct($cacheDir, $debug, $metadataDir)
    {
        $this->cacheDir = $cacheDir;
        $this->debug = $debug;
        $this->metadataDir = $metadataDir;
    }

    public function create(): SerializerInterface
    {
        $builder = SerializerBuilder::create();

        $builder->setCacheDir($this->cacheDir)
            ->setDebug($this->debug)
            ->addMetadataDir($this->metadataDir);

        return $builder->build();
    }
}
