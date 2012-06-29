<?php
require_once 'src/imasters/contacts/storage/ContactStorage.php';
require_once 'src/imasters/contacts/Contact.php';

/**
 * Acesso a dados de contatos utilizando PDO.
 */
class ContactSQLStorage implements ContactStorage {
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct($dsn, $user, $pswd) {
        $this->pdo = new PDO($dsn, $user, $pswd);
    }

    /* (non-PHPdoc)
     * @see ContactStorage::delete()
     */
    public function delete(Contact $contact) {
        $stm = $this->pdo->prepare('DELETE FROM `Contact` WHERE `email`=:email;');
        $stm->bindValue(':email', $contact->getEmail(), PDO::PARAM_STR);

        return $stm->execute();
    }

    private function fetchAll(PDOStatement $stm) {
        $stm->setFetchMode(PDO::FETCH_CLASS, 'Contact');
        $stm->execute();

        return $stm->fetchAll();
    }

    /* (non-PHPdoc)
     * @see ContactStorage::findAll()
     */
    public function findAll() {
        $stm = $this->pdo->prepare('SELECT `name`,`photo`,`email` FROM `Contact`;');

        return $this->fetchAll($stm);
    }

    /* (non-PHPdoc)
     * @see ContactStorage::findOne()
     */
    public function findOne($email) {
        $stm = $this->pdo->prepare('
            SELECT `name`,`photo`,`email`
            FROM `Contact`
            WHERE `email`=:email;'
        );

        $stm->bindParam(':email', $email, PDO::PARAM_STR);
        $all = $this->fetchAll($stm);

        return array_shift($all);
    }

    private function bindValueAndExecuteInsertOrUpdate(PDOStatement $stm,
                                                       Contact $contact) {

        $stm->bindValue(':name', $contact->getName(), PDO::PARAM_STR);
        $stm->bindValue(':photo', $contact->getPhoto(), PDO::PARAM_STR);
        $stm->bindValue(':email', $contact->getEmail(), PDO::PARAM_STR);

        return $stm->execute();
    }

    /* (non-PHPdoc)
     * @see ContactStorage::save()
     */
    public function save(Contact $contact) {
        $stm = $this->pdo->prepare('
            INSERT INTO
                `Contact`(`name`,`photo`,`email`)
                VALUES(:name,:photo,:email);'
        );

        if ($this->bindValueAndExecuteInsertOrUpdate($stm, $contact) ) {
            if (is_numeric($this->pdo->lastInsertId())) {
                return true;
            }
        }

        return false;
    }

    /* (non-PHPdoc)
     * @see ContactStorage::truncate()
     */
    public function truncate() {
       return $this->pdo->exec('TRUNCATE `Contact`;');
    }

    /* (non-PHPdoc)
     * @see ContactStorage::update()
     */
    public function update(Contact $contact) {
        $stm = $this->pdo->prepare('
            UPDATE `Contact` SET
                `name`=:name,
                `photo`=:photo
            WHERE
                `email`=:email;'
        );

        return $this->bindValueAndExecuteInsertOrUpdate($stm, $contact);
    }
}