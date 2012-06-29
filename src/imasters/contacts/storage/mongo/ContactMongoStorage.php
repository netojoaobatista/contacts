<?php
require_once 'src/imasters/contacts/storage/ContactStorage.php';

/**
 * Acesso a dados gravados em uma base MongoDB.
 */
class ContactMongoStorage implements ContactStorage {
    /**
     * @var MongoCollection
     */
    private $contactsManagerCollection;

    public function __construct() {
        $mongo = new Mongo();
        $mongoDb = $mongo->selectDB('ContactsManager');

        $this->contactsManagerCollection = new MongoCollection($mongoDb, 'Contact');
        $this->contactsManagerCollection->ensureIndex(
            array('email' => 1),
            array('unique' => true, 'dropDups' => true)
        );
    }

	/* (non-PHPdoc)
     * @see ContactStorage::delete()
     */
    public function delete(Contact $contact) {
        try {
            $this->contactsManagerCollection->remove(
                array('email' => $contact->getEmail()), array('safe' => true)
            );

            return true;
        } catch (MongoCursorException $e) {
            //log
        }

        return false;
    }

    private function createContact(array $data) {
        $contact = new Contact();
        $contact->setEmail($data['email']);
        $contact->setName($data['name']);
        $contact->setPhoto($data['photo']);

        return $contact;
    }

	/* (non-PHPdoc)
     * @see ContactStorage::findAll()
     */
    public function findAll() {
        $all = $this->contactsManagerCollection->find();
        $contacts = array();

        foreach ($all as $item) {
            $contacts[] = $this->createContact($item);
        }

        return $contacts;
    }

	/* (non-PHPdoc)
     * @see ContactStorage::findOne()
     */
    public function findOne($email) {
        $one = $this->contactsManagerCollection->findOne(array('email' => $email));

        if ($one != null) {
            return $this->createContact($one);
        }
    }

	/* (non-PHPdoc)
     * @see ContactStorage::save()
     */
    public function save(Contact $contact) {
        try {
            $this->contactsManagerCollection->insert(array(
                'name' => $contact->getName(),
                'email' => $contact->getEmail(),
                'photo' => $contact->getPhoto()
            ), array('safe' => true));

            return true;
        } catch (MongoCursorException $e) {
            //log
        }

        return false;
    }

	/* (non-PHPdoc)
     * @see ContactStorage::truncate()
     */
    public function truncate() {
        return $this->contactsManagerCollection->remove();
    }

	/* (non-PHPdoc)
     * @see ContactStorage::update()
     */
    public function update(Contact $contact) {
        try {
            return $this->contactsManagerCollection->update(
                array('email' => $contact->getEmail()),
                array(
                    'name' => $contact->getName(),
                    'email' => $contact->getEmail(),
                    'photo' => $contact->getPhoto()
                ),
                array('safe' => true)
             );
        } catch (MongoCursorException $e) {
            //log
        }

        return false;
    }
}