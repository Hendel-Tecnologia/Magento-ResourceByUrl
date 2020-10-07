<?php

namespace Hendel\ResourceBy\Model\Api;

class ResourceByUrl implements \Hendel\ResourceByUrl\Api\ResourceByUrlInterface
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
                return $this->productRepository->getById($result['entity_id']);
            },
            'category' => function () use ($result) {
                return $this->categoryRepository->get($result['entity_id']);
            }
        ];

        if (!$result || !in_array($result['entity_type'], array_keys($resources))) {
            throw new \Magento\Framework\Exception\NoSuchEntityException();
        }

        return $resources[$result['entity_type']]();
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceById($id)
    {
        return $this->productRepository->getById($id);
    }
}
