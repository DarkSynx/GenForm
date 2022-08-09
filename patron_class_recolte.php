<?php

/**
 * class qui a pour objectif de recolter les
 * données du formulaire, de les filtrer et les
 * valider. a vous de travailler par la suite
 * avec le tableau produit par :
 * recolte, recolte_json et analyse
 */
class recolte
{

    /**
     * variable qui va recevoir le tableau de recolte
     * @var array
     */
    private array $_recolte = array();


    /**
     * variable qui va recevoir le tableau de recolte
     * @var array
     */
    public const HTML =
        '<!-- [HTML_GEN] -->';

    /**
     * constructeur de la class recolte
     */
    public function __construct($auto = false)
    {

        if (!$auto) {
            if (isset($_GET['r']) && $_GET['r'] === '1') {
                $this->_recolte = $this->donnee();
                echo $this->analyse(true);
            } else {
                echo self::HTML;
            }
        } else {
            $this->_recolte = $this->donnee();
        }

    }

    private function donnee(): array
    {
        $recolte = array();
       /* <!-- [DONNEE] --> */
        return $recolte;
    }

    /**
     * cette fonctionpermet de renvoyer
     * le tableau récolte sans analyse
     * pour une exploitation personalisé
     * @return array
     */
    public function recolte()
    {
        return $this->_recolte;
    }

    /**
     * cette fonction permet de renvoyer
     * le tableau récolte sans analyse
     * pour une exploitation personalisé
     * au format json
     * @return false|string
     */
    public function recolte_json()
    {
        return json_encode($this->_recolte);
    }

    /**
     * cette fonction est destiné à
     * déclencher une analyse complete du
     * tableau recolte et de produire un
     * tableau d'erreur ou de donnée potentiellement
     * validé; c'est à vous de revérifier que les données
     * sont bien conforme; faire confiance à un logiciel tiers
     * est déconseiller
     * @param bool $retour_json
     * @return array|string
     */
    public function analyse(bool $retour_json = false): array|string
    {
        $tableau_final = ['resultat' => true, 'Erreurs' => array()];
        foreach ($this->_recolte as $clee => $valeur) {
            // vérifier [résultat]
            if (isset($valeur['resultat']) && $valeur['resultat'] === false) {
                if ($tableau_final['resultat']) $tableau_final['resultat'] = false;
                $tableau_final['erreur'][$clee] = $this->_recolte[$clee];
            }

            // vérifier [modification]
            if (isset($valeur['modification']) && $valeur['modification'] === false) {
                if ($tableau_final['resultat']) $tableau_final['resultat'] = false;
                $tableau_final['erreur'][$clee] = $this->_recolte[$clee];
            }

            // vérifier [test]
            if (isset($valeur['test']) && $valeur['test'] === false) {
                if ($tableau_final['resultat']) $tableau_final['resultat'] = false;
                $tableau_final['erreur'][$clee] = $this->_recolte[$clee];
            }

        }
        if ($retour_json) {
            header('Content-Type: application/json; charset=utf-8');
            return json_encode($tableau_final);
        }
        return $tableau_final;
    }
}
/* =-=-=-=-=-=-=-=-=  F   I   N : C L A S S : R E C O L T E =-=-=-=-=-=-=-= */
