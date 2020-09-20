<?php

namespace MundiPagg\MundiPagg\Model\Api;

use Exception;
use Magento\Framework\Webapi\Rest\Request;
use MundiAPILib\Configuration;
use MundiAPILib\MundiAPIClient;
use Mundipagg\Core\Kernel\Services\LocalizationService;
use Mundipagg\Core\Kernel\Services\LogService;
use Mundipagg\Core\Kernel\Services\MoneyService;
use Mundipagg\Core\Split\Repositories\RecipientRepository;
use Mundipagg\Core\Split\Services\RecipientService;
use MundiPagg\MundiPagg\Api\SplitRecipientsApiInterface;
use MundiPagg\MundiPagg\Concrete\Magento2CoreSetup;
use MundiPagg\MundiPagg\Helper\SplitHelper;
use Throwable;

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
     * @var MoneyService
     */
    private $moneyService;

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
        $this->request = $request;
        Magento2CoreSetup::bootstrap();
        $this->i18n = new LocalizationService();
        $this->moneyService = new MoneyService();

        $logService = new LogService(
            'RecipientService',
            true
        );

        $config = Magento2CoreSetup::getModuleConfiguration();

        $secretKey = null;
        if ($config->getSecretKey() != null) {
            $secretKey = $config->getSecretKey()->getValue();
        }

        Configuration::$basicAuthPassword = '';

        $mundipaggApi = new MundiAPIClient($secretKey, '');

        $this->recipientService = new RecipientService(
            $logService,
            new RecipientRepository(),
            $mundipaggApi
        );
    }

    /**
     * @param \MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\SplitRecipientsMapperInterface $splitRecipient
     * @param int $id
     * @return \MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\SplitRecipientsMapperResponseInterface|array
     */
    public function save($splitRecipient, $id = null)
    {
        try {
            SplitHelper::validateRecipientRequest($splitRecipient);

            $splitRecipient = SplitHelper::mapperRecipientRequest($splitRecipient);

            $this->recipientService->save($splitRecipient);

            return SplitHelper::mapperRecipientResponse($splitRecipient);
        } catch (Exception $exception) {
            return [
                'code' => 404,
                'message' => $exception->getMessage()
            ];
        } catch (Throwable $exception) {
            return [
                'code' => 404,
                'message' => $exception->getMessage()
            ];
        }

        return $splitRecipient;
    }

    /**
     * @param int $id
     * @param \MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\SplitRecipientsMapperInterface $splitRecipient
     * @return \MundiPagg\MundiPagg\Api\ObjectMapper\SplitRecipients\SplitRecipientsMapperResponseInterface|array
     */
    public function update($id, $splitRecipient)
    {
        $splitRecipient->setId($id);
        return $this->save($splitRecipient, $id);
    }
}
