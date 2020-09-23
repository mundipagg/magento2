<?php

namespace MundiPagg\MundiPagg\Model\Request;

use MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\TransferSettingsMapperRequestInterface;

class TransferSetting implements TransferSettingsMapperRequestInterface
{
    /**
     * @var string
     */
    private $transferInterval;

    /**
     * @var bool
     */
    private $transferEnabled;

    /**
     * @var int
     */
    private $transferDay;

    /**
     * @return string
     */
    public function getTransferInterval()
    {
        return $this->transferInterval;
    }

    /**
     * @param string $transferInterval
     */
    public function setTransferInterval($transferInterval)
    {
        $this->transferInterval = $transferInterval;
    }

    /**
     * @return bool
     */
    public function isTransferEnabled()
    {
        return $this->transferEnabled;
    }

    /**
     * @param bool $transferEnabled
     */
    public function setTransferEnabled($transferEnabled)
    {
        $this->transferEnabled = $transferEnabled;
    }

    /**
     * @return int
     */
    public function getTransferDay()
    {
        return $this->transferDay;
    }

    /**
     * @param int $transferDay
     */
    public function setTransferDay($transferDay)
    {
        $this->transferDay = $transferDay;
    }
}
