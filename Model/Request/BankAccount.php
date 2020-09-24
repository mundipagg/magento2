<?php

namespace MundiPagg\MundiPagg\Model\Request;

use MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\BankAccountMapperRequestInterface;

class BankAccount implements BankAccountMapperRequestInterface
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $bank;

    /**
     * @var string
     */
    private $branchNumber;

    /**
     * @var string
     */
    private $branchCheckDigit;

    /**
     * @var string
     */
    private $accountNumber;

    /**
     * @var string
     */
    private $accountCheckDigit;

    /**
     * @param string $bank
     */
    public function setBank($bank)
    {
        $this->bank = $bank;
    }

    /**
     * @return string
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * @param string $branchNumber
     */
    public function setBranchNumber($branchNumber)
    {
        $this->branchNumber = $branchNumber;
    }

    /**
     * @return string
     */
    public function getBranchNumber()
    {
        return $this->branchNumber;
    }

    /**
     * @param string $branchCheckDigit
     */
    public function setBranchCheckDigit($branchCheckDigit)
    {
        $this->branchCheckDigit = $branchCheckDigit;
    }

    /**
     * @return string
     */
    public function getBranchCheckDigit()
    {
        return $this->branchCheckDigit;
    }

    /**
     * @param string
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
    }

    /**
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @param string
     */
    public function setAccountCheckDigit($accountCheckDigit)
    {
        $this->accountCheckDigit = $accountCheckDigit;
    }

    /**
     * @return string
     */
    public function getAccountCheckDigit()
    {
        return $this->accountCheckDigit;
    }

    /**
     * @param string
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed|string[]
     */
    public function jsonSerialize()
    {
        return ["testebank" => "bankarray"];
    }
}
