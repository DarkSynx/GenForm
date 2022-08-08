<?php

namespace Eukaruon\modules;

use Exception;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 *
 */
class Modules_formulaire
{
    /**
     * @var mixed
     */
    private array $code;

    private array $_element_check_name = array();

    private string|null $_nom_formulaire = null;

    /**
     * @param $code
     */
    public function __construct($code)
    {
        $this->code = $code;

        //var_dump($this->_nom_formulaire);
        if (is_null($this->_nom_formulaire))
            $this->_nom_formulaire = $code['name'] ?? 'formulaire_' . time();
        //var_dump($this->_nom_formulaire);

    }

    /**
     * @param string|null $action
     * @param string $method
     * @param string|null $id
     * @param string|null $class
     * @param string|null $name
     * @return static
     */
    public static function defini(string|null $action = null, string $method = 'post', string|null $id = null,
                                  string|null $class = null, string|null $name = null): static
    {
        return new static(self::identite_formulaire($action, $method, $id, $class, $name));
    }

    /**
     * @param $action
     * @param $method
     * @param $id
     * @param $class
     * @param $name
     * @return array
     */
    #[ArrayShape([0 => "string", 1 => "string", 'name' => ""])]
    private static function identite_formulaire($action, $method, $id, $class, $name): array
    {
        $gen_infos = '';
        if (strlen($action) > 0) $gen_infos .= " action=\"$action\"";
        if (strlen($method) > 0) $gen_infos .= " method=\"$method\"";
        if (strlen($id) > 0) $gen_infos .= " id=\"$id\"";
        if (strlen($class) > 0) $gen_infos .= " class=\"$class\"";
        if (strlen($name) > 0) $gen_infos .= " class=\"$name\"";


        return ["<form $gen_infos>", '', 'name' => $name];
    }

    /**
     * @param ...$tableau
     * @return $this
     */
    public function elements(...$tableau): static
    {
        $tableau_fusionner = [$this->code[0], $this->code[1]];
        foreach ($tableau as $valeur) {
            $tableau_element = call_user_func_array([$this, 'element'], [$valeur]);
            $tableau_fusionner = [
                $tableau_fusionner[0] . PHP_EOL . $tableau_element[0],
                $tableau_fusionner[1] . PHP_EOL . $tableau_element[1],
            ];
        }
        $tableau_fusionner['name'] = $this->_nom_formulaire;

        return new static($tableau_fusionner);
    }


    /**
     * @param $tableau
     * @return array
     * @throws Exception
     */
    private function element($tableau): array
    {
        if (array_key_exists($tableau[3], $this->_element_check_name)) {
            $element = $this->_element_check_name[$tableau[3]];
            throw new Exception("( Erreur [$tableau[2] : $tableau[3]] nom déjà utilisé par [$element : $tableau[3]] )");
        }

        $this->_element_check_name[$tableau[3]] = $tableau[2];


        return $tableau;
    }

    /* *
     * RECODER TOUTES CETTE PARTIE POUR RENDRE PAR DEFAULT
     *
     *
     *
     * */

    /**
     * @param string|null $chemin_fichier_php
     * @param bool $instancier
     * @param bool $debug
     * @param bool $afficher
     * @return array
     */
    public function generer(
        string|null $chemin_fichier_php = null,
        bool        $instancier = false,
        bool        $debug = false,
        bool $exploiter = false
    ): array
    {
        $this->code[0] .= PHP_EOL . '</form>';

        $donnee_php = $this->gen_class_exploite(
            $this->code[1],
            $instancier,
            $debug,
            $this->code[0],
            $chemin_fichier_php,
            $exploiter
        );

        return [
            $this->code[0],
            $donnee_php
        ];

    }


