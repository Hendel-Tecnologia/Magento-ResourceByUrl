<?php

namespace Hendel\ResourceByUrl\Model\Api\Data;

use Hendel\ResourceByUrl\Api\Data\ResourceInterface;
use \Magento\Catalog\Api\Data\CategoryInterface;
use \Magento\Catalog\Api\Data\ProductInterface;

class Resource implements ResourceInterface
{
    private $type;
    private $product;
    private $category;

    /**
     * @param string $type
     */
    public function __construct($type)
    {
        $this->type     = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param CategoryInterface|ProductInterface $data
     * @return void
     */
    public function setData($data)
    {
        if ($this->type == 'product')
            $this->product = $data;
        else if ($this->type == 'category')
            $this->category = $data;
    }
}
