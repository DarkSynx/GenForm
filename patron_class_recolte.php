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

    private const SCRIPT_JS = '
    <script>
    if("<!-- [JS_ACTIVATION] -->" === "1"){
        const type = ["<!-- [JS_GEN_TYPE] -->"];
        const name = ["<!-- [JS_GEN_NAME] -->"];
        const value = ["<!-- [JS_GEN_VALUE] -->"];
        
        if(
            (type[0] !== \'<!-- [JS_GEN_TYPE] -->\' && type[0] !== "") &&
            (name[0] !== \'<!-- [JS_GEN_NAME] -->\' && name[0] !== "") &&
            (value[0] !== \'<!-- [JS_GEN_VALUE] -->\' && value[0] !== "")
        )
        {
         
            for (let i = 0; i < name.length; i++) {
              let element = document.getElementsByName(name[i]);
             // console.log(element);
                switch(type[i]){
                    case \'select\':
                    case \'input\':
                         element.value = value[i];
                         element[0].setAttribute("value",value[i]);
                   break;
                   case \'textarea\':
                        element.innerText = value[i];    
                   break;
                }
            }
        }
    }
    </script>';

    /**
     * constructeur de la class recolte
     */
    public function __construct($auto = false)
    {

        if (!$auto) {
            if (isset($_GET['r']) && $_GET['r'] === '1') {
                $this->_recolte = $this->donnee();

                echo self::HTML . $this->injection_de_valeur();
               // var_dump($this->analyse());

            } else {

                echo self::HTML . $this->injection_de_valeur();
            }
        } else {
            $this->_recolte = $this->donnee();
        }

    }

    private function injection_de_valeur()
    {
        $gen_script = '';

        if (isset($_SESSION['filter']) && $_SESSION['filter'] == 'ok') {

            $tableau_post_name = ["<!-- [POST_NAME_EXIST] -->"];
            $tableau_valeur_generer = array();

            if ($tableau_post_name !== ['<!-- [POST_NAME_EXIST] -->']) {
                //var_dump($_POST);
                foreach ($tableau_post_name as $clee) {
                    if (isset($_POST[$clee]))
                        $tableau_valeur_generer[$clee] = $_POST[$clee];
                }
                //var_dump($tableau_valeur_generer);

                $gen_script = str_replace(
                    [
                        '"<!-- [JS_GEN_VALUE] -->"',
                        '"<!-- [JS_ACTIVATION] -->"'
                    ],
                    [
                        '"' . implode('","', array_values($tableau_valeur_generer)) . '"',
                        '"1"'
                    ],
                    self::SCRIPT_JS);
            }
        }
        return $gen_script;
    }


    private function donnee(): array
    {
        $recolte = array();

        /* <!-- [DONNEE] --> */

        $_SESSION['filter'] = 'ok';
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
/* =-=-=-=-=-=-=-=-=  ! F   I   N : C L A S S : R E C O L T E ! =-=-=-=-=-=-=-= */
