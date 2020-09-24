<?php

namespace MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients;

use Mundipagg\Core\Split\Interfaces\BankAccountInterface;

interface BankAccountMapperRequestInterface
{
    /**
     * @param string
     * @return BankAccountInterface
     */
    public function setBank($bank);

    /**
     * @return string
     */
    public function getBank();

    /**
     * @param string
     * @return BankAccountInterface
     */
    public function setBranchNumber($branchNumber);

    /**
     * @return string
     */
    public function getBranchNumber();

    /**
     * @param string
     * @return BankAccountInterface
     */
    public function setBranchCheckDigit($branchCheckDigit);

    /**
     * @return string
     */
    public function getBranchCheckDigit();

    /**
     * @param string
     * @return BankAccountInterface
     */
    public function setAccountNumber($accountNumber);

    /**
     * @return string
     */
    public function getAccountNumber();

    /**
     * @param string
     * @return BankAccountInterface
     */
    public function setAccountCheckDigit($accountCheckDigit);

    /**
     * @return string
     */
    public function getAccountCheckDigit();

    /**
     * @param string
     * @return BankAccountInterface
     */
    public function setType($type);

    /**
     * @return string
     */
    public function getType();
}
