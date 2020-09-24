<?php

namespace MundiPagg\MundiPagg\Helper;

use Exception;
use Magento\Customer\Model\Customer;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\IntegrationException;
use Magento\Framework\Module\Manager;
use Mundipagg\Core\Kernel\Helper\Hydrator;
use Mundipagg\Core\Kernel\ValueObjects\Type;
use Mundipagg\Core\Split\Aggregates\BankAccount;
use Mundipagg\Core\Split\Aggregates\Recipient;
use Mundipagg\Core\Split\Aggregates\TransferSettings;
use Mundipagg\Core\Split\Interfaces\RecipientInterface;
use Mundipagg\Core\Split\Repositories\RecipientRepository;
use Mundipagg\Core\Split\ValueObjects\TransferInterval;
use Mundipagg\Core\Split\ValueObjects\TypeBankAccount;
use MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\SplitRecipientsMapperRequestInterface;
use MundiPagg\MundiPagg\Model\Response\BankAccount as BankAccountResponse;
use MundiPagg\MundiPagg\Model\Response\Recipient as RecipientResponse;
use MundiPagg\MundiPagg\Model\Response\TransferSetting as TransferSettingResponse;
use ReflectionException;
use Webkul\Marketplace\Model\Seller;

class SplitHelper
{
    private const MODULE_MARKETPLACE_NAME = 'Webkul_Marketplace';

    /**
     * @param SplitRecipientsMapperRequestInterface $recipientRequest
     * @return RecipientInterface
     * @throws Exception
     */
    public static function mapperRecipientRequest(
        SplitRecipientsMapperRequestInterface $recipientRequest
    ) {
        $recipientCore = new Recipient();
        $bankAccountCore = new BankAccount();
        $transferSettingsCore = new TransferSettings();

        if ($recipientRequest->getId() !== null) {
            $recipientRepository = new RecipientRepository();
            $recipientPrevious = $recipientRepository->find($recipientRequest->getId());

            $bankAccountCore->setId($recipientPrevious->getBankAccount()->getId());
            $recipientCore->setMundipaggId($recipientPrevious->getMundipaggId());
            $recipientCore->setStatus($recipientPrevious->getStatus());
            $recipientRequest->setDocument($recipientPrevious->getDocument());
        }

        if ($recipientRequest->isMarketPlace()) {
            $recipientCore
                ->setName($recipientRequest->getName())
                ->setEmail($recipientRequest->getEmail())
                ->setDocument($recipientRequest->getDocument())
                ->setDescription($recipientRequest->getDescription());
        }

        if (!$recipientRequest->isMarketPlace()) {
            $objectManager = ObjectManager::getInstance();
            $customer = $objectManager->get(Customer::class)->load(
                $recipientRequest->getExternalRecipientId()
            );

            $recipientCore
                ->setName($customer->getName())
                ->setEmail($customer->getEmail())
                ->setDescription("description default")
                ->setDocument($customer->getDataByKey('taxvat'));
        }

        $recipientCore
            ->setId($recipientRequest->getId())
            ->setIsMarketPlace($recipientRequest->isMarketPlace())
            ->setExternalRecipientId($recipientRequest->getExternalRecipientId())
            ->setType(self::getDocumentType($recipientCore->getDocument()));

        $bankAccountRequest = $recipientRequest->getBankAccount();
        $bankAccountCore
            ->setHolderName($recipientCore->getName())
            ->setType(new TypeBankAccount($bankAccountRequest->getType()))
            ->setHolderDocument($recipientCore->getDocument())
            ->setBank($bankAccountRequest->getBank())
            ->setBranchNumber($bankAccountRequest->getBranchNumber())
            ->setBranchCheckDigit($bankAccountRequest->getBranchCheckDigit())
            ->setAccountNumber($bankAccountRequest->getAccountNumber())
            ->setAccountCheckDigit($bankAccountRequest->getAccountCheckDigit())
            ->setHolderType($recipientCore->getType());

        $recipientCore->setBankAccount($bankAccountCore);

        if ($recipientRequest->getTransferSettings() !== null) {
            $transferSettingsRequest = $recipientRequest->getTransferSettings();
            $transferSettingsCore
                ->setTransferInterval(new TransferInterval(
                    $transferSettingsRequest->getTransferInterval()
                ))
                ->setTransferDay($transferSettingsRequest->getTransferDay())
                ->setTransferEnabled($transferSettingsRequest->isTransferEnabled());

            $recipientCore->setTransferSettings($transferSettingsCore);
        }

        return $recipientCore;
    }

    /**
     * @param $document
     * @return Type
     */
    private static function getDocumentType($document)
    {
        $type = Type::company();
        if (strlen($document) == 11 && ($document !== null)) {
            $type = Type::individual();
        }

        return $type;
    }

