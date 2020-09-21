<?php

namespace MundiPagg\MundiPagg\Api;

interface SplitRecipientsApiInterface
{
    /**
     * @param \MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\SplitRecipientsMapperRequestInterface $splitRecipient
     * @param int $id
     * @return \MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\SplitRecipientsMapperResponseInterface|array
     */
    public function save($splitRecipient, $id = null);

    /**
     * @param int $id
     * @param \MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\SplitRecipientsMapperRequestInterface $splitRecipient
     * @return \MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\SplitRecipientsMapperResponseInterface|array
     */
    public function update($id, $splitRecipient);
}
