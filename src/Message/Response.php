<?php

namespace Omnipay\Cayan\Message;

use Omnipay\Common\Message\AbstractResponse;

class Response extends AbstractResponse
{
    function __construct($request, $data) {
        parent::__construct($request, $data);
        $this->body = $this->data->children('http://www.w3.org/2003/05/soap-envelope')->Body->children();
    }

    public function isSuccessful()
    {
        if (
            (
                isset($this->body->BoardCardResponse->BoardCardResult->VaultToken) &&
                $this->body->BoardCardResponse->BoardCardResult->VaultToken != null &&
                !empty($this->body->BoardCardResponse->BoardCardResult->VaultToken)
            ) && (
                isset($this->body->BoardCardResponse->BoardCardResult->ErrorCode) &&
                empty($this->body->BoardCardResponse->BoardCardResult->ErrorCode) &&
                empty($this->body->BoardCardResponse->BoardCardResult->ErrorMessage)
            )
        )
        { return true; }
        else if(
            (
                isset($this->body->UnboardCardResponse->UnboardCardResult->VaultToken) &&
                $this->body->UnboardCardResponse->UnboardCardResult->VaultToken != null &&
                !empty($this->body->UnboardCardResponse->UnboardCardResult->VaultToken)
            ) && (
                isset($this->body->UnboardCardResponse->UnboardCardResult->ErrorCode) &&
                empty($this->body->UnboardCardResponse->UnboardCardResult->ErrorCode) &&
                empty($this->body->UnboardCardResponse->UnboardCardResult->ErrorMessage)
            )
        )
        { return true; }
        else if (
            isset($this->body->SaleResponse->SaleResult->ApprovalStatus) &&
            !empty($this->body->SaleResponse->SaleResult->ApprovalStatus) &&
            $this->body->SaleResponse->SaleResult->ApprovalStatus == 'APPROVED'
            )
            { return true; }
        else if(
            isset($this->body->RefundResponse->RefundResult->ApprovalStatus) &&
            !empty($this->body->RefundResponse->RefundResult->ApprovalStatus) &&
            $this->body->RefundResponse->RefundResult->ApprovalStatus == 'APPROVED'
            )
            { return true; }

        return false;
    }

    public function getCardReference()
    {
        return isset($this->body->BoardCardResponse->BoardCardResult->VaultToken) ? (string) $this->body->BoardCardResponse->BoardCardResult->VaultToken : null;
    }

    public function getCode()
    {
        return null;
    }

    public function getAuthCode()
    {
        return null;
    }

    public function getTransactionId()
    {
        return null;
    }

    public function getTransactionReference()
    {
        if( isset($this->body->SaleResponse->SaleResult->Token) && (string) $this->body->SaleResponse->SaleResult->Token != null)
            return $this->body->SaleResponse->SaleResult->Token;
        elseif( isset($this->body->RefundResponse->RefundResult->Token) && (string) $this->body->RefundResponse->RefundResult->Token != null)
            return $this->body->RefundResponse->RefundResult->Token;
        else
            return null;
    }

    public function getMessage()
    {
        return null;
    }

    public function getOrderNumber()
    {
        return  null;
    }

    public function getData()
    {
        return preg_replace('/\n/', '', ($this->data)->asXML());
    }
}