    /**
     * @param RecipientInterface $recipientCore
     * @return RecipientResponse
     */
    public static function mapperRecipientResponse(RecipientInterface $recipientCore)
    {
        $recipientResponse = new RecipientResponse();

        $recipientResponse->setName($recipientCore->getName());
        $recipientResponse->setEmail($recipientCore->getEmail());
        $recipientResponse->setDescription($recipientCore->getDescription());
        $recipientResponse->setDocument($recipientCore->getDocument());
        $recipientResponse->setIsMarketPlace($recipientCore->isMarketPlace());
        $recipientResponse->setId($recipientCore->getId());
        $recipientResponse->setMundipaggId($recipientCore->getMundipaggId()->getValue());
        $recipientResponse->setExternalRecipientId($recipientCore->getExternalRecipientId());
        $recipientResponse->setStatus($recipientCore->getStatus()->getValue());

        $bankAccountCore = $recipientCore->getBankAccount();
        $bankAccountResponse = new BankAccountResponse();

        $bankAccountResponse->setBank($bankAccountCore->getBank());
        $bankAccountResponse->setBranchNumber($bankAccountCore->getBranchNumber());
        $bankAccountResponse->setBranchCheckDigit($bankAccountCore->getBranchCheckDigit());
        $bankAccountResponse->setAccountNumber($bankAccountCore->getAccountNumber());
        $bankAccountResponse->setType($bankAccountCore->getType()->getValue());

        $recipientResponse->setBankAccount($bankAccountResponse);

        $transferSettingsCore = $recipientCore->getTransferSettings();
        $transferSettingResponse = new TransferSettingResponse();

        $transferSettingResponse->setTransferInterval(
            $transferSettingsCore->getTransferInterval()->getValue()
        );
        $transferSettingResponse->setTransferDay($transferSettingsCore->getTransferDay());
        $transferSettingResponse->setTransferEnabled($transferSettingsCore->isTransferEnabled());

        $recipientResponse->setTransferSettings($transferSettingResponse);

        return $recipientResponse;
    }

    /**
     * @param SplitRecipientsMapperRequestInterface $recipient
     * @throws Exception
     */
    public static function validateRecipientRequest(
        SplitRecipientsMapperRequestInterface $recipient
    ) {
        $objectManager = ObjectManager::getInstance();

        /**
         * @var Manager $moduleManager
         */
        $moduleManager = $objectManager->get(Manager::class);

        if (!$moduleManager->isEnabled(self::MODULE_MARKETPLACE_NAME)) {
            $moduleName = self::MODULE_MARKETPLACE_NAME;
            throw new IntegrationException(
                __("Module {$moduleName} not found/enabled"),
                null,
                null
            );
        }

        /**
         * @var Seller $seller
         */
        $seller = $objectManager->get(Seller::class)->load(
            $recipient->getExternalRecipientId()
        );

        if (!$recipient->isMarketPlace() && !(bool)$seller->getData("is_seller")) {
            throw new IntegrationException(__("It's not a seller"), null, null);
        }

        if ($recipient->isMarketPlace() && $recipient->getExternalRecipientId() !== null) {
            throw new InputException(
                __("It's not possible to pass marketplace and externalRecipientId"),
                null,
                null
            );
        }

        $recipientMKTList = null;
        if ($recipient->isMarketPlace() && $recipient->getId() === null) {
            $recipientRepository = new RecipientRepository();
            $recipientMKTList = $recipientRepository->getMarketplaceUser();
        }

        if ($recipientMKTList !== null) {
            throw new AlreadyExistsException(
                __("It's not possible to have more the one Recipient MKT"),
                null,
                null
            );
        }

        if ($recipient->isMarketPlace()) {
            self::checkFieldsRequired(
                $recipient,
                ['status', 'externalRecipientId', 'id', 'document', 'transferSettings']
            );
            return;
        }

        self::checkFieldsRequired(
            $recipient,
            [
                'status',
                'externalRecipientId',
                'id',
                'document',
                'transferSettings',
                'name',
                'email',
                'description'
            ]
        );
    }

    /**
     * @param SplitRecipientsMapperRequestInterface $recipient
     * @param array $propertyListDontCheck
     * @throws ReflectionException
     */
    private static function checkFieldsRequired(
        SplitRecipientsMapperRequestInterface $recipient,
        array $propertyListDontCheck
    ) {
        $recipientArray = Hydrator::extractRecursive($recipient);

        array_walk_recursive(
            $recipientArray,
            function ($value, $key) use ($propertyListDontCheck) {
                if ($value === null && !in_array($key, $propertyListDontCheck)) {
                    throw new InputException(
                        __("The '{$key}' is required"),
                        null,
                        null
                    );
                }
            }
        );
    }
}
