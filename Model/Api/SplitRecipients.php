<?php

namespace MundiPagg\MundiPagg\Model\Api;

use Exception;
use Magento\Framework\Webapi\Rest\Request;
use MundiAPILib\APIException;
use MundiAPILib\Configuration;
use MundiAPILib\MundiAPIClient;
use Mundipagg\Core\Kernel\Exceptions\InvalidParamException;
use Mundipagg\Core\Kernel\Services\LocalizationService;
use Mundipagg\Core\Kernel\Services\LogService;
use Mundipagg\Core\Split\Repositories\RecipientRepository;
use Mundipagg\Core\Split\Services\RecipientService;
use MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\SplitRecipientsMapperRequestInterface;
use MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\SplitRecipientsMapperResponseInterface;
use MundiPagg\MundiPagg\Api\SplitRecipientsApiInterface;
use MundiPagg\MundiPagg\Concrete\Magento2CoreSetup;
use MundiPagg\MundiPagg\Helper\SplitHelper;

class SplitRecipients implements SplitRecipientsApiInterface
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var RecipientService
     */
    protected $recipientService;

    /**
     * @var LocalizationService
     */
    private $i18n;

    /**
     * SplitRecipients constructor.
     * @param Request $request
     * @throws Exception
     */
    public function __construct(Request $request)
    {
        Magento2CoreSetup::bootstrap();

        $this->request = $request;
        $this->i18n = new LocalizationService();

        $config = Magento2CoreSetup::getModuleConfiguration();

        $secretKey = null;
        if ($config->getSecretKey() != null) {
            $secretKey = $config->getSecretKey()->getValue();
        }

        Configuration::$basicAuthPassword = '';

        $this->recipientService = new RecipientService(
            new LogService('RecipientService', true),
            new RecipientRepository(),
            new MundiAPIClient($secretKey, '')
        );
    }

    /**
     * @param SplitRecipientsMapperRequestInterface $splitRecipient
     * @param int $id
     * @return SplitRecipientsMapperResponseInterface|array
     * @throws APIException
     * @throws InvalidParamException
     * @throws Exception
     */
    public function save($splitRecipient, $id = null)
    {
        SplitHelper::validateRecipientRequest($splitRecipient);

        $splitRecipient = SplitHelper::mapperRecipientRequest($splitRecipient);
        $recipient = $this->recipientService->save($splitRecipient);

        return SplitHelper::mapperRecipientResponse($recipient);
    }

    /**
     * @param int $id
     * @param SplitRecipientsMapperRequestInterface $splitRecipient
     * @return SplitRecipientsMapperResponseInterface|array
     * @throws APIException
     * @throws InvalidParamException
     */
    public function update($id, $splitRecipient)
    {
        $splitRecipient->setId($id);
        return $this->save($splitRecipient, $id);
    }
}
