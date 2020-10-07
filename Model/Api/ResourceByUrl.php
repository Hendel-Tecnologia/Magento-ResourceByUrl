<?php

namespace Hendel\ResourceByUrl\Model\Api;

use \Hendel\ResourceByUrl\Api\ResourceByUrlInterface;
use \Hendel\ResourceByUrl\Model\Api\Data\Resource;

class ResourceByUrl implements ResourceByUrlInterface
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var Magento\Catalog\Api\CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var Magento\Framework\App\ResourceConnection
     */
    protected $resource;

    public function __construct(
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceByUrl($urlKey)
    {
        $connection = $this->resource->getConnection();

        $select = $connection->select()
            ->from(['r' => 'url_rewrite'], ['entity_type', 'entity_id'])
            ->where('r.request_path=?', $urlKey);

        $result = $connection->fetchRow($select);

        $resources = [
            'product' => function () use ($result) {
                return $this->productRepository->getById($result['entity_id'], 0);
            },
            'category' => function () use ($result) {
                return $this->categoryRepository->get($result['entity_id']);
            }
        ];

        if (!$result || !in_array($result['entity_type'], array_keys($resources))) {
            throw new \Magento\Framework\Exception\NoSuchEntityException();
        }

        $resource = new Resource($result['entity_type']);
        $resource->setData($resources[$result['entity_type']]());

        return $resource;
    }
}
