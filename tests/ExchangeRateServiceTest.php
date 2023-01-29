<?php
namespace Opeepl\BackendTest\Service;

use PHPUnit\Framework\TestCase;
use Opeepl\BackendTest\Exceptions\NegativeAmountException;
use Opeepl\BackendTest\Exceptions\UnsupportedCurrencyException;

class ExchangeRateServiceTest extends TestCase {

    protected $exchangeRateService;

    public function setUp(): void {
        $this->exchangeRateService = new ExchangeRateService();
    }

    /**
     * @test -functioning
     */
    // public function setExchangeTest() {
    //     $this->exchangeRateService->setExchange("https://api.apilayer.com/currency_data/list", "https://api.apilayer.com/currency_data/convert?to=placeholderTo&from=placeholderFrom&amount=placeholderAmount", "kigiQGomtNhg3zsoWOb6LYcKRuhQp2fM");
        
    //     $this->assertCount(1, $this->exchangeRateService->getExchanges(), "Expected that the number of exchanges is 1.");
    // }

    /**
     * @test -functioning
     */
   /*  public function addExchangeTest() {
        $this->exchangeRateService->addExchange("https://api.apilayer.com/currency_data/list", "https://api.apilayer.com/currency_data/convert?to=placeholderTo&from=placeholderFrom&amount=placeholderAmount", "kigiQGomtNhg3zsoWOb6LYcKRuhQp2fM");
        
        $this->assertCount(2, $this->exchangeRateService->getExchanges(), "Expected that the number of exchanges is 2.");
    } */

    /**
     * @test -functioning
     */
    /* public function getSupportedCurrenciesTest() {
        $currencies = $this->exchangeRateService->getSupportedCurrencies();

        $this->assertContains('USD', $currencies, 'Expected USD to be a supported currency');
        $this->assertContains('EUR', $currencies, 'Expected EUR to be a supported currency');
        $this->assertContains('DKK', $currencies, 'Expected DKK to be a supported currency');
        $this->assertContains('CAD', $currencies, 'Expected CAD to be a supported currency');
    } */

    /**
     * @test -functioning
     */
    /* public function getExchangeAmountEURToDKKTest() {
        $amount = $this->exchangeRateService->getExchangeAmount(100, 'EUR', 'DKK');

        // Because of the fixed-rate policy between DKK and EUR, we should be able to expect 1 EUR to be between 7.4 and 7.6.
        $this->assertTrue(740 < $amount && $amount < 760);
    } */

    /**
     * @test -functioning
     */
    /* public function getExchangeAmountUSDToCADTest() {
        $amount = $this->exchangeRateService->getExchangeAmount(200, 'USD', 'CAD');

        // For the sake of simplicity, we expect USD to CAD to be between 1.2 and 1.45.
        $this->assertTrue(240 < $amount && $amount < 290);
    } */

    /**
     * @test -functioning
     */
    /* public function getExchangeAmountSameCurrenciesest() {
        $amount = $this->exchangeRateService->getExchangeAmount(200, 'USD', 'USD');

        $this->assertEquals(200, $amount);
    } */

    /**
     * @test -functioning
     */
    /* public function getExchangeAmountNegativeAmountTest() : void {
        $this->expectException(NegativeAmountException::class);

        $this->exchangeRateService->getExchangeAmount(-200, 'EUR', 'DKK');
    } */

    /**
     * @test -functioning
     */
    /* public function getExchangeAmountUnsupportedFromCurrencyWithCurrenciesFieldSetTest() : void {
        $this->exchangeRateService->getSupportedCurrencies();
        $this->expectException(UnsupportedCurrencyException::class);

        $this->exchangeRateService->getExchangeAmount(200, 'ERROR', 'DKK');
    } */

    /**
     * @test -functioning
     */
    /* public function getExchangeAmountUnsupportedToCurrencyWithCurrenciesFieldSetTest() : void {
        $this->exchangeRateService->getSupportedCurrencies();
        $this->expectException(UnsupportedCurrencyException::class);

        $this->exchangeRateService->getExchangeAmount(200, 'EUR', 'ERROR');
    }
 */
     /**
     * @test -functioning
     */
    /* public function getExchangeAmountZeroAmountTest() : void {
        $amount = $this->exchangeRateService->getExchangeAmount(0, 'USD', 'USD');

        $this->assertEquals(0, $amount);
    } */

    
}
