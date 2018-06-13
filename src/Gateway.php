<?php

namespace Omnipay\Cayan;

use Omnipay\Common\AbstractGateway;

/**
 * Moneris Gateway
 * @link https://esqa.moneris.com/mpg/reports/transaction/index.php
 * @link https://developer.moneris.com/en/Documentation/NA/E-Commerce%20Solutions/API/
 */

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Cayan';
    }

    public function getDefaultParameters()
    {
        return [
            'merchantName' => '',
            'merchantSiteId' => '',
            'merchantKey' => '',
        ];
    }

    public function getMerchantName()
    {
        return $this->getParameter('merchantName');
    }

    public function setMerchantName($value)
    {
        return $this->setParameter('merchantName', $value);
    }

    public function getMerchantSiteId()
    {
        return $this->getParameter('merchantSiteId');
    }

    public function setMerchantSiteId($value)
    {
        return $this->setParameter('merchantSiteId', $value);
    }

    public function getMerchantKey()
    {
        return $this->getParameter('merchantKey');
    }

    public function setMerchantKey($value)
    {
        return $this->setParameter('merchantKey', $value);
    }

    public function createCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Cayan\Message\CreateCardRequest', $parameters);
    }

    public function deleteCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Cayan\Message\DeleteCardRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Cayan\Message\PurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Cayan\Message\RefundRequest', $parameters);
    }
}

