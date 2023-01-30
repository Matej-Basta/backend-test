<?php
namespace Opeepl\BackendTest\Service;

use PHPUnit\Framework\TestCase;
use Opeepl\BackendTest\Exceptions\ApiException;


class DataFetcherTest extends TestCase {

    /**
     * @test -functioning
     */
    public function fetchDataValidInputTest() {
        $data = DataFetcher::fetchData("https://api.apilayer.com/exchangerates_data/symbols", "kigiQGomtNhg3zsoWOb6LYcKRuhQp2fM");

        $this->assertEquals(true, $data['success'], 'The "success" key should have a value "true".');
    }

    /**
     * @test -functioning
     */
    public function fetchDataInvalidUrlTest() {
        $this->expectException(ApiException::class);
        
        $data = DataFetcher::fetchData("heyheyhttps://api.apilayer.com/exchangerates_data/symbols", "kigiQGomtNhg3zsoWOb6LYcKRuhQp2fM");       
    }

    /**
     * @test
     */
    public function fetchDataInvalidKeyTest() {
        $this->expectException(ApiException::class);
        
        $data = DataFetcher::fetchData("https://api.apilayer.com/exchangerates_data/symbols", "heyheykigiQGomtNhg3zsoWOb6LYcKRuhQp2fM");
    }

}
