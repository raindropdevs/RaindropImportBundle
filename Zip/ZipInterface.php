<?php

namespace Raindrop\ImportBundle\Zip;

/**
 * ZipInterface
 */
interface ZipInterface
{
    /**
     * Gets the file resources to be imported.
     *
     * @return string The array of resource's paths
     *
     * @api
     */
    public function getResources();

    /**
     * Gets the file config used to drive the import flow.
     *
     * @return string The path to the config file
     *
     * @api
     */
    public function getConfig();

    /**
     * Gets the zip file containing the media.
     *
     * @return string The path to the zip file
     *
     * @api
     */
    public function getMedia();

    /**
     * Adds a resource file.
     *
     * @param string The path to the resource file
     *
     * @api
     */
    public function addResource($resource);

    /**
     * Set a config file.
     *
     * @param string The path to the config file
     *
     * @api
     */
    public function setConfig($config);

    /**
     * Set a media file zip.
     *
     * @param string The path to the media file zip
     *
     * @api
     */
    public function setMedia($media);

    /**
     * Extracts a media file zip.
     *
     * @api
     */
    public function extractMedia();
}
