<?php

namespace MundiPagg\MundiPagg\Concrete;

use Mundipagg\Core\Kernel\Abstractions\AbstractDatabaseDecorator;

final class Magento2DatabaseDecorator extends AbstractDatabaseDecorator
{
    protected function setTableArray()
    {
        $this->tableArray = [
            AbstractDatabaseDecorator::TABLE_MODULE_CONFIGURATION =>
                $this->db->getTableName('mundipagg_module_core_configuration'),

            AbstractDatabaseDecorator::TABLE_WEBHOOK =>
                $this->db->getTableName('mundipagg_module_core_webhook'),

            AbstractDatabaseDecorator::TABLE_ORDER =>
                $this->db->getTableName('mundipagg_module_core_order'),

            AbstractDatabaseDecorator::TABLE_CHARGE =>
                $this->db->getTableName('mundipagg_module_core_charge'),

            AbstractDatabaseDecorator::TABLE_TRANSACTION =>
                $this->db->getTableName('mundipagg_module_core_transaction'),

            AbstractDatabaseDecorator::TABLE_SAVED_CARD =>
                $this->db->getTableName('mundipagg_module_core_saved_card'),

            AbstractDatabaseDecorator::TABLE_CUSTOMER =>
                $this->db->getTableName('mundipagg_module_core_customer'),

            AbstractDatabaseDecorator::TABLE_RECURRENCE_PRODUCTS_PLAN =>
                $this->db->getTableName('mundipagg_module_core_recurrence_products_plan'),

            AbstractDatabaseDecorator::TABLE_RECURRENCE_PRODUCTS_SUBSCRIPTION =>
                $this->db->getTableName('mundipagg_module_core_recurrence_products_subscription'),

            AbstractDatabaseDecorator::TABLE_RECURRENCE_SUB_PRODUCTS=>
                $this->db->getTableName('mundipagg_module_core_recurrence_sub_products'),

            AbstractDatabaseDecorator::TABLE_RECURRENCE_CHARGE =>
                $this->db->getTableName('mundipagg_module_core_recurrence_charge'),

            AbstractDatabaseDecorator::TABLE_RECURRENCE_SUBSCRIPTION =>
                $this->db->getTableName('mundipagg_module_core_recurrence_subscription'),

            AbstractDatabaseDecorator::TABLE_RECURRENCE_SUBSCRIPTION_REPETITIONS =>
                $this->db->getTableName('mundipagg_module_core_recurrence_subscription_repetitions'),

            AbstractDatabaseDecorator::TABLE_RECURRENCE_SUBSCRIPTION_ITEM =>
                $this->db->getTableName('mundipagg_module_core_recurrence_subscription_items'),

            AbstractDatabaseDecorator::TABLE_SPLIT_RECIPIENT =>
                $this->db->getTableName('mundipagg_module_core_split_recipient'),

            AbstractDatabaseDecorator::TABLE_SPLIT_RECIPIENT_BANK_ACCOUNT =>
                $this->db->getTableName('mundipagg_module_core_split_recipient_bank_account'),

            AbstractDatabaseDecorator::TABLE_SPLIT_TRANSFER_SETTING =>
                $this->db->getTableName('mundipagg_module_core_split_recipient_transfer_settings')
        ];
    }

    protected function doQuery($query)
    {
        $connection = $this->db->getConnection();
        $connection->query($query);
        $this->setLastInsertId($connection->lastInsertId());
    }

    protected function formatResults($queryResult)
    {
        $retn = new \stdClass;
        $retn->num_rows = count($queryResult);
        $retn->row = array();
        if (!empty($queryResult)) {
            $retn->row = $queryResult[0];
        }
        $retn->rows = $queryResult;
        return $retn;
    }

    protected function doFetch($query)
    {
        $connection = $this->db->getConnection();

        return $connection->fetchAll($query);
    }

    public function getLastId()
    {
        return $this->db->lastInsertId;
    }

    protected function setTablePrefix()
    {
        //Magento2 getTableName method already retrieves the table with the prefix.
        $this->tablePrefix = '';
    }

    protected function setLastInsertId($lastInsertId)
    {
        $this->db->lastInsertId = $lastInsertId;
    }
}