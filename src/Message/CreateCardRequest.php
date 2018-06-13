<?php

namespace Omnipay\Cayan\Message;

class CreateCardRequest extends AbstractRequest
{
    public function getData()
    {
        $data = null;
        $this->getCard()->validate();

        if ($this->getCard()) {

            $request = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope"></soap:Envelope>');

            $res_add_cc = $request->addChild('soap:Body');
            $res_add_cc2 = $res_add_cc->addChild('BoardCard','','http://schemas.merchantwarehouse.com/merchantware/v45/');

            $res_add_cc3 = $res_add_cc2->addChild('Credentials','');
            $res_add_cc3->addChild('MerchantName', $this->getMerchantName());
            $res_add_cc3->addChild('MerchantSiteId',$this->getMerchantSiteId());
            $res_add_cc3->addChild('MerchantKey',$this->getMerchantKey());

            $res_add_cc4 = $res_add_cc2->addChild('PaymentData','');
            $res_add_cc4->addChild('Source','Keyed');
            $res_add_cc4->addChild('CardNumber', $this->getCard()->getNumber());
            $res_add_cc4->addChild('ExpirationDate',$this->getCard()->getExpiryDate('my'));
            $res_add_cc4->addChild('CardHolder',$this->getCard()->getBillingName());
            $res_add_cc4->addChild('AvsStreetAddress',$this->getCard()->getBillingCountry());
            $res_add_cc4->addChild('AvsZipCode',$this->getCard()->getBillingPostcode());

            $data = $request->asXML();
        }

        return preg_replace('/\n/', ' ', $data);
    }
}
