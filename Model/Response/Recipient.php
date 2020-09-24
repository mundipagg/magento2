<?php

namespace MundiPagg\MundiPagg\Model\Response;

use MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\SplitRecipientsMapperResponseInterface;

class Recipient extends \MundiPagg\MundiPagg\Model\Request\Recipient implements SplitRecipientsMapperResponseInterface
{
    /**
     * @var string
     */
    private $mundipaggId;

    /**
     * @return string
     */
    public function getMundipaggId()
    {
        return $this->mundipaggId;
    }

    /**
     * @param string $mundipaggId
     */
    public function setMundipaggId($mundipaggId)
    {
        $this->mundipaggId = $mundipaggId;
    }
}
