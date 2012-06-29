<?php
require_once 'test/AbstractContactsManagerTest.php';

/**
 * ContactsManager test case with SQL Storage.
 */
class ContactsManagerSQLTest extends AbstractContactsManagerTest {
    /* (non-PHPdoc)
     * @see AbstractContactsManagerTest::createContactStorage()
     */
    protected function createContactStorage() {
        $user = 'root';
        $pswd = 'oge6742fj';

        return new ContactSQLStorage(
                                    'mysql:host=127.0.0.1;dbname=ContactsManager',
                                    $user, $pswd);
    }
}