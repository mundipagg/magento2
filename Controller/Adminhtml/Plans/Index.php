<?php

namespace MundiPagg\MundiPagg\Controller\Adminhtml\Plans;

use MundiPagg\MundiPagg\Controller\Adminhtml\Plans\PlanAction;

class Index extends PlanAction
{
    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__("Plans"));

        return $resultPage;
    }
}
