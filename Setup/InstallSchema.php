<?php


namespace MundiPagg\MundiPagg\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        $version = $context->getVersion();

        $this->installConfig($setup);
        $this->installWebhook($setup);
        $this->installOrder($setup);
        $this->installCharge($setup);
        $this->installTransaction($setup);
        $this->installSavedCard($setup);
        $this->installCustomer($setup);
//        $this->installProductsSubscription($setup);
//        $this->installSubscriptionRepetitions($setup);
//        $this->installRecurrenceSubscription($setup);
//        $this->installRecurrenceCharge($setup);
//        $this->installSubProducts($setup);
//        $this->installProductsPlan($setup);

        $setup->endSetup();
    }

    public function installConfig(
        SchemaSetupInterface $installer
    ) {
        $tableName = $installer->getTable('mundipagg_module_core_configuration');
        if (!$installer->getConnection()->isTableExists($tableName)) {
            $configTable = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'data',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    'data'
                )
                ->setComment('Configuration Table')
                ->setOption('charset', 'utf8');

            $installer->getConnection()->createTable($configTable);
        }
        return $installer;
    }

    public function installWebhook(
        SchemaSetupInterface $installer
    ) {
        $tableName = $installer->getTable('mundipagg_module_core_webhook');
        if (!$installer->getConnection()->isTableExists($tableName)) {
            $webhookTable = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'mundipagg_id',
                    Table::TYPE_TEXT,
                    21,
                    [
                        'nullable' => false
                    ],
                    'format: hook_xxxxxxxxxxxxxxxx'
                )
                ->addColumn(
                    'handled_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    [
                        'nullable' => false,
                        'default' => Table::TIMESTAMP_INIT
                    ],
                    'When the webhook was handled.'
                )
                ->setComment('Webhook Table')
                ->setOption('charset', 'utf8');

            $installer->getConnection()->createTable($webhookTable);
        }
        return $installer;
    }

    public function installOrder(
        SchemaSetupInterface $installer
    ) {
        $tableName = $installer->getTable('mundipagg_module_core_order');
        if (!$installer->getConnection()->isTableExists($tableName)) {
            $webhookTable = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'mundipagg_id',
                    Table::TYPE_TEXT,
                    19,
                    [
                        'nullable' => false
                    ],
                    'format: or_xxxxxxxxxxxxxxxx'
                )
                ->addColumn(
                    'code',
                    Table::TYPE_TEXT,
                    100,
                    [
                        'nullable' => false,
                    ],
                    'Code'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_TEXT,
                    30,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Status'
                )
                ->setComment('Order Table')
                ->setOption('charset', 'utf8');

            $installer->getConnection()->createTable($webhookTable);
        }
        return $installer;
    }

    public function installCharge(
        SchemaSetupInterface $installer
    ) {
        $tableName = $installer->getTable('mundipagg_module_core_charge');
        if (!$installer->getConnection()->isTableExists($tableName)) {
            $webhookTable = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'mundipagg_id',
                    Table::TYPE_TEXT,
                    19,
                    [
                        'nullable' => false
                    ],
                    'format: ch_xxxxxxxxxxxxxxxx'
                )
                ->addColumn(
                    'order_id',
                    Table::TYPE_TEXT,
                    19,
                    [
                        'nullable' => false
                    ],
                    'format: or_xxxxxxxxxxxxxxxx'
                )
                ->addColumn(
                    'code',
                    Table::TYPE_TEXT,
                    100,
                    [
                        'nullable' => false,
                    ],
                    'Code'
                )
                ->addColumn(
                    'amount',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'amount'
                )
                ->addColumn(
                    'paid_amount',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Paid Amount'
                )
                ->addColumn(
                    'canceled_amount',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Canceled Amount'
                )
                ->addColumn(
                    'refunded_amount',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Refunded Amount'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_TEXT,
                    30,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Status'
                )
                ->setComment('Charge Table')
                ->setOption('charset', 'utf8');

            $installer->getConnection()->createTable($webhookTable);
        }
        return $installer;
    }

    public function installTransaction(
        SchemaSetupInterface $installer
    ) {
        $tableName = $installer->getTable('mundipagg_module_core_transaction');
        if (!$installer->getConnection()->isTableExists($tableName)) {
            $webhookTable = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'mundipagg_id',
                    Table::TYPE_TEXT,
                    21,
                    [
                        'nullable' => false
                    ],
                    'format: tran_xxxxxxxxxxxxxxxx'
                )
                ->addColumn(
                    'charge_id',
                    Table::TYPE_TEXT,
                    19,
                    [
                        'nullable' => false
                    ],
                    'format: ch_xxxxxxxxxxxxxxxx'
                )
                ->addColumn(
                    'amount',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'amount'
                )
                ->addColumn(
                    'paid_amount',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'paid amount'
                )
                ->addColumn(
                    'acquirer_tid',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'acquirer tid'
                )
                ->addColumn(
                    'acquirer_nsu',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'acquirer nsu'
                )
                ->addColumn(
                    'acquirer_auth_code',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'acquirer auth code'
                )
                ->addColumn(
                    'acquirer_name',
                    Table::TYPE_TEXT,
                    300,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Type'
                )
                ->addColumn(
                    'acquirer_message',
                    Table::TYPE_TEXT,
                    300,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Type'
                )
                ->addColumn(
                    'type',
                    Table::TYPE_TEXT,
                    30,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Type'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_TEXT,
                    30,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Status'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_DATETIME,
                    null,
                    [

                        'nullable' => false,
                    ],
                    'Created At'
                )
                ->setComment('Transaction Table')
                ->setOption('charset', 'utf8');

            $installer->getConnection()->createTable($webhookTable);
        }
        return $installer;
    }

    public function installSavedCard(SchemaSetupInterface $installer)
    {
        $tableName = $installer->getTable('mundipagg_module_core_saved_card');
        if (!$installer->getConnection()->isTableExists($tableName)) {
            $savedCardTable = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'mundipagg_id',
                    Table::TYPE_TEXT,
                    21,
                    [
                        'nullable' => false
                    ],
                    'format: card_xxxxxxxxxxxxxxxx'
                )
                ->addColumn(
                    'owner_id',
                    Table::TYPE_TEXT,
                    21,
                    [
                        'nullable' => false
                    ],
                    'format: cus_xxxxxxxxxxxxxxxx'
                )
                ->addColumn(
                    'first_six_digits',
                    Table::TYPE_TEXT,
                    6,
                    [
                        'nullable' => false
                    ],
                    'card first six digits'
                )
                ->addColumn(
                    'last_four_digits',
                    Table::TYPE_TEXT,
                    4,
                    [
                        'nullable' => false
                    ],
                    'card last four digits'
                )
                ->addColumn(
                    'brand',
                    Table::TYPE_TEXT,
                    30,
                    [
                        'nullable' => false
                    ],
                    'card brand'
                )
                ->setComment('Saved Card Table')
                ->setOption('charset', 'utf8');

            $installer->getConnection()->createTable($savedCardTable);
        }
        return $installer;
    }

    public function installCustomer(SchemaSetupInterface $installer)
    {
        $tableName = $installer->getTable('mundipagg_module_core_customer');
        if (!$installer->getConnection()->isTableExists($tableName)) {
            $customer = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'code',
                    Table::TYPE_TEXT,
                    100,
                    [
                        'nullable' => false
                    ],
                    'platform customer id'
                )
                ->addColumn(
                    'mundipagg_id',
                    Table::TYPE_TEXT,
                    20,
                    [
                        'nullable' => false
                    ],
                    'format: cus_xxxxxxxxxxxxxxxx'
                )
                ->setComment('Customer Table')
                ->setOption('charset', 'utf8');

            $installer->getConnection()->createTable($customer);
        }
        return $installer;
    }

    public function installProductsPlan(SchemaSetupInterface $installer)
    {
        $tableName = $installer->getTable('mundipagg_module_core_recurrence_products_plan');
        if (!$installer->getConnection()->isTableExists($tableName)) {
            $customer = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'interval_type',
                    Table::TYPE_TEXT,
                    15,
                    [
                        'nullable' => false
                    ],
                    'Day, week, month ou year'
                )
                ->addColumn(
                    'interval_count',
                    Table::TYPE_SMALLINT,
                    2,
                    [
                        'nullable' => false
                    ],
                    '1 - 12'
                )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    [
                        'nullable' => true
                    ],
                    "Product name"
                )
                ->addColumn(
                    'description',
                    Table::TYPE_TEXT,
                    500,
                    [
                        'nullable' => true
                    ],
                    "Product description"
                )
                ->addColumn(
                    'plan_id',
                    Table::TYPE_TEXT,
                    21,
                    [
                        'nullable' => true
                    ],
                    "Api's id"
                )
                ->addColumn(
                    'product_id',
                    Table::TYPE_INTEGER,
                    11,
                    [
                        'nullable' => true
                    ],
                    "Product in Magento's table"
                )
                ->addColumn(
                    'credit_card',
                    Table::TYPE_TEXT,
                    1,
                    [
                        'nullable' => false
                    ],
                    "Accepts credit card"
                )
                ->addColumn(
                    'installments',
                    Table::TYPE_TEXT,
                    1,
                    [
                        'nullable' => false
                    ],
                    "Accepts installments"
                )
                ->addColumn(
                    'boleto',
                    Table::TYPE_TEXT,
                    1,
                    [
                        'nullable' => false
                    ],
                    "Accepts boleto"
                )
                ->addColumn(
                    'billing_type',
                    Table::TYPE_TEXT,
                    11,
                    [
                        'nullable' => false
                    ],
                    "Prepaid, postpaid ou exact_day"
                )
                ->addColumn(
                    'status',
                    Table::TYPE_TEXT,
                    11,
                    [
                        'nullable' => false
                    ],
                    "Active, inactive ou deleted"
                )
                ->addColumn(
                    'trial_period_days',
                    Table::TYPE_TEXT,
                    11,
                    [
                        'nullable' => true
                    ],
                    "Trial period in days"
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At'
                )
                ->setOption('charset', 'utf8');

            $installer->getConnection()->createTable($customer);
        }
        return $installer;
    }

    public function installSubProducts(SchemaSetupInterface $installer)
    {
        $tableName = $installer->getTable('mundipagg_module_core_recurrence_sub_products');
        if (!$installer->getConnection()->isTableExists($tableName)) {
            $customer = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'product_id',
                    Table::TYPE_INTEGER,
                    255,
                    [
                        'nullable' => false
                    ],
                    "Magento's product id"
                )
                ->addColumn(
                    'product_recurrence_id',
                    Table::TYPE_INTEGER,
                    255,
                    [
                        'nullable' => false
                    ],
                    'Id from table mundipagg_module_core_products_(plan/subscription)'
                )
                ->addColumn(
                    'recurrence_type',
                    Table::TYPE_TEXT,
                    255,
                    [
                        'nullable' => false
                    ],
                    'Type of recurrence product (plan or subscription)'
                )
                ->addColumn(
                    'cycles',
                    Table::TYPE_INTEGER,
                    5,
                    [
                        'nullable' => true
                    ],
                    'Cycle'
                )
                ->addColumn(
                    'quantity',
                    Table::TYPE_INTEGER,
                    255,
                    [
                        'nullable' => true
                    ],
                    "Quantity"
                )
                ->addColumn(
                    'trial_period_days',
                    Table::TYPE_INTEGER,
                    255,
                    [
                        'nullable' => true
                    ],
                    "Trial period"
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At'
                )
                ->setOption('charset', 'utf8');

            $installer->getConnection()->createTable($customer);
        }
        return $installer;
    }

    public function installProductsSubscription(SchemaSetupInterface $installer)
    {
        $tableName = $installer->getTable('mundipagg_module_core_recurrence_products_subscription');
        if (!$installer->getConnection()->isTableExists($tableName)) {
            $customer = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'product_id',
                    Table::TYPE_INTEGER,
                    11,
                    [
                        'nullable' => true
                    ],
                    "Product in Magento's table"
                )
                ->addColumn(
                    'credit_card',
                    Table::TYPE_TEXT,
                    1,
                    [
                        'nullable' => false
                    ],
                    "Accepts credit card"
                )
                ->addColumn(
                    'allow_installments',
                    Table::TYPE_TEXT,
                    1,
                    [
                        'nullable' => false
                    ],
                    "Accepts installments"
                )
                ->addColumn(
                    'boleto',
                    Table::TYPE_TEXT,
                    1,
                    [
                        'nullable' => false
                    ],
                    "Accepts boleto"
                )
                ->addColumn(
                    'sell_as_normal_product',
                    Table::TYPE_TEXT,
                    1,
                    [
                        'nullable' => false
                    ],
                    "Allow sell as normal product"
                )
                ->addColumn(
                    'billing_type',
                    Table::TYPE_TEXT,
                    11,
                    [
                        'nullable' => false
                    ],
                    "Prepaid, postpaid ou exact_day"
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At'
                )
                ->setComment('Product Plan Table')
                ->setOption('charset', 'utf8');

            $installer->getConnection()->createTable($customer);
        }
        return $installer;
    }

    public function installSubscriptionRepetitions(SchemaSetupInterface $installer)
    {
        $tableName = $installer->getTable('mundipagg_module_core_recurrence_subscription_repetitions');
        if (!$installer->getConnection()->isTableExists($tableName)) {
            $configTable = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'subscription_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable' => false
                    ],
                    'Id from mundipagg_module_core_products_subscription'
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'interval',
                    Table::TYPE_TEXT,
                    15,
                    [
                        'nullable' => false
                    ],
                    'Day, week, month ou year'
                )
                ->addColumn(
                    'interval_count',
                    Table::TYPE_SMALLINT,
                    2,
                    [
                        'nullable' => false
                    ],
                    '1 - 12'
                )
                ->addColumn(
                    'recurrence_price',
                    Table::TYPE_INTEGER,
                    15,
                    [
                        'nullable' => true
                    ],
                    'Recurrence product price'
                )
                ->addColumn(
                    'cycles',
                    Table::TYPE_INTEGER,
                    15,
                    [
                        'nullable' => true
                    ],
                    'Cycles'
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At'
                )
                ->setOption('charset', 'utf8');

            $installer->getConnection()->createTable($configTable);
        }
        return $installer;
    }

    public function installRecurrenceSubscription(SchemaSetupInterface $installer)
    {
        $tableName = $installer->getTable(
            'mundipagg_module_core_recurrence_subscription'
        );

        if (!$installer->getConnection()->isTableExists($tableName)) {
            $configTable = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'customer_id',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    'Customer id'
                )
                ->addColumn(
                    'mundipagg_id',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    'format: sub_xxxxxxxxxxxxxxxx'
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'code',
                    Table::TYPE_TEXT,
                    100,
                    [
                        'nullable' => false,
                    ],
                    'Code'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_TEXT,
                    30,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Status'
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'installments',
                    Table::TYPE_BOOLEAN,
                    11,
                    [
                        'nullable' => false
                    ],
                    "Accepts installments"
                )
                ->addColumn(
                    'payment_method',
                    Table::TYPE_TEXT,
                    30,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Payment method'
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'recurrence_type',
                    Table::TYPE_TEXT,
                    30,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'recurrence or plan'
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'interval_type',
                    Table::TYPE_TEXT,
                    30,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Available values: day, month, week or year'
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'interval_count',
                    Table::TYPE_SMALLINT,
                    2,
                    [
                        'nullable' => false
                    ],
                    '1 - 12'
                )
                ->addColumn(
                    'plan_id',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => true
                    ],
                    "Api's id"
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At'
                )
                ->setOption('charset', 'utf8');

            $installer->getConnection()->createTable($configTable);
        }
        return $installer;
    }

    public function installRecurrenceCharge(SchemaSetupInterface $installer)
    {
        $tableName = $installer->getTable(
            'mundipagg_module_core_recurrence_charge'
        );

        if (!$installer->getConnection()->isTableExists($tableName)) {
            $configTable = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'mundipagg_id',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    'format: ch_xxxxxxxxxxxxxxxx'
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'subscription_id',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    'format: sub_xxxxxxxxxxxxxxxx'
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'code',
                    Table::TYPE_TEXT,
                    100,
                    [
                        'nullable' => false,
                    ],
                    'Code'
                )
                ->addColumn(
                    'amount',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'amount'
                )
                ->addColumn(
                    'paid_amount',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Paid Amount'
                )
                ->addColumn(
                    'canceled_amount',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Canceled Amount'
                )
                ->addColumn(
                    'refunded_amount',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Refunded Amount'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_TEXT,
                    30,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Status'
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'metadata',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Metadata'
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'invoice_id',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    'format: in_xxxxxxxxxxxxxxxx'
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'payment_method',
                    Table::TYPE_TEXT,
                    30,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Payment method'
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'boleto_link',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    "Boleto's link"
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'cycle_start',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false],
                    'Cycle Start'
                )
                ->addColumn(
                    'cycle_end',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false],
                    'Cycle End'
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At'
                )
                ->setOption('charset', 'utf8');

            $installer->getConnection()->createTable($configTable);
        }
        return $installer;
    }

    public function installSubscriptionItems(SchemaSetupInterface $installer)
    {
        $tableName = $installer->getTable(
            'mundipagg_module_core_recurrence_subscription_items'
        );

        if (!$installer->getConnection()->isTableExists($tableName)) {
            $configTable = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'mundipagg_id',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    'format: si_xxxxxxxxxxxxxxxx'
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'subscription_id',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    'format: sub_xxxxxxxxxxxxxxxx'
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'code',
                    Table::TYPE_TEXT,
                    100,
                    [
                        'nullable' => false,
                    ],
                    'Product code on platform'
                )
                ->addColumn(
                    'quantity',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    'Quantity'
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At'
                )
                ->setOption('charset', 'utf8');

            $installer->getConnection()->createTable($configTable);
        }
        return $installer;
    }

    public function installSplitRecipient(SchemaSetupInterface $installer)
    {
        $tableName = $installer->getTable(
            'mundipagg_module_core_split_recipient'
        );

        if (!$installer->getConnection()->isTableExists($tableName)) {
            $configTable = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'mundipagg_id',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    'format: rp_xxxxxxxxxxxxxxxx'
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'external_recipient_id',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    null
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    100,
                    [
                        'nullable' => false,
                    ],
                    null
                )
                ->addColumn(
                    'document',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    null
                )
                ->addColumn(
                    'email',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    null
                )
                ->addColumn(
                    'status',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    null
                )
                ->addColumn(
                    'description',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                    ],
                    null
                )
                ->addColumn(
                    'is_marketplace',
                    Table::TYPE_BOOLEAN,
                    11,
                    [
                        'nullable' => false
                    ],
                    "Is Marketplace?"
                )
                ->addColumn(
                    'meta_data',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => true,
                    ],
                    null
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At'
                )
                ->setOption('charset', 'utf8');

            $installer->getConnection()->createTable($configTable);
        }
        return $installer;
    }

    public function installSplitRecipientBankAccount(SchemaSetupInterface $installer)
    {
        $tableName = $installer->getTable(
            'mundipagg_module_core_split_recipient_bank_account'
        );

        if (!$installer->getConnection()->isTableExists($tableName)) {
            $configTable = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'recipient_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable' => false
                    ],
                    'foreign key mundipagg_module_core_split_recipient.id'
                )
                ->addColumn(
                    'holder_name',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    null
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'holder_type',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    null
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'holder_document',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    null
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'bank',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    null
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'branch_number',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    null
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'branch_check_digit',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    null
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'account_number',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    null
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'account_check_digit',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    null
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'type',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    null
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'meta_data',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => true
                    ],
                    null
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At'
                )
                ->setOption('charset', 'utf8');

            $installer->getConnection()->createTable($configTable);
        }
        return $installer;
    }

    public function installSplitRecipientTransferSettings(SchemaSetupInterface $installer)
    {
        $tableName = $installer->getTable(
            'mundipagg_module_core_split_recipient_transfer_settings'
        );

        if (!$installer->getConnection()->isTableExists($tableName)) {
            $configTable = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'recipient_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable' => false
                    ],
                    'foreign key mundipagg_module_core_split_recipient.id'
                )
                ->addColumn(
                    'transfer_enabled',
                    Table::TYPE_BOOLEAN,
                    11,
                    [
                        'nullable' => false
                    ],
                    null
                )
                ->addColumn(
                    'transfer_interval',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false
                    ],
                    null
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'transfer_day',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable' => false
                    ],
                    null
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->setOption('charset', 'utf8')
                ->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At'
                )
                ->setOption('charset', 'utf8');

            $installer->getConnection()->createTable($configTable);
        }
        return $installer;
    }
}
