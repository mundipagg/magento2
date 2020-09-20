<?php

namespace MundiPagg\MundiPagg\Helper;

use Exception;
use Magento\Customer\Model\Customer;
use Magento\Framework\App\ObjectManager;
use Mundipagg\Core\Kernel\ValueObjects\Type;
use Mundipagg\Core\Split\Aggregates\BankAccount;
use Mundipagg\Core\Split\Aggregates\Recipient;
use Mundipagg\Core\Split\Interfaces\RecipientInterface;
use Mundipagg\Core\Split\Repositories\RecipientRepository;
use Mundipagg\Core\Split\ValueObjects\TypeBankAccount;
use MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\SplitRecipientsMapperInterface;
use MundiPagg\MundiPagg\Model\Response\BankAccount as BankAccountResponse;
use MundiPagg\MundiPagg\Model\Response\Recipient as RecipientResponse;
use Webkul\Marketplace\Model\Seller;

class SplitHelper
{
    /**
     * @param SplitRecipientsMapperInterface $recipientRequest
     * @return RecipientInterface
     * @throws Exception
     */
    public static function mapperRecipientRequest(SplitRecipientsMapperInterface $recipientRequest)
    {
        $recipientCore = new Recipient();
        $bankAccountCore = new BankAccount();

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
                ->setDescription("testando ver de onde pegar")
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

    public static function mapperRecipientResponse(RecipientInterface $recipientCore)
    {
        $recipientResponse = new RecipientResponse();

        $recipientResponse->setName($recipientCore->getName());
        $recipientResponse->setEmail($recipientCore->getEmail());
        $recipientResponse->setDescription($recipientCore->getDescription());
        $recipientResponse->setDocument($recipientCore->getDocument());
        $recipientResponse->setIsMarketPlace($recipientCore->isMarketPlace());
        //   $recipientResponse->setType($recipientCore->getType()->getValue());
        $recipientResponse->setId($recipientCore->getId());
        $recipientResponse->setMundipaggId($recipientCore->getMundipaggId()->getValue());
        $recipientResponse->setExternalRecipientId($recipientCore->getExternalRecipientId());
        $recipientResponse->setStatus($recipientCore->getStatus()->getValue());

        $bankAccountCore = $recipientCore->getBankAccount();

        $bankAccountResponse = new BankAccountResponse();

        //  $bankAccountResponse->setHolderName($bankAccountCore->getHolderName());
        //  $bankAccountResponse->setHolderType($bankAccountCore->getHolderType()->getValue());
        //  $bankAccountResponse->setHolderDocument($bankAccountCore->getHolderDocument());
        $bankAccountResponse->setBank($bankAccountCore->getBank());
        $bankAccountResponse->setBranchNumber($bankAccountCore->getBranchNumber());
        $bankAccountResponse->setBranchCheckDigit($bankAccountCore->getBranchCheckDigit());
        $bankAccountResponse->setAccountNumber($bankAccountCore->getAccountNumber());
        $bankAccountResponse->setAccountCheckDigit($bankAccountCore->getAccountCheckDigit());

//        $type = Type::company();
//        if (strlen($recipientPrevious->getDocument()) == 11 && ($recipientPrevious->getDocument() !== null)) {
//            $type = Type::individual();
//        }

        //   $recipientCore->setType($type);

        $bankAccountResponse->setType($bankAccountCore->getType()->getValue());

        $recipientResponse->setBankAccount($bankAccountResponse);

        return $recipientResponse;
    }

    /**
     * @param RecipientInterface $recipient
     * @throws Exception
     */
    public static function validateRecipientRequest(SplitRecipientsMapperInterface $recipient)
    {
        $objectManager = ObjectManager::getInstance();
        $seller = $objectManager->get(Seller::class)->load(
            $recipient->getExternalRecipientId()
        );

        if (!$recipient->isMarketPlace() && !(bool)$seller->getData("is_seller")) {
            throw new Exception("it's not a seller");
        }

        if ($recipient->isMarketPlace()) {
            // só pode ter um
        }

        if ($recipient->isMarketPlace() && $recipient->getExternalRecipientId() !== null) {
            // se cair aqui montou o json request errado
            throw new Exception("bad request!!!!");
        }
    }
}
