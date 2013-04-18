<?php

namespace Raindrop\ImportBundle\Zip;

/**
 * Zip Class that represent the import datas.
 */
class Zip implements ZipInterface
{
    /**
     * Constructor.
     *
     * @param string $resources The file to be imported
     * @param string $media     The zip that contains media files
     * @param string $config    The configuration file (YAML)
     *
     * @api
     */
    public function __construct(array $resources, $media, $config = null)
    {
        $this->resources = $resources;
        $this->media = $media;
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function getMedia()
    {
        return $this->media;
    }
}
