<?php
/**
 * Representação de um contato.
 */
class Contact {
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $photo;

    /**
     * @var string
     */
    private $email;

	/**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

	/**
     * @return string
     */
    public function getPhoto() {
        return $this->photo;
    }

	/**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

	/**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

	/**
     * @param string $photo
     */
    public function setPhoto($photo) {
        $this->photo = $photo;
    }

	/**
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }
}