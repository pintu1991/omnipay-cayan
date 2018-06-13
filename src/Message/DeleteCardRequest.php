<?php

namespace Omnipay\Cayan\Message;

class DeleteCardRequest extends AbstractRequest
{
    public function getData()
    {
        $data = null;
        $this->validate('cardReference');

        $request = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope"><soap:Header/></soap:Envelope>');

        $res_add_cc = $request->addChild('soap:Body');
        $res_add_cc2 = $res_add_cc->addChild('UnboardCard','','http://schemas.merchantwarehouse.com/merchantware/v45/');

        $res_add_cc3 = $res_add_cc2->addChild('Credentials','');
        $res_add_cc3->addChild('MerchantName', $this->getMerchantName());
        $res_add_cc3->addChild('MerchantSiteId',$this->getMerchantSiteId());
        $res_add_cc3->addChild('MerchantKey',$this->getMerchantKey());

        $res_add_cc4 = $res_add_cc2->addChild('Request','');
        $res_add_cc4->addChild('VaultToken',$this->getCardReference());
        $data = $request->asXML();

        return preg_replace('/\n/', ' ', $data);
    }
}
