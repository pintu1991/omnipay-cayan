<?php

namespace Omnipay\Cayan\Message;

class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $data = null;

        $this->validate('amount');

        $paymentMethod = $this->getPaymentMethod();

        switch ($paymentMethod)
        {
            case 'card' :
                break;

            case 'payment_profile' :

                if ($this->getCardReference()) {

                    $request = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope"></soap:Envelope>');
                    $res_add_cc = $request->addChild('soap:Body');
                    $res_add_cc2 = $res_add_cc->addChild('Sale','','http://schemas.merchantwarehouse.com/merchantware/v45/');

                    $res_add_cc3 = $res_add_cc2->addChild('Credentials','');
                    $res_add_cc3->addChild('MerchantName', $this->getMerchantName());
                    $res_add_cc3->addChild('MerchantSiteId',$this->getMerchantSiteId());
                    $res_add_cc3->addChild('MerchantKey',$this->getMerchantKey());

                    $res_add_cc4 = $res_add_cc2->addChild('PaymentData','');
                    $res_add_cc4->addChild('Source','Vault');
                    $res_add_cc4->addChild('VaultToken',$this->getCardReference());

                    $res_add_cc5 = $res_add_cc2->addChild('Request','');
                    $res_add_cc5->addChild('Amount',$this->getAmount());
                    $res_add_cc5->addChild('CashbackAmount','0.0');
                    $res_add_cc5->addChild('TaxAmount','0.0');
                    $res_add_cc5->addChild('PurchaseOrderNumber',$this->getOrderNumber());
                    $res_add_cc5->addChild('EnablePartialAuthorization','False');
                    $res_add_cc5->addChild('ForceDuplicate','False');

                    $data = $request->asXML();
                }
                break;

            case 'token' :
                break;
            default :
                break;
        }

        return preg_replace('/\n/', ' ', $data);
    }
}

