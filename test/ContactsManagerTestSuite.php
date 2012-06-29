<?php
require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'test/ContactsManagerMongoTest.php';
require_once 'test/ContactsManagerSQLTest.php';

/**
 * Static test suite.
 */
class ContactsManagerTestSuite extends PHPUnit_Framework_TestSuite {

    /**
     * Constructs the test suite handler.
     */
    public function __construct() {
        $this->setName('ContactsManagerTestSuite');

        $this->addTestSuite('ContactsManagerMongoTest');
        $this->addTestSuite('ContactsManagerSQLTest');
    }

    /**
     * Creates the suite.
     */
    public static function suite() {
        return new self();
    }
}