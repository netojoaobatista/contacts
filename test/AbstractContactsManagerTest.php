<?php
require_once 'src/imasters/contacts/storage/mysql/ContactSQLStorage.php';
require_once 'src/imasters/contacts/ContactsManager.php';
require_once 'PHPUnit/Framework/TestCase.php';

/**
 * ContactsManager test case.
 */
abstract class AbstractContactsManagerTest extends PHPUnit_Framework_TestCase {
    const TEST_EMAIL = 'neto.joaobatista@imasters.com.br';
    const TEST_NAME = 'João Batista Neto';

    /**
     * @var ContactsManager
     */
    private $contactsManager;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp() {
        parent::setUp();

        $this->contactsManager = new ContactsManager($this->createContactStorage());
    }

    /**
     * Creates an instance of ContactStorage.
     * @return ContactStorage
     */
    protected abstract function createContactStorage();

    /**
     * Cleans up the 	environment after running a test.
     */
    protected function tearDown() {
        $this->contactsManager->removeAll();
        $this->contactsManager = null;

        parent::tearDown();
    }

    /**
     * Tests ContactsManager->addContact()
     */
    public function testAddContact() {
        $add = $this->contactsManager->addContact(AbstractContactsManagerTest::TEST_EMAIL,
                                                  AbstractContactsManagerTest::TEST_NAME);

        $this->assertEquals(true, $add);

        $add = $this->contactsManager->addContact(AbstractContactsManagerTest::TEST_EMAIL,
                                                  AbstractContactsManagerTest::TEST_NAME);

        //UNIQUE Test: There can be only one
        $this->assertEquals(false, $add);
    }

    /**
     * Tests ContactsManager->removeContact()
     */
    public function testRemoveContact() {
        $this->contactsManager->addContact(AbstractContactsManagerTest::TEST_EMAIL,
                                           AbstractContactsManagerTest::TEST_NAME);

        $del = $this->contactsManager->removeContact(AbstractContactsManagerTest::TEST_EMAIL);

        $this->assertEquals(true, $del);

        $del = $this->contactsManager->removeContact(AbstractContactsManagerTest::TEST_EMAIL);

        //we can't remove what doesn't exists
        $this->assertEquals(false, $del);
    }

    /**
     * Tests ContactsManager->getContact()
     */
    public function testGetContact() {
        $this->contactsManager->addContact(AbstractContactsManagerTest::TEST_EMAIL,
                                           AbstractContactsManagerTest::TEST_NAME);

        $contact = $this->contactsManager->getContact(AbstractContactsManagerTest::TEST_EMAIL);

        $this->assertEquals('Contact', get_class($contact));
        $this->assertEquals(AbstractContactsManagerTest::TEST_EMAIL, $contact->getEmail());
        $this->assertEquals(AbstractContactsManagerTest::TEST_NAME, $contact->getNAme());
    }

 	/**
     * Tests ContactsManager->getContact()
     */
    public function testGetContactWithNonExistentContact() {
        $contact = $this->contactsManager->getContact('foo@bar.com');

        $this->assertEquals('Contact', get_class($contact));
        $this->assertEquals('foo@bar.com', $contact->getEmail());
        $this->assertNull($contact->getName());
        $this->assertNull($contact->getPhoto());
    }

    /**
     * Tests ContactsManager->getContactIterator()
     */
    public function testGetContactIterator() {
        $iterator = $this->contactsManager->getContactIterator();

        foreach ($iterator as $contact) {
            $this->assertEquals('Contact', get_class($contact));
        }
    }

    /**
     * Tests ContactsManager->updateContact()
     */
    public function testUpdateContact() {
        $this->contactsManager->addContact(AbstractContactsManagerTest::TEST_EMAIL,
                                           AbstractContactsManagerTest::TEST_NAME);

        $contact = $this->contactsManager->getContact(AbstractContactsManagerTest::TEST_EMAIL);
        $contact->setName('Fulano de Tal');
        $contact->setPhoto('uma foto');

        $this->contactsManager->updateContact($contact);

        $contact = $this->contactsManager->getContact(AbstractContactsManagerTest::TEST_EMAIL);
        $this->assertEquals('Contact', get_class($contact));
        $this->assertEquals(AbstractContactsManagerTest::TEST_EMAIL, $contact->getEmail());
        $this->assertEquals('Fulano de Tal', $contact->getName());
        $this->assertEquals('uma foto', $contact->getPhoto());
    }
}