<?php


namespace MundiPagg\MundiPagg\Model\ResourceModel;

class Recipients extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('mundipagg_module_core_split_recipient', 'id');
    }
}
