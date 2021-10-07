<?php

namespace MundiPagg\MundiPagg\Controller\Adminhtml\Plans;

use MundiPagg\MundiPagg\Controller\Adminhtml\Plans\PlanAction;
use Mundipagg\Core\Recurrence\Services\PlanService;

class Delete extends PlanAction
{
    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        $productId = (int)$this->getRequest()->getParam('id');
        if ($productId) {

            $planService = new PlanService();
            $productData = $planService->findById($productId);

            if (!$productData || !$productData->getId()) {
                $message = $this->messageFactory->create('error', __('Plan not exist.'));
                $this->messageManager->addErrorMessage($message);
                $this->_redirect('mundipagg_mundipagg/plans/index');
                return;
            }
        }

        $planService->delete($productId);

        $message = $this->messageFactory->create('success', _("Plan deleted."));
        $this->messageManager->addMessage($message);

        $this->_redirect('mundipagg_mundipagg/plans/index');
        return;
    }
}
