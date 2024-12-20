<?php
namespace BestLocLib\Database;

/**
 * This interface set the needed methods for a database connexion with a singleton pattern
 */
interface Connexion {
    /**
     * This method must set a static property that is an instance of the current class
     * @return void
     */
    public static function initInstance(): void;

    /**
     * This method must return the instance of the current class containing the database connexion
     * @return object the current class
     */
    public static function getInstance(): Object;

    /**
     * This method must return the connexion of the static instance of the current class
     * @return object the current class's connexion
     */
    public function getConnexion(): Object;
}