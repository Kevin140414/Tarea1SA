<?php

/*
*   Tipo de concesión de credenciales de cliente
*   utilizando el client_id y client_secret
*/
$client_id = 'sa';
$client_secret = 'fb5089840031449f1a4bf2c91c2bd2261d5b2f122bd8754ffe23be17b107b8eb103b441de3771745';
$grant_type = 'client_credentials';

/*
*	Funcion encargada de crear un contacto
*	@name: nombre del contacto a crear
*/
function create_contact($name, $token)
{
    $contact = [
        'name' => $name,
    ];

    $authorization = "Authorization: Bearer ".$token; // Prepare the authorisation token

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.softwareavanzado.world/index.php?option=com_contact&webserviceVersion=1.0.0&webserviceClient=administrator&api=Hal");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($contact));
    curl_setopt($ch, CURLOPT_POST, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response);
    return ['result' => $json->result, 'id' => $json->id];
}

/*
*	Funcion encargada de crear los contactos
*	@array: arreglo utilizado para
*/
function create_contacts($array, $token)
{
    foreach ($array as $name) {
        $result = create_contact($name, $token);
        if ($result['result'] == 1) {
            echo "El contacto: {$name} fue creado exitosamente con ID: {$result['id']} <br>\n";
        }
    }
}

/*
*	Obtiene la lista de contactos
*	@filter_string: string utilizado para filtrar los datos
*/
function list_contact_filter($filter_string, $token)
{
    $filter_string = urlencode($filter_string);
    $authorization = "Authorization: Bearer ".$token; // Prepare the authorisation token
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.softwareavanzado.world/index.php?option=com_contact&webserviceVersion=1.0.0&webserviceClient=administrator&filter[search]={$filter_string}&list[limit]=100&api=Hal");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response);
    return $json->_embedded->item;
}

/*
* 	Imprime la lista de contactos
*	@array_list_contacts: array con la lista de contactos
*/
function print_list_contacts($array_list_contacts)
{
    foreach ($array_list_contacts as $contact) {
        echo "ID: {$contact->id}, Name Contact: {$contact->name} <br>\n";
    }
}


/*
*   Obtiene el token mediante la autorización del servidor, validando si el cliente_id y
*   cliente_secret son validos.
*   @client_id
*   @client_secret
*   @grant_type
*/
function get_bearer_token($client_id, $client_secret, $grant_type)
{
    $data = [
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'grant_type' => $grant_type
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.softwareavanzado.world/index.php?option=token&api=oauth2");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response);
    return $json->access_token;
}

//array de contactos
$contacts = [
    "201612460 Contacto 1 Token SA",
    "201612460 Contacto 2 Token SA",
    "201612460 Contacto 3 Token SA",
    "201612460 Contacto 4 Token SA",
    "201612460 Contacto 5 Token SA",
    "201612460 Contacto 6 Token SA",
    "201612460 Contacto 7 Token SA",
    "201612460 Contacto 8 Token SA",
    "201612460 Contacto 9 Token SA",
    "201612460 Contacto 10 Token SA",
];

/*
*	Si se desea crear mas contactos modificar $contacts, con los contactos a crear,
* 	y mandar a llamar a la funcion create_contacts, la cual se encargara
* 	crear los contactos
*/

//llamada para obtener el token
$token = get_bearer_token($client_id, $client_secret, $grant_type);
//imprimir titulo y llamar a la funcion de crear contactos
echo "<h1>Creación de contactos</h1> <br>\n";
create_contacts($contacts, $token);
//imprimir titulo y llamar a la funcion de imprimir una lista de contactos
echo "<h1>Lista de contactos</h1> <br>\n";
print_list_contacts(list_contact_filter("201612460", $token));
