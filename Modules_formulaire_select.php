<?php

namespace Eukaruon\modules;

use JetBrains\PhpStorm\Pure;

/**
 *
 */
class Modules_formulaire_select
{
    /**
     * @var mixed
     */
    protected mixed $preparation;

    /**
     * @param $value
     */
    public function __construct($value)
    {
        $this->preparation = $value;
    }

    /**
     * @param string|null $id
     * @param string|null $class
     * @param string|null $name
     * @param string|null $autocomplete
     * @param string|null $autofocus
     * @param string|null $disabled
     * @param string|null $form
     * @param string|null $multiple
     * @param string|null $required
     * @param string|null $size
     * @return static
     */
    #[Pure] public static function defini(string|null $id = null,
                                          string|null $class = null,
                                          string|null $name = null,
                                          string|null $autocomplete = null,
                                          string|null $autofocus = null,
                                          string|null $disabled = null,
                                          string|null $form = null,
                                          string|null $multiple = null,
                                          string|null $required = null,
                                          string|null $size = null
    ): static
    {
        return new static(self::corp($id, $class, $name));
    }


    /**
     * @param string|null $id
     * @param string|null $class
     * @param string|null $name
     * @param string|null $autocomplete
     * @param string|null $autofocus
     * @param string|null $disabled
     * @param string|null $form
     * @param string|null $multiple
     * @param string|null $required
     * @param string|null $size
     * @return string[]
     */
    private static function corp(string|null $id = null,
                                 string|null $class = null,
                                 string|null $name = null,
                                 string|null $autocomplete = null,
                                 string|null $autofocus = null,
                                 string|null $disabled = null,
                                 string|null $form = null,
                                 string|null $multiple = null,
                                 string|null $required = null,
                                 string|null $size = null): array
    {
        $gen_id_class_name = '';
        if (strlen($id) > 0) $gen_id_class_name .= " id=\"$id\"";
        if (strlen($class) > 0) $gen_id_class_name .= " class=\"$class\"";
        if (strlen($name) > 0) $gen_id_class_name .= " name=\"$name\"";
        if (strlen($autocomplete) > 0) $gen_id_class_name .= " autocomplete=\"$autocomplete\"";
        if (strlen($autofocus) > 0) $gen_id_class_name .= " autofocus";
        if (strlen($disabled) > 0) $gen_id_class_name .= " disabled";
        if (strlen($form) > 0) $gen_id_class_name .= " form=\"$form\"";
        if (strlen($multiple) > 0) $gen_id_class_name .= " multiple";
        if (strlen($required) > 0) $gen_id_class_name .= " required";
        if (strlen($size) > 0) $gen_id_class_name .= " size=\"$size\"";


        return ["<select$gen_id_class_name>", ''];
    }

    /**
     * @param $fonction
     * @return static
     */
    #[Pure] private static function queue($fonction): static
    {
        return new static($fonction);
    }

    /**
     * @param $valeur
     * @param $label
     * @return $this
     */
    public function option($valeur, $label): static
    {
        // call_user_func => $function($this->value)
        return static::queue(
            call_user_func_array(
                [$this, 'element'],
                [$valeur,$label, $this->preparation])
        );
    }


    /**
     * @param $valeur
     * @param $label
     * @param $preparation
     * @return string[]
     */
    private function element($valeur, $label, $preparation): array
    {
        return ["{$preparation[0]}<option value=\"$valeur\">$label</option>" . PHP_EOL, ''];
    }


    /**
     * @return array
     */
    public function finaliser(): array
    {
        $this->preparation[0] .= PHP_EOL . '</select>';
        return [
            $this->preparation[0],
            $this->preparation[1]
        ];
    }

}