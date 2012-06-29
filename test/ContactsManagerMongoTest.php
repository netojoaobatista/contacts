<?php
require_once 'test/AbstractContactsManagerTest.php';
require_once 'src/imasters/contacts/storage/mongo/ContactMongoStorage.php';

/**
 * ContactsManager test case with MongoDB Storage.
 */
class ContactsManagerMongoTest extends AbstractContactsManagerTest {
    /* (non-PHPdoc)
     * @see AbstractContactsManagerTest::createContactStorage()
     */
    protected function createContactStorage() {
        return new ContactMongoStorage();
    }
}