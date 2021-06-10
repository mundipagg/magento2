<?php

namespace MundiPagg\MundiPagg\Model\Api;

use Magento\Framework\HTTP\Client\Curl;
use MundiPagg\MundiPagg\Api\BulkSingleResponseInterface;
use MundiPagg\MundiPagg\Model\Api\ResponseMessage;

class BulkSingleResponse implements BulkSingleResponseInterface
{
    private $response;
    private $status;
    private $body;

    public function setStatus(int $status): BulkSingleResponse
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setBody(array $body): BulkSingleResponse
    {
        $this->body = $body;
        return $this;
    }

    public function getBody(): array
    {
        return $this->body;
    }
}
