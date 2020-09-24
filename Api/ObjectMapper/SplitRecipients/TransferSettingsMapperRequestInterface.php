<?php

namespace MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients;

interface TransferSettingsMapperRequestInterface
{
    /**
     * @return string
     */
    public function getTransferInterval();

    /**
     * @param string $transferInterval
     * @return TransferSettingsMapperRequestInterface
     */
    public function setTransferInterval($transferInterval);

    /**
     * @return int
     */
    public function getTransferDay();

    /**
     * @param int $transferDay
     * @return TransferSettingsMapperRequestInterface
     */
    public function setTransferDay($transferDay);

    /**
     * @return bool
     */
    public function isTransferEnabled();

    /**
     * @param bool $transferEnabled
     * @return TransferSettingsMapperRequestInterface
     */
    public function setTransferEnabled($transferEnabled);
}
