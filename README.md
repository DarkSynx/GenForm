# GenForm
generateur de formulaire

quand ```->generer()``` est activé le tableau produit sera 

- en clée [0] le code html 
- et clée [1] le code php

donc pas d'option activé dans ```->generer()``` donnera un tableau

mais attention le constructeur est ainsi  ```->generer( instancier: true ) ```
- et si $_GET[r] comporte la valeur 1
- il va executer l'analyse
- sinon il affichera le formulaire HTML

- donc ```->generer( instancier: true ) ``` ajoutera ``` \$recolte = new recolte();``` et declenchera 
ce qui est expliqué.
- pareil si manuellement vous instancier ``` \$recolte = new recolte();``` et que vous desirez faire les choses
sans automatisation vous devez 

instancier ainsi : ``` \$recolte = new recolte(true);```

```php
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
```

----------------------
E X E M P L E   I

```php
        use Modules_formulaire_input as INPUT;
        use Modules_formulaire as FORMULAIRE;
        var_dump(
            FORMULAIRE::defini('formulaire_test')
                ->elements(
                    INPUT::defini(
                        type: 'file',
                        option: '[
                            upload,
                            "jpg" => "image/jpeg",
                            "png" => "image/png",
                            "gif" => "image/gif"
                        ]',
                        id: 'id_input_2',
                        class: 'classtest i121 l3 o1 ',
                        name: 'nametest2'
                    )
                        ->finaliser()
                )
                ->generer()
        );
```        
----------------------
E X E M P L E   II

```php
        var_dump(

            SELECT::defini(
                id: 'id_input_2',
                class: 'classtest i121 l3 o1 ',
                name: 'nametest2',
                autofocus: true,
                multiple: true,
                required: true,
            )
                ->option('chien', 'dog')
                ->option('chat', 'cat')
                ->finaliser()

        );
```
----------------------
E X E M P L E   III

```php
        var_dump(

            TEXTAREA::defini(
                id: 'id_input_2',
                class: 'classtest i121 l3 o1 ',
                name: 'nametest2',
                filtre: 'FILTER_SANITIZE_ADD_SLASHES|FILTER_SANITIZE_ENCODED',
                encaps_b64: true
            )
                ->contenu('texte1 bla bla bla bla1')
                ->contenu('texte2 bla bla bla bla2')
                ->finaliser()

        );
```
----------------------
E X E M P L E   IV

```php
        var_dump(
            FORMULAIRE::defini('formulaire_test')
                ->elements(
                    INPUT::defini(
                        type: 'file',
                        option: '[
                            upload,
                            "jpg" => "image/jpeg",
                            "png" => "image/png",
                            "gif" => "image/gif"
                        ]',
                        id: 'id_input_2',
                        class: 'classtest i121 l3 o1 ',
                        name: 'nametest2'
                    )
                        ->finaliser()
                    ,
                    INPUT::defini(
                        type:'email',
                        id: 'idtest',
                        class: 'classtest i120 l2 o18 ',
                        name: 'nametest'
                    )
                        ->argument('maxlength', 10)
                        ->argument('minlength', 2)
                        ->argument('size', 10)
                        ->exception('step', 10)
                        ->exception('data-tableau', '1,2,3')
                        ->finaliser()
                )
                ->generer()

        );
```
----------------------
E X E M P L E   V

```php
       FORMULAIRE::defini(SITE_WEB . 'formulaires.php?f=formulaire_test&r=1')
            ->elements(

                TEXTAREA::defini(
                    id: 'id_input_2',
                    class: 'classtest i121 l3 o1 ',
                    name: 'nametest1',
                    filtre: 'FILTER_SANITIZE_ADD_SLASHES|FILTER_SANITIZE_ENCODED',
                    encaps_b64: true
                )
                    ->contenu('texte1 bla bla bla bla1 \\')
                    ->contenu('texte2 bla bla bla bla2 à l\'ecole')
                    ->finaliser()
                ,

                INPUT::defini(
                    type: 'email',
                    id: 'idtest',
                    class: 'classtest i120 l2 o18 ',
                    name: 'nametest'
                )
                    ->argument('maxlength', 10)
                    ->argument('minlength', 2, maxmin_test: true)
                    ->argument('size', 10)
                    ->exception('step', 10)
                    ->exception('data-tableau', '1,2,3')
                    ->finaliser()
                ,
                INPUT::defini(
                    type: 'file',
                    option: '[
                             ./upload,
                             2000000,
                             "jpg" => "image/jpeg",
                             "png" => "image/png",
                             "gif" => "image/gif"
                             ]',
                    id: 'id_input_2',
                    class: 'classtest i121 l3 o1 ',
                    name: 'nametest2'
                )
                    ->finaliser()

                ,
                SELECT::defini(
                    id: 'id_input_2',
                    class: 'classtest i121 l3 o1 ',
                    name: 'nametest3',
                    autofocus: true,
                    multiple: true,
                    required: true,
                )
                    ->option('chien', 'dog')
                    ->option('chat', 'cat')
                    ->finaliser()
                ,
                INPUT::defini(type: 'submit')->finaliser()
            )
            ->generer(
                chemin_fichier_php: FORMULAIRES . 'formulaire_test.php', // chemin qui indique là ou le fichier sera genrer
                instancier: true, // ajoute en dessous de la class $recolte = new recolte();
                debug: false, // si instancier est activer ajoute : var_dump($recolte->analyse());
                exploiter: true // fait un include du fichier de chemin_fichier_php
            );
```
![image](https://user-images.githubusercontent.com/9467611/182428360-05864f90-f9f8-4797-a251-d100db134410.png)

