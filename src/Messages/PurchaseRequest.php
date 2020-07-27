<?php
/**
 * PosNet Purchase Request
 */

namespace Omnipay\PosNet\Messages;

use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AbstractRequest
{

    public $action = 'sale';

    /**
     * @inheritDoc
     * @throws InvalidRequestException
     */
    public function getData()
    {
        return [
            'mid' => $this->getMerchantId(),
            'tid' => $this->getTerminalId(),
            'tranDateRequired' => $this->getTranDateRequired(),
            $this->action => [
                'amount' => $this->getAmount(),
                'ccno' => $this->getCard()->getNumber(),
                'currencyCode' => $this->getCurrency(),
                'cvc' => $this->getCard()->getCvv(),
                'expDate' => substr($this->getCard()->getExpiryYear(), -2) . $this->getCard()->getExpiryMonth(),
                'orderId' => $this->getOrderID(),
                'installment' => $this->getInstallment()
            ]

        ];
    }

    /**
     * @param $data
     * @param $statusCode
     * @return PurchaseResponse
     */
    protected function createResponse($data, $statusCode): PurchaseResponse
    {
        return new PurchaseResponse($this, $data, $statusCode);
    }

    public function getTranDateRequired(): string
    {
        return $this->getParameter('tranDateRequired');
    }

    public function setTranDateRequired(String $tranDateRequired): PurchaseRequest
    {
        return $this->setParameter('tranDateRequired', $tranDateRequired);
    }

    public function getAmount(): string
    {
        return $this->getParameter('amount');
    }

    public function setAmount($amount)
    {
        return $this->setParameter('amount', $amount);
    }

    public function getOrderID(): string
    {
        return $this->getParameter('orderId');
    }

    public function setOrderId(string $orderId): PurchaseRequest
    {
        return $this->setParameter('orderId', $orderId);
    }

    public function getInstallment(): string
    {
        return $this->getParameter('installment');
    }

    public function setInstallment(string $installment): PurchaseRequest
    {
        return $this->setParameter('installment', $installment);
    }
}
