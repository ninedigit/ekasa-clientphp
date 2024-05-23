<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

class CashRegisterReceiptBuilder extends ReceiptBuilder
{
    public function setPayments(?array $payments): CashRegisterReceiptBuilder
    {
        $this->receipt->payments = $payments;
        return $this;
    }

    public function addPayment(
        ReceiptPaymentDto ...$payment
    ): CashRegisterReceiptBuilder {
        if (!is_array($this->receipt->payments)) {
            $this->receipt->payments = array();
        }

        array_push($this->receipt->payments, ...$payment);
        return $this;
    }
<<<<<<< HEAD

    public function addCashPayment(float $amount): CashRegisterReceiptBuilder {
        $payment = new ReceiptPaymentDto($amount, ReceiptPaymentName::CASH);
        return $this->addPayment($payment);
    }
}
=======
}
>>>>>>> 582bd624e4688804b6b7b5c4d22054986873239a
