<?php

namespace Omnipay\Beanstream\Message;

use Omnipay\Tests\TestCase;

class UpdateProfileCardRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new UpdateProfileCardRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize();
    }

    public function testSendSuccess()
    {
        $this->request->setProfileId('9ba60541d32648B1A3581670123dF2Ef');
        $this->request->setCardId('1');
        $card = $this->getValidCard();
        $this->assertSame($this->request, $this->request->setCard($card));
        $this->setMockHttpResponse('UpdateProfileCardSuccess.txt');
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertSame(1, $response->getCode());
        $this->assertSame('Operation Successful', $response->getMessage());
        $this->assertSame('9ba60541d32648B1A3581670123dF2Ef', $response->getCustomerCode());
    }

    public function testSendError()
    {
        $this->request->setProfileId('9ba60541d32648B1A3581670123dF2Ef');
        $this->request->setCardId('1');
        $card = $this->getValidCard();
        $this->assertSame($this->request, $this->request->setCard($card));
        $this->setMockHttpResponse('UpdateProfileCardFailure.txt');
        $response = $this->request->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertSame(19, $response->getCode());
        $this->assertSame(3, $response->getCategory());
        $this->assertSame('Customer information failed data validation', $response->getMessage());
    }

    public function testEndpoint()
    {
        $this->assertSame($this->request, $this->request->setProfileId('1'));
        $this->assertSame($this->request, $this->request->setCardId('2'));
        $this->assertSame('1', $this->request->getProfileId());
        $this->assertSame('2', $this->request->getCardId());
        $this->assertSame('https://www.beanstream.com/api/v1/profiles/' . $this->request->getProfileId() . '/cards/' . $this->request->getCardId(), $this->request->getEndpoint());
    }

    public function testCard()
    {
        $card = $this->getValidCard();
        $this->assertSame($this->request, $this->request->setCard($card));
    }

    public function testHttpMethod()
    {
        $this->assertSame('PUT', $this->request->getHttpMethod());
    }
}
