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
    public function __construct(array $resources = array(), $media = null, $config = null)
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

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function addResource($resource)
    {
        $this->resources[] = $resource;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function setMedia($media)
    {
        $this->media = $media;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function extractMedia($path)
    {
        $zip = new \ZipArchive;

        if ($zip->open($this->media) === TRUE) {

            // extract media file
            $zip->extractTo($path);
            $zip->close();
        } else {
            return false;
        }
    }
}
