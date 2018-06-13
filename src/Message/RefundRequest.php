<?php

namespace Omnipay\Cayan\Message;

class RefundRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount', 'transactionReference');

        $transactionReference = simplexml_load_string($this->getTransactionReference());
        $transactionReceipt = $transactionReference->receipt;

        $request = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope"></soap:Envelope>');
        $res_add_cc = $request->addChild('soap:Body');
        $res_add_cc2 = $res_add_cc->addChild('Refund','','http://schemas.merchantwarehouse.com/merchantware/v45/');

        $res_add_cc3 = $res_add_cc2->addChild('Credentials','');
        $res_add_cc3->addChild('MerchantName', $this->getMerchantName());
        $res_add_cc3->addChild('MerchantSiteId',$this->getMerchantSiteId());
        $res_add_cc3->addChild('MerchantKey',$this->getMerchantKey());


        $soap = simplexml_load_string($this->getTransactionReference());
        $body = $soap->children('http://www.w3.org/2003/05/soap-envelope')->Body->children();
        $Token = (string) $body->SaleResponse->SaleResult->Token;
        $res_add_cc4 = $res_add_cc2->addChild('PaymentData','');
        $res_add_cc4->addChild('Source','PreviousTransaction');
        $res_add_cc4->addChild('Token',$Token);

        $res_add_cc5 = $res_add_cc2->addChild('Request','');
        $res_add_cc5->addChild('Amount',$this->getAmount());
        $res_add_cc5->addChild('EnablePartialAuthorization','False');
        $res_add_cc5->addChild('ForceDuplicate','False');

        $data = $request->asXML();

        return preg_replace('/\n/', ' ', $data);
    }
}
