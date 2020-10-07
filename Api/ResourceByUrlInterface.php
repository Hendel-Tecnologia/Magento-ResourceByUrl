<?php

namespace Hendel\ResourceByUrl\Api;

interface ResourceByUrlInterface
{
    /**
     * GET product identified by its URL key
     *
     * @api
     * @param string $urlKey
     * @return \Magento\Catalog\Api\Data\ProductInterface|\Magento\Catalog\Api\Data\Category
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getResourceByUrl($urlKey);
}
