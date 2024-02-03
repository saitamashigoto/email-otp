<?php

namespace Piyush\EmailOtp\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Psr\Log\LoggerInterface as PsrLogger;

class Email extends \Magento\Framework\App\Helper\AbstractHelper
{
    private $inlineTranslation;

    private $escaper;

    private $transportBuilder;

    private $logger;

    public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder,
        PsrLogger $logger
    ) {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->logger = $logger;
    }

    public function sendEmail(
        $sendersName,
        $sendersEmail,
        $otp,
        $receiverEmail,
        $templateId
    ) {
        try {
            $this->inlineTranslation->suspend();
            $sender = [
                'name' => $this->escaper->escapeHtml($sendersName),
                'email' => $this->escaper->escapeHtml($sendersEmail),
            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier($templateId)
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars([
                    'otp'  => $otp,
                ])
                ->setFrom($sender)
                ->addTo($receiverEmail)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return false;
        }
        return true;
    }
}