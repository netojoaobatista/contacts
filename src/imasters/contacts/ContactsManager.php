<?php
require_once 'src/imasters/contacts/Contact.php';

/**
 * Gerenciador de contatos simples que utiliza um sistema de armazenamento
 * qualquer.
 */
class ContactsManager {
    /**
     * @var ContactStorage
     */
    private $contactStorage;

    /**
     * Constroi a instância do gerenciador de contatos especificando o sistema
     * de armazenamento que será utilizado.
     * @param ContactStorage $contactStorage
     */
    public function __construct(ContactStorage $contactStorage) {
        $this->contactStorage = $contactStorage;
    }

    /**
     * Adiciona um contato.
     * @param string $email Email do contato (UNIQUE)
     * @param string $name Nome do contato
     * @param string $photo Uma foto do contato (opcional)
     */
    public function addContact($email, $name, $photo = null) {
        $contact = new Contact();
        $contact->setEmail($email);
        $contact->setName($name);
        $contact->setPhoto($photo);

        return $this->contactStorage->save($contact);
    }

    /**
     * Recupera um contato pelo email.
     * @param string $email O email do contato que se deseja recuperar.
     */
    public function getContact($email) {
        $contact = $this->contactStorage->findOne($email);

        if ($contact !== null) {
            return $contact;
        }

        $contact = new Contact();
        $contact->setEmail($email);

        return $contact;
    }

    /**
     * Recupera um Iterator com os contatos armazenados.
     * @return Iterator
     */
    public function getContactIterator() {
        return new ArrayIterator($this->contactStorage->findAll());
    }

    /**
     * Remove todos os contatos armazenados.
     */
    public function removeAll() {
        $this->contactStorage->truncate();
    }

    /**
     * Remove um contato específico.
     * @param string $email O email do contato que deverá ser removido
     */
    public function removeContact($email) {
        $contact = $this->contactStorage->findOne($email);

        if ($contact != null) {
            return $this->contactStorage->delete($contact);
        }

        return false;
    }

    /**
     * Atualiza um contato.
     * @param string $contact
     */
    public function updateContact(Contact $contact) {
        return $this->contactStorage->update($contact);
    }
}