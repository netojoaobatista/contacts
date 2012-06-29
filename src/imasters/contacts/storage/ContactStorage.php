<?php
/**
 * Interface para definição de um sistema de armazenamento para os contatos.
 */
interface ContactStorage {
    /**
     * Apaga um contato.
     * @param Contact $contact
     * @return boolean
     */
    public function delete(Contact $contact);

    /**
     * Recupera todos os contatos.
     * @return arra[Contact]
     */
    public function findAll();

    /**
     * Recupera um contato específico.
     * @param string $email O email do contato que deverá ser recuperado.
     * @return Contact
     */
    public function findOne($email);

    /**
     * Salva um contato.
     * @param Contact $contact
     * @return boolean
     */
    public function save(Contact $contact);

    /**
     * Remove todos os contatos do sistema de armazenamento.
     */
    public function truncate();

    /**
     * Atualiza um contato.
     * @param Contact $contact
     * @return boolean
     */
    public function update(Contact $contact);
}