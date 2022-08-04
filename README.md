# GenForm
generateur de formulaire

----------------------
E X E M P L E   I

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
----------------------
E X E M P L E   II

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

----------------------
E X E M P L E   III

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

----------------------
E X E M P L E   IV

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



![image](https://user-images.githubusercontent.com/9467611/182428360-05864f90-f9f8-4797-a251-d100db134410.png)

