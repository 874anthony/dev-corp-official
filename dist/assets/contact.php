<?php
// Email address verification

function isEmail($email) {
    return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email));
}

if($_POST) {

    //email to receive the notification when someone subscribes
    $from = 'soporte@developcorp.com.co';
    $emailTo = 'anthony082008@hotmail.es';

    $client_name = trim($_POST['client-name']);
    $client_message = $_POST['contact-message'];
    $client_email = addslashes(trim($_POST['client-email']));

    if(!isEmail($client_email)) {
        $array = array();
        $array['valid'] = 0;
        $array['message'] = '¡Ingresa una dirección de correo válida!';
        echo json_encode($array);
    }
    else {
        $array = array();
        $array['valid'] = 1;
        $array['message'] = '¡Gracias por escribirnos! <br> Nuestro equipo se contactará contigo pronto.';
        echo json_encode($array);

        // Send email
        $subject = '¡Nuevo mensaje! [Develop+ Corporation]';
        $body = "
                <html>
                    <head>
                    <title>Correo de Contacto</title>
                    <style>
                        table, th, td {
                            border: 1px solid #134e7e;
                            border-collapse: collapse;
                            border-radius: 5px;
                        }
                        th, td {
                            padding: 5px;
                            text-align: left;
                        }
                        p {
                            text-align: justify;
                        }
                    </style>
                    </head>
                    <body>
                        <h3>¡Alguien está interesado en nuestros servicios!</h3>
                        <table style='width: 100%'>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                        </tr>
                        <tr>
                            <td>".$client_name."</td>
                            <td>".$client_email."</td>
                        </tr>
                        <tr>
                            <th colspan='2'>Mensaje</th>
                        </tr>
                        <tr>
                            <td colspan='2'>
                                <p>".$client_message."</p>
                            </td>
                        </tr>
                        </table>
                    </body>
                </html>
        ";
        //$body = "Nombre: ". $client_name . "Correo: ". $client_email . "\nMensaje" . $client_message . "/// FIN DEL MENSAJE ///";
        // Always set content-type when sending HTML email
        $header = "MIME-Version: 1.0" . "\r\n";
        $header .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $header .= 'From: Contacto Develop+ <' . $from . ">\r\n";
	    mail($emailTo, $subject, $body, $header);
    }
}

// uncomment this to set the From and Reply-To emails, then pass the $headers variable to the "mail" function below
//$headers = "From: ".$client_email." <" . $client_email . ">" . "\r\n" . "Reply-To: " . $client_email;
