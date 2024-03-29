<?php declare(strict_types=1);
    use PHPUnit\Framework\TestCase;

    class DatabaseTest extends TestCase{
        public function testGetConnection_TestCase1(): void{
            $database = new Database();

            $tempConn = new PDO("mysql:host=localhost", "TEST", "");
            //$tempConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $existingDatabases = $tempConn->query("SHOW DATABASES")->fetchAll(PDO::FETCH_COLUMN);
            if (!in_array('secureappdev', $existingDatabases)){
                $database->Create(); //create database to ensure it exists
            }
            $tempConn = null;
            $this->assertInstanceOf(PDO::class, $database->GetConnection());
        }

        public function testGetConnection_TestCase2(): void{
            $tempConn = new PDO("mysql:host=localhost", "TEST", "");
            //$tempConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $existingDatabases = $tempConn->query("SHOW DATABASES")->fetchAll(PDO::FETCH_COLUMN);
            if (in_array('secureappdev', $existingDatabases)){
                $tempConn->exec("DROP DATABASE secureappdev");//drop database to simulate no database exists scenario
            }
            $tempConn = null;

            $database = new Database();
            $this->expectException(PDOException::class);
            $database->GetConnection();
        }

        public function testCreate_TestCase1(): void{
            $database = new Database();
            $exception = null;

            try{
                $database->Create();
            }catch(Exception $e){
                $exception = $e;
            }

            $this->assertNull($exception, 'Exception was thrown');
        }

        public function testCreateSuccessMsg_TestCase1():void{
            $msg = "<br>Database created successfully<br>Table 'users' created successfully<br>Admin Added (Username = admin, Password =AdminPass1!<br>User Added (Username = user1, Password =Password1!<br>";
            $this->expectOutputString($msg);
            $database = new Database();
            $database->CreateSuccessMsg();
        }
    }
?>