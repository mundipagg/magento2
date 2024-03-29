<?php

namespace MundiPagg\MundiPagg\Observer;

use Exception;
use Magento\Catalog\Model\Product;
use Magento\CatalogRule\Model\ResourceModel\Rule;
use Magento\CatalogRule\Model\Rule as RuleModel;
use Magento\Customer\Model\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Store\Model\StoreManagerInterface;
use Mundipagg\Core\Kernel\Services\MoneyService;
use Mundipagg\Core\Recurrence\Services\ProductSubscriptionService;
use MundiPagg\MundiPagg\Concrete\Magento2CoreSetup;
use MundiPagg\MundiPagg\Helper\RecurrenceProductHelper;
use Mundipagg\Core\Kernel\Aggregates\Configuration;
use Magento\Quote\Model\Quote\Item;
use Mundipagg\Core\Kernel\Exceptions\InvalidParamException;
use Mundipagg\Core\Recurrence\Aggregates\ProductSubscription;

class CartAddProductAfterObserver implements ObserverInterface
{
    /**
     * @var RecurrenceProductHelper
     */
    protected $recurrenceProductHelper;

    /**
     * @var MoneyService
     */
    protected $moneyService;

    /**
     * @var Configuration
     */
    protected $mundipaggConfig;

    /**
     * @var TimezoneInterface
     */
    private $timeZone;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var Rule
     */
    private $catalogRule;

    /**
     * @var RuleModel
     */
    private $ruleModel;

    const RULE_CATALOG_DISCOUNT_FIXED = 'to_fixed';

    /**
     * CartAddProductAfterObserver constructor.
     * @param RecurrenceProductHelper $recurrenceProductHelper
     * @param TimezoneInterface $timeZone
     * @param StoreManagerInterface $storeManager
     * @param Session $customerSession
     * @param Rule $catalogRule
     * @param RuleModel $ruleModel
     * @throws Exception
     */
    public function __construct(
        RecurrenceProductHelper $recurrenceProductHelper,
        TimezoneInterface $timeZone,
        StoreManagerInterface $storeManager,
        Session $customerSession,
        Rule $catalogRule,
        RuleModel $ruleModel
    ) {
        Magento2CoreSetup::bootstrap();
        $this->recurrenceProductHelper = $recurrenceProductHelper;
        $this->moneyService = new MoneyService();
        $this->mundipaggConfig = Magento2CoreSetup::getModuleConfiguration();
        $this->timeZone = $timeZone;
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
        $this->catalogRule = $catalogRule;
        $this->ruleModel = $ruleModel;
    }

    /**
     * @param Observer $observer
     * @throws InvalidParamException
     */
    public function execute(Observer $observer)
    {
        if (
            !$this->mundipaggConfig->isEnabled() ||
            !$this->mundipaggConfig->getRecurrenceConfig()->isEnabled()
        ) {
            return;
        }

        /* @var Item $item */
        $item = $observer->getQuoteItem();
        if ($item->getParentItem()) {
            $item = $item->getParentItem();
        }

        $productSubscription = $this->getSubscriptionProduct($item);

        if (!$productSubscription) {
            return;
        }

        $specialPrice = $this->getPriceFromRepetition($item);
        if ($specialPrice > 0) {
            $this->addAmountRepetition($item, $specialPrice);
        }
    }

    /**
     * @param Item $item
     * @param float $price
     */
    public function addAmountRepetition(Item $item, $price)
    {
        $defaultTimezone = $this->timeZone->getDefaultTimezone();
        date_default_timezone_set($this->timeZone->getConfigTimezone());

        $currentRule = $this->getCatalogRule($item->getProduct());

        if (
            ($currentRule !== null) &&
            ($currentRule['action_operator'] == self::RULE_CATALOG_DISCOUNT_FIXED)
        ) {
            $item->setCustomPrice($price);
            $item->setOriginalCustomPrice($price);
            $item->getProduct()->setIsSuperMode(true);

            return;
        }

        $discountAmount = $this->ruleModel->calcProductPriceRule($item->getProduct(), $price);

        date_default_timezone_set($defaultTimezone);

        if ($discountAmount == null) {
            $discountAmount = $price;
        }

        $item->setCustomPrice($discountAmount);
        $item->setOriginalCustomPrice($discountAmount);
        $item->getProduct()->setIsSuperMode(true);
    }

    /**
     * @param Product $product
     * @return array|null
     */
    private function getCatalogRule(Product $product)
    {
        $storeId = $product->getStoreId();
        $dateTs = $this->timeZone->scopeTimeStamp($storeId);
        $websiteId = $this->storeManager->getStore($storeId)->getWebsiteId();

        $customerGroupId = $this->customerSession->getCustomerGroupId();
        if ($product->hasCustomerGroupId()) {
            $customerGroupId = $product->getCustomerGroupId();
        }

        $rulesList = $this->catalogRule->getRulesFromProduct(
            $dateTs,
            $websiteId,
            $customerGroupId,
            $product->getId()
        );

        $currentRule = null;
        foreach ($rulesList as $rule) {
            if ($rule['action_stop']) {
                $currentRule = $rule;
                break;
            }
            $currentRule = $rule;
        }

        return $currentRule;
    }

    /**
     * @param Item $item
     * @return float|int
     * @throws InvalidParamException
     */
    public function getPriceFromRepetition(Item $item)
    {
        $repetition = $this->recurrenceProductHelper
            ->getSelectedRepetition($item);

        if (!empty($repetition) && $repetition->getRecurrencePrice() > 0) {
            return $this->moneyService->centsToFloat(
                $repetition->getRecurrencePrice()
            );
        }

        return 0;
    }

    /**
     * @param Item $item
     * @return ProductSubscription|null
     */
    public function getSubscriptionProduct(Item $item)
    {
        $productId = $item->getProductId();
        $productSubscriptionService = new ProductSubscriptionService();

        /**
         * @var ProductSubscription $productSubscription
         */
        $productSubscription = $productSubscriptionService->findByProductId($productId);

        if ($productSubscription) {
            return $productSubscription;
        }

        return null;
    }
}
