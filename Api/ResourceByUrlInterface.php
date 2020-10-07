<?php

namespace Hendel\ResourceByUrl\Api;

interface ResourceByUrlInterface
{
    /**
     * GET product identified by its URL key
     *
     * @api
     * @param string $urlKey
     * @return Data\ResourceInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getResourceByUrl($urlKey);
}
