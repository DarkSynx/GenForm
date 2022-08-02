<?php

namespace Eukaruon\modules;

use JetBrains\PhpStorm\Pure;

class Modules_formulaire
{
    /**
     * @var mixed
     */
    protected array $code = ['', '<?php '];


    public function __construct($code)
    {
        $this->code = $code;
    }

    #[Pure] public static function defini($action, $method = 'post')
    {
        return new static(self::identite_formulaire($action, $method));
    }

    #[Pure] public static function gestion_element($element)
    {
        return new static($element);
    }

    /**
     * @param $type
     * @return array
     */
    private static function identite_formulaire($action, $method): array
    {
        return ["<form action=\"$action\" $method=\"$method\">", ''];
    }


    public function elements(...$tableau)
    {
        $tableau_fusionner = [$this->code[0],$this->code[1]];
        foreach ($tableau as $valeur) {
           $tableau_element = call_user_func_array([$this, 'element'], [$valeur]);
            $tableau_fusionner = [
                $tableau_fusionner[0] . PHP_EOL . $tableau_element[0],
                $tableau_fusionner[1] . PHP_EOL .  $tableau_element[1],
            ];
        }
        return static::gestion_element($tableau_fusionner);
    }

    /**
     * @param $argument
     * @param $valeur
     * @param $preparation
     * @return array
     */
    public function element($tableau): array
    {
        return $tableau;
    }


    public function generer()
    {
        $this->code[0] .= PHP_EOL . '</form>';
        return [
            $this->code[0],
            '\$recolte = array();' .
            $this->code[1]
        ];
    }

}