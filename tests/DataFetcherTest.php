<?php
namespace Opeepl\BackendTest\Service;

use PHPUnit\Framework\TestCase;

class DataFetcherTest extends TestCase {

    /**
     * @test
     */
    public function fetchDataValidInputTest() {
        $data = DataFetcher::fetchData("https://api.apilayer.com/currency_data/list", "kigiQGomtNhg3zsoWOb6LYcKRuhQp2fM");

        $this->assertEquals(true, $data['success'], 'The "success" key should have a value "true".');
    }

    /**
     * @test
     */
    public function fetchDataInvalidUrlTest() {
        $data = DataFetcher::fetchData("https://api.apilayereer.com/currency_data/list", "kigiQGomtNhg3zsoWOb6LYcKRuhQp2fM");

        $this->assertArrayNotHasKey($data['success'], 'There should be no "success" key.');
    }

    public function fetchDataInvalidKeyTest() {
        $data = DataFetcher::fetchData("https://api.apilayereer.com/currency_data/list", "kigiQGomtNhg3zsoWOb6LYcKRuhQp2fM");

        $this->assertArrayNotHasKey($data['success'], 'There should be no "success" key.');
    }

}
