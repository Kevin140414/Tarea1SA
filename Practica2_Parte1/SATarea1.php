<?php

/*
*	Funcion encargada de crear un contacto
*	@name: nombre del contacto a crear
*/
function create_contact($name)
{
    $contact = [
        'name' => $name,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.softwareavanzado.world/index.php?option=com_contact&webserviceVersion=1.0.0&webserviceClient=administrator&list[limitstart]=10&api=Hal");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $contact);
    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response);
    return ['result' => $json->result, 'id' => $json->id];
}

/*
*	Funcion encargada de crear los contactos
*	@array: arreglo utilizado para
*/
function create_contacts($array)
{
    foreach ($array as $name) {
        $result = create_contact($name);
        if ($result['result'] == 1) {
            echo "El contacto: {$name} fue creado exitosamente con ID: {$result['id']}\n";
        }
    }
}

/*
*	Obtiene la lista de contactos
*	@filter_string: string utilizado para filtrar los datos
*/
function list_contact_filter($filter_string)
{
    $filter_string = urlencode($filter_string);
    $authorization = "Authorization: Bearer fb5089840031449f1a4bf2c91c2bd2261d5b2f122bd8754ffe23be17b107b8eb103b441de3771745";

    $ch = curl_init();
    $headers = array(
        'Accept' => 'application/json',
        'Accept-Language' => 'en_US',
        "grant_type=client_credentials"
    );

    $data =
    'client_id=' . 'sa' . '&' .
    'client_secret=' . ' fb5089840031449f1a4bf2c91c2bd2261d5b2f122bd8754ffe23be17b107b8eb103b441de3771745' . '&' .
    "grant_type=client_credentials";

    curl_setopt($ch, CURLOPT_URL, "https://api.softwareavanzado.world/index.php?option=com_contact&webserviceVersion=1.0.0&webserviceClient=administrator&filter[search]={$filter_string}&api=Hal");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //curl_setopt($ch, CURLOPT_HEADER, 0);
    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response);
    print_r($response);
    return $json->_embedded->item;
}

/*
* 	Imprime la lista de contactos
*	@array_list_contacts: array con la lista de contactos
*/
function print_list_contacts($array_list_contacts)
{
    foreach ($array_list_contacts as $contact) {
        echo "ID: {$contact->id}, Name Contact: {$contact->name}\n";
    }
}

$contacts = [
    "201612460 Contacto 1",
    "201612460 Contacto 2",
    "201612460 Contacto 3",
    "201612460 Contacto 4",
    "201612460 Contacto 5",
    "201612460 Contacto 6",
    "201612460 Contacto 7",
    "201612460 Contacto 8",
    "201612460 Contacto 9",
    "201612460 Contacto 10",
];

/*
*	Si se desea crear mas contactos modificar $contacts, con los contactos a crear
* 	y descomentar, o mandar a llamar a la funcion create_contacts, la cual se encargara
* 	crear los contactos
*/
//create_contacts($contacts);

print_list_contacts(list_contact_filter("201612460"));
