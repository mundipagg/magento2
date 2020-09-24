<?php

namespace MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients;

use Mundipagg\Core\Split\Interfaces\RecipientInterface;

interface SplitRecipientsMapperRequestInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return RecipientInterface
     */
    public function setId($id);

    /**
     * @param int $id
     * @return RecipientInterface
     */
    public function setExternalRecipientId($id);

    /**
     * @return int
     */
    public function getExternalRecipientId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return RecipientInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param $email
     * @return RecipientInterface
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param $description
     * @return RecipientInterface
     */
    public function setDescription($description);

    /**
     * @return string
     */
    public function getDocument();

    /**
     * @param $document
     * @return RecipientInterface
     */
    public function setDocument($document);

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param $status
     * @return RecipientInterface
     */
    public function setStatus($status);

    /**
     * @return \MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\BankAccountMapperRequestInterface
     */
    public function getBankAccount();

    /**
     * @param \MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\BankAccountMapperRequestInterface $bankAccount
     * @return RecipientInterface
     */
    public function setBankAccount(
        \MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\BankAccountMapperRequestInterface
        $bankAccount
    );

    /**
     * @param \MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\TransferSettingsMapperRequestInterface $transferSettings
     * @return RecipientInterface
     */
    public function setTransferSettings(
        \MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\TransferSettingsMapperRequestInterface
        $transferSettings
    );

    /**
     * @return \MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\TransferSettingsMapperRequestInterface
     */
    public function getTransferSettings();

    /**
     * @return bool
     */
    public function isMarketPlace();

    /**
     * @param bool $isMarketPlace
     * @return RecipientInterface
     */
    public function setIsMarketPlace($isMarketPlace);
}
