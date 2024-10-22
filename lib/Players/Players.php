<?php
class Players
{
    /**
     *
     */
    public function __construct()
    {
    }

    /**
     *
     */
    public function __destruct()
    {
    }

    /**
     * Set friendly columns\' names to order tables\' entries
     */
    public function setOrderingValues()
    {
        $ordering = [
            'identifier' => 'license',
            'firstname' => 'Prénom',
            'lastname' => 'Nom de famille',
            'lastconnexion' => 'Dernière connexion',
            'updated_at' => 'Age du perso'
        ];

        return $ordering;
    }
}
?>