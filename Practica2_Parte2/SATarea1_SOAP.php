<?php

$user = 'sa';
$password = 'usac';

/*
*	Funcion encargada de crear un contacto
*	@name: nombre del contacto a crear
*/
function create_contact($name, $user, $password)
{
    $xml = '<x:Envelope xmlns:x="http://www.w3.org/2003/05/soap-envelope" xmlns:adm="https://api.softwareavanzado.world/media/redcore/webservices/joomla/administrator.contact.1.0.0.wsdl">
            <x:Body>
                <adm:create>
                    <name>'.$name.'</name>
                </adm:create>
            </x:Body>
        </x:Envelope>';
    
    $headers = array(
        "Content-type: text/xml;charset=\"utf-8\"",
        "Authorization: Basic ". base64_encode($user.":".$password), 
    ); 

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.softwareavanzado.world/administrator/index.php?webserviceClient=administrator&webserviceVersion=1.0.0&option=contact&api=soap");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_POST, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $doc = new DOMDocument();
    $doc->loadXML($response);
    $xpath = new DOMXpath($doc);

    return $xpath->query("//result");
}

/*
*	Funcion encargada de crear los contactos
*	@array: arreglo utilizado para
*/
function create_contacts($array, $user, $password)
{
    foreach ($array as $name) {
        $result = create_contact($name, $user, $password);
        if (count($result)>0 && $result[0]->nodeValue == 'true') {
            echo "El contacto: {$name} fue creado exitosamente <br>\n";
        }
    }
}

/*
*	Obtiene la lista de contactos
*	@filter_string: string utilizado para filtrar los datos
*/
function list_contact_filter($filter_string, $user, $password)
{
    $filter_string = urlencode($filter_string);
    
    $xml = '<x:Envelope xmlns:x="http://www.w3.org/2003/05/soap-envelope" xmlns:adm="https://api.softwareavanzado.world/media/redcore/webservices/joomla/administrator.contact.1.0.0.wsdl">
        <x:Body>
            <adm:readList>
                <filterSearch>'.$filter_string.'</filterSearch>
                <limit>100</limit>
            </adm:readList>
        </x:Body>
    </x:Envelope>';
    
    $headers = array(
        "Content-type: text/xml;charset=\"utf-8\"",
        "Authorization: Basic ". base64_encode($user.":".$password), 
    ); 

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.softwareavanzado.world/administrator/index.php?webserviceClient=administrator&webserviceVersion=1.0.0&option=contact&api=soap");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_POST, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $doc = new DOMDocument();
    $doc->loadXML($response);
    $xpath = new DOMXpath($doc);
    return $xpath->query("//list/item");
}

/*
* 	Imprime la lista de contactos
*	@array_list_contacts: array con la lista de contactos
*/
function print_list_contacts($array_list_contacts)
{
    foreach ($array_list_contacts as $contact) {
        $id = $contact->getElementsByTagName('id')[0]->nodeValue;
        $name = $contact->getElementsByTagName('name')[0]->nodeValue;
        echo "ID: {$id}, Name Contact: {$name} <br>\n";
    }
}

//array de contactos
$contacts = [
    "201612460 Contacto 1 SOAP",
    "201612460 Contacto 2 SOAP",
    "201612460 Contacto 3 SOAP",
    "201612460 Contacto 4 SOAP",
    "201612460 Contacto 5 SOAP",
    "201612460 Contacto 6 SOAP",
    "201612460 Contacto 7 SOAP",
    "201612460 Contacto 8 SOAP",
    "201612460 Contacto 9 SOAP",
    "201612460 Contacto 10 SOAP",
];

/*
*	Si se desea crear mas contactos modificar $contacts, con los contactos a crear,
* 	y mandar a llamar a la funcion create_contacts, la cual se encargara
* 	crear los contactos
*/

//imprimir titulo y llamar a la funcion de crear contactos
echo "<h1>Creación de contactos</h1> <br>\n";
create_contacts($contacts, $user, $password);
//imprimir titulo y llamar a la funcion de imprimir una lista de contactos
echo "<h1>Lista de contactos</h1> <br>\n";
print_list_contacts(list_contact_filter("201612460", $user, $password));
