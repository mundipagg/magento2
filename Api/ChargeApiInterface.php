<?php

namespace MundiPagg\MundiPagg\Api;

interface ChargeApiInterface
{

    /**
     * @param string $id
     * @return MundiPagg\MundiPagg\Model\Api\ResponseMessage
     */
    public function cancel($id);
}
