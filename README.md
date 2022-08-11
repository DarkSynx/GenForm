# GenForm
generateur de formulaire


dans Modules_formulaire en début de class ne pas oublier de définir ```private const CHEMIN_PATRON =``` ou se trouve le ```patron_class_recolte.php```
moi j'ai définit par défault le chemin : via la constante ```SOUSMODULES``` 
mais vous pouvez y mettre un autre chemin de dossier ou ```./```

je vous conseil en fin de formulaire de bien configurer ```->generer(...)``` 
pour produire un fichier unique contenant le formulaire et la validation de celui voici la cofiguration requise:

```php
        // ?r=1 informe la class d'activer l'analyse quand vous cliquez sur envoyer
       FORMULAIRE::defini( CHEMIN_WEB_DU_FORMULAIRE . 'formulaires.php?r=1' ) 
            ->elements(
            ...
            ,
            ...
            )
            ->generer(
                chemin_fichier_php: FORMULAIRES . 'formulaire_test.php', // chemin qui indique là ou le fichier sera genrer
                instancier: true, // ajoute en dessous de la class $recolte = new recolte();
                debug: false, // si instancier est activer ajoute : var_dump($recolte->analyse());
                exploiter: true, // fait un include du fichier de chemin_fichier_php
                un_fichier_unique: true, // permet d'éviter d'ajoute le html dans la class produite
                fichier_post_traitement: 'index.php' // permet d'indiquer votre fichier qui va traité la suite aprés validation
            );
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
                exploiter: true, // fait un include du fichier de chemin_fichier_php
                un_fichier_unique: true // permet d'éviter d'ajoute le html dans la class produite
            );
```
![image](https://user-images.githubusercontent.com/9467611/182428360-05864f90-f9f8-4797-a251-d100db134410.png)

