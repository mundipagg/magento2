<?php

namespace MundiPagg\MundiPagg\Block\Adminhtml\Split\Recipients;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Recipient extends Template
{
    /**
     * @var CollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @var Registry
     */
    private $coreRegistry;

    /**
     * @param Context $context
     * @param CollectionFactory $productCollectionFactory
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        Registry $registry
    ) {
        parent::__construct($context, []);
        $this->productCollectionFactory = $productCollectionFactory;
        $this->coreRegistry = $registry;
    }
}
