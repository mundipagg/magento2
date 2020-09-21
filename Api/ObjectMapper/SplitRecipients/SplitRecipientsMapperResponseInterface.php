<?php

namespace MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients;

interface SplitRecipientsMapperResponseInterface extends SplitRecipientsMapperRequestInterface
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
