<?php

namespace  Omnipay\Cayan\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $host = 'https://ps1.merchantware.net/Merchantware/ws/RetailTransaction/v45/Credit.asmx';
    protected $testHost = 'https://ps1.merchantware.net/Merchantware/ws/RetailTransaction/v45/Credit.asmx';
    protected $endpoint = '';

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testHost : $this->host;
    }

    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
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

    public function getPaymentMethod()
    {
        return $this->getParameter('payment_method');
    }

    public function setPaymentMethod($value)
    {
        return $this->setParameter('payment_method', $value);
    }

    public function getPaymentProfile()
    {
        return $this->getParameter('payment_profile');
    }

    public function setPaymentProfile($value)
    {
        return $this->setParameter('payment_profile', $value);
    }

    public function getOrderNumber()
    {
        return $this->getParameter('order_number');
    }

    public function setOrderNumber($value)
    {
        return $this->setParameter('order_number', $value);
    }

    protected function getHttpMethod()
    {
        return 'POST';
    }

    public function sendData($data)
    {
        $headers = [
            'Content-Type' => 'text/xml'
        ];

        if (!empty($data)) {
            $httpResponse = $this->httpClient->request($this->getHttpMethod(), $this->getEndpoint(), $headers, $data);
        }
        else {
            $httpResponse = $this->httpClient->request($this->getHttpMethod(), $this->getEndpoint(), $headers);
        }

        try {
            $xmlResponse = simplexml_load_string($httpResponse->getBody()->getContents());
        }
        catch (\Exception $e){
            info('Guzzle response : ', [$httpResponse]);
            $res = [];
            $res['resptext'] = 'Oops! something went wrong, Try again after sometime.';
            return $this->response = new Response($this, $res);
        }

        return $this->response = new Response($this, $xmlResponse);
    }
}

