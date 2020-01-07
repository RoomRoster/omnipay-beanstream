<?php namespace Omnipay\Beanstream\Message;

class CreateProfileCardRequest extends AbstractProfileRequest
{
    public function getEndpoint()
    {
        return $this->endpoint . '/' . $this->getProfileId() . '/cards';
    }

    public function getData()
    {
        $data = array();

        if ($this->getCard()) {
            $this->getCard()->validate();

            $data['card'] = array(
                'number' => $this->getCard()->getNumber(),
                'name' => $this->getCard()->getName(),
                'expiry_month' => $this->getCard()->getExpiryDate('m'),
                'expiry_year' => $this->getCard()->getExpiryDate('y'),
                'cvd' => $this->getCard()->getCvv(),
            );
        }

        return $data;
    }

    public function getHttpMethod()
    {
        return 'POST';
    }
}
