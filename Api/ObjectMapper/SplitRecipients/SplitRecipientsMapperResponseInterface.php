<?php

namespace MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients;

use Mundipagg\Core\Split\Interfaces\BankAccountInterface;
use Mundipagg\Core\Split\Interfaces\RecipientInterface;

interface SplitRecipientsMapperResponseInterface extends SplitRecipientsMapperInterface
{
    /**
     * @return string
     */
    public function getMundipaggId();

    /**
     * @param string $mundipaggId
     * @return SplitRecipientsMapperResponseInterface
     */
    public function setMundipaggId($mundipaggId);
}