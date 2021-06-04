<?php

namespace MundiPagg\MundiPagg\Api;

use MundiPagg\MundiPagg\Model\Api\BulkSingleResponse;

interface BulkSingleResponseInterface
{
    public function setStatus(int $status): BulkSingleResponse;
    public function getStatus(): int;
    public function setBody(array $body): BulkSingleResponse;
    public function getBody(): array;
}