    private function gen_class_exploite(
        $donnee,
        $instancier,
        $debug,
        $code,
        $chemin_fichier_php,
        $utiliser
    ): string
    {
        $auto_code_gen = '';

        if ($instancier) {
            $vardump = '';
            if ($debug) $vardump = 'var_dump($recolte->analyse());';
            $auto_code_gen = "
                \$recolte = new recolte();
                $vardump";
        }


        $tete_class = <<<TETE_CLASS
            <?php 
            
                /**
                 * class qui a pour objectif de recolter les
                 * données du formulaire, de les filtrer et les 
                 * valider. a vous de travailler par la suite 
                 * avec le tableau produit par :
                 * recolte, recolte_json et analyse
                 */
                class recolte {
                
                    /**
                     * variable qui va recevoir le tableau de recolte
                     * @var array
                     */
                    private array \$_recolte = array();
                    
                    
                     /**
                     * variable qui va recevoir le tableau de recolte
                     * @var array
                     */
                    public const HTML = 
                    '<!-- [HTML_GEN] -->';                   
                    
                    /**
                     * constructeur de la class recolte
                     */
                    public function __construct(\$auto = false) {
                    
                        if(!\$auto) {
                            if(isset(\$_GET['r']) && \$_GET['r'] === '1'){
                                \$this->_recolte = \$this->donnee();
                                echo \$this->analyse(true);
                            } else {
                                 echo self::HTML;
                            }
                        }
                        else {
                            \$this->_recolte = \$this->donnee();
                        }

                    }
                    
                    private function donnee() : array {
                        \$recolte = array();
                        $donnee
                        return \$recolte;
                    }
                    
                    /**
                     * cette fonctionpermet de renvoyer
                     * le tableau récolte sans analyse
                     * pour une exploitation personalisé
                     * @return array
                     */
                    public function recolte(){
                        return \$this->_recolte;
                    }
                        
                    /**
                     * cette fonction permet de renvoyer
                     * le tableau récolte sans analyse 
                     * pour une exploitation personalisé
                     * au format json
                     * @return false|string
                     */
                    public function recolte_json(){
                        return json_encode(\$this->_recolte);
                    }
                    
                /**
                 * cette fonction est destiné à
                 * déclencher une analyse complete du
                 * tableau recolte et de produire un
                 * tableau d'erreur ou de donnée potentiellement
                 * validé; c'est à vous de revérifier que les données
                 * sont bien conforme; faire confiance à un logiciel tiers
                 * est déconseiller
                 * @param bool \$retour_json
                 * @return array|string
                 */
                public function analyse(bool \$retour_json = false) : array|string
                {
                    \$tableau_final = ['resultat' => true,'Erreurs' => array()];
                    foreach (\$this->_recolte as \$clee => \$valeur){
                            // vérifier [résultat]
                            if(isset(\$valeur['resultat']) && \$valeur['resultat'] === false) {
                                if(\$tableau_final['resultat']) \$tableau_final['resultat'] = false;
                                \$tableau_final['erreur'][\$clee] = \$this->_recolte[\$clee];
                            }
                            
                            // vérifier [modification]
                            if(isset(\$valeur['modification']) && \$valeur['modification'] === false) {
                                if(\$tableau_final['resultat']) \$tableau_final['resultat'] = false;
                                \$tableau_final['erreur'][\$clee] = \$this->_recolte[\$clee];
                            }
                            
                            // vérifier [test]
                            if(isset(\$valeur['test']) && \$valeur['test'] === false) {
                                if(\$tableau_final['resultat']) \$tableau_final['resultat'] = false;
                                \$tableau_final['erreur'][\$clee] = \$this->_recolte[\$clee];
                            }
                            
                    }
                    if(\$retour_json)  { 
                    header('Content-Type: application/json; charset=utf-8');
                    return json_encode(\$tableau_final);
                    }
                    return \$tableau_final;
                }
           }
           /* =-=-=-=-=-=-=-=-=  F   I   N : C L A S S : R E C O L T E =-=-=-=-=-=-=-= */
           
           $auto_code_gen

        TETE_CLASS;


        if (!is_null($chemin_fichier_php)) {
            //<!-- [HTML_GEN] -->
            $tete_class2 = str_replace('<!-- [HTML_GEN] -->',
                str_replace("'", "\'", $code),
                $tete_class);
            file_put_contents($chemin_fichier_php, $tete_class2);

            if ($utiliser) {
               include $chemin_fichier_php;
            }
        }



        return $tete_class;
    }


}