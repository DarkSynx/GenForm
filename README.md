# GenForm
generateur de formulaire


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
E X E M P L E II

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




----------------------------->
array (size=2)
  0 => string '<form action="formulaire_test" post="post">

<input type="file" id="id_input_2" class="classtest i121 l3 o1 " name="nametest2">

<input type="email" id="idtest" class="classtest i120 l2 o18 " name="nametest" maxlength="10" minlength="2" size="10" step="10" data-tableau="1,2,3">

</form>' (length=287)
  1 => string '\$recolte = array();

/* ===[ TEST DE : nametest2] === */



// validation de $_POST['nametest2'] 



    // Undefined | Multiple Files | $_FILES Corruption Attack

    // If this request falls under any of them, treat it invalid.

    if (

        !isset($_FILES['nametest2']['error']) ||

        is_array($_FILES['nametest2']['error'])

    ) {

        $recolte['nametest2'][0] = false;

    }



    // Check $_FILES['nametest2']['error'] value.

    switch ($_FILES['nametest2']['error']) {

        case '... (length=2507)
