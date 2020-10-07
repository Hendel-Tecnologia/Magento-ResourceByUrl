<?php

namespace Hendel\ResourceByUrl\Api\Data;

interface ResourceInterface
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    public function getProduct();

    /**
     * @return \Magento\Catalog\Api\Data\CategoryInterface
     */
    public function getCategory();
}
