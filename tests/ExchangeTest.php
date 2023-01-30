<?php
namespace Opeepl\BackendTest\Service;

use PHPUnit\Framework\TestCase;
use Opeepl\BackendTest\Exceptions\UnsupportedCurrencyException;

class ExchangeTest extends TestCase {

    protected $exchange;

    public function setUp(): void {
        $this->exchangeSymbols = new Exchange("https://api.apilayer.com/exchangerates_data/symbols", "https://api.apilayer.com/exchangerates_data/convert?to=placeholderTo&from=placeholderFrom&amount=placeholderAmount", "kigiQGomtNhg3zsoWOb6LYcKRuhQp2fM");
        $this->exchangeCurrencies = new Exchange("https://api.apilayer.com/currency_data/list", "https://api.apilayer.com/currency_data/convert?to=placeholderTo&from=placeholderFrom&amount=placeholderAmount", "tTmluFD1qzf5NvfHV8fbn7FB4pDimE92");
    }

    /**
     * @test
     */
    public function getCurrenciesWithSymbolsKeyTest() {
        $currencies = $this->exchangeSymbols->getCurrencies();

        $this->assertContains('USD', $currencies, 'Expected USD to be a supported currency');
        $this->assertContains('EUR', $currencies, 'Expected EUR to be a supported currency');
        $this->assertNotContains('NotACurrency', $currencies, 'Expected NotACurrency not to be a supported currency');
    }

    /**
     * @test
     */
    public function getCurrenciesWithCurrenciesKeyTest() {
        $currencies = $this->exchangeCurrencies->getCurrencies();

        $this->assertContains('USD', $currencies, 'Expected USD to be a supported currency');
        $this->assertContains('EUR', $currencies, 'Expected EUR to be a supported currency');
        $this->assertNotContains('NotACurrency', $currencies, 'Expected NotACurrency not to be a supported currency');
    }

    /**
     * @test
     */
    public function getAmountValidInputTest() {
        $amount = $this->exchangeSymbols->getAmount(100, 'EUR', 'DKK');

        $this->assertTrue(740 < $amount && $amount < 760);
    }

    /**
     * @test
     */
    public function getAmountInvalidFromCurrencyWithMessageKeyTest() {
        $this->expectException(UnsupportedCurrencyException::class);

        $amount = $this->exchangeCurrencies->getAmount(100, 'HAHA', 'DKK');
    }

    /**
     * @test
     */
    public function getAmountInvalidToCurrencyWithMessageKeyTest() {
        $this->expectException(UnsupportedCurrencyException::class);

        $amount = $this->exchangeCurrencies->getAmount(100, 'EUR', 'HAHA');
    }

    /**
     * @test
     */
    public function getAmountInvalidFromCurrencyWithInfoKeyTest() {
        $this->expectException(UnsupportedCurrencyException::class);

        $amount = $this->exchangeSymbols->getAmount(100, 'HAHA', 'DKK');
    }

    /**
     * @test
     */
    public function getAmountInvalidToCurrencyWithInfoKeyTest() {
        $this->expectException(UnsupportedCurrencyException::class);

        $amount = $this->exchangeSymbols->getAmount(100, 'EUR', 'HAHA');
    }

}
