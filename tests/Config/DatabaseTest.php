<?php
use PHPUnit\Framework\TestCase;
use TitipInformatika\Data\Config\Database;

class DatabaseTest extends TestCase{

    public function testGetConnection(){
        self::assertNotNull(Database::getconnection());
    }

    public function testDatabaseSigletone(){
        $database1 = Database::getconnection();
        $database2 = Database::getconnection();
        self::assertEquals($database1,$database2);
    }


}