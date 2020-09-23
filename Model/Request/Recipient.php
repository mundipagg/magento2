<?php

namespace MundiPagg\MundiPagg\Model\Request;

use MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\BankAccountMapperRequestInterface;
use MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\SplitRecipientsMapperRequestInterface;
use MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\TransferSettingsMapperRequestInterface;

class Recipient implements SplitRecipientsMapperRequestInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $description;

    /**
     * @var BankAccountMapperRequestInterface
     */
    private $bankAccount;

    /**
     * @var int
     */
    private $externalRecipientId;

    /**
     * @var string
     */
    private $status;

    /**
     * @var bool
     */
    private $isMarketPlace = false;

    /**
     * @var string
     */
    private $document;

    /**
     * @var int
     */
    private $id;

    /**
     * @var TransferSettingsMapperRequestInterface
     */
    private $transferSettings;

    /**
     * @return int
     */
    public function getExternalRecipientId()
    {
        return $this->externalRecipientId;
    }

    /**
     * @param int $externalRecipientId
     */
    public function setExternalRecipientId($externalRecipientId)
    {
        $this->externalRecipientId = $externalRecipientId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param $document
     */
    public function setDocument($document)
    {
        $this->document = $document;
    }

    /**
     * @return BankAccountMapperRequestInterface
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * @param BankAccountMapperRequestInterface $bankAccount
     */
    public function setBankAccount(BankAccountMapperRequestInterface $bankAccount)
    {
        $this->bankAccount = $bankAccount;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return bool
     */
    public function isMarketPlace()
    {
        return $this->isMarketPlace;
    }

    /**
     * @param bool $isMarketPlace
     */
    public function setIsMarketPlace($isMarketPlace)
    {
        $this->isMarketPlace = $isMarketPlace;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTransferSettings(TransferSettingsMapperRequestInterface $transferSettings)
    {
        $this->transferSettings = $transferSettings;
    }

    public function getTransferSettings()
    {
        return $this->transferSettings;
    }
}
