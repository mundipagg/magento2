<?php

namespace MundiPagg\MundiPagg\Ui\Component\Recurrence\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use NumberFormatter;

class PaymentMethodColumn extends Column
{
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }


        $fieldName = $this->getData('name');

        foreach ($dataSource['data']['items'] as &$item) {
            $item[$fieldName] = $this->getValueFormatted($item);
        }

        return $dataSource;
    }

    public function getValueFormatted($item)
    {
        $paymentMethods = [
            'boleto' => "Boleto",
            'credit_card' => "Credit Card"
        ];
        $methodSelecteds = array_keys(
            array_filter(
                array_intersect_key($item, $paymentMethods)
            )
        );

        $result = array_map(
            function($method)  use ($paymentMethods) {
                return $paymentMethods[$method];
            },
            $methodSelecteds
        );

        return implode(" - ", $result);

        return "Boleto - Credit Card";
    }
}