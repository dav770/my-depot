<?php

$token = $_POST['stripeToken'];
$email = $_POST['email'];
$name = $_POST['name'];
$amount = $_POST['amount'];
$currency = $_POST['currency'];

// echo print_r($_POST);
// die;

if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($name) && !empty($token))
{
    require ('stripe.php');
    $stripe = new Stripe('sk_test_51LonIAJGdQZLpN4gvon9D3oWuEha8DanKggp85TZXdVjOjqvDzLHdkUK8KvmkrjjiD4jGd49o0SKQ8COEB3NHSeK00tT8hE0Eg'); /*Clé secrète Stripe*/
    $customer = $stripe->api('customers', [
        'source' => $token,
        'description' => $name, /*Information complémentaire pour identifier les clients sur Stripe (facultatif)*/
        'email' => $email, /*Information complémentaire pour identifier les clients sur Stripe (facultatif)*/
    ]);

    /*Pour un paiement simple (pas un abonnement) */
    $charge = $stripe->api('charges', [
        'amount' => (Float)str_replace('.',',',$amount), /*Montant d'achat : 1000 = 10,00 € */
        'currency' => $currency,
        'customer' => $customer->id,
    ]);

    
    foreach($charge as $key=>$val){
        // echo ('===>'.$key.'<br><br>');
        if($key == 'status'){
            echo 'Statut du paiement : '.$val.'<br>';
        }
        if($key == 'source'){
            foreach($val as $k2=>$v2){
                if($k2 == 'id')
                    echo('ID du defaultsource customer : '.$v2.'<br>');
                if($k2 == 'customer')
                    echo('ID du customer : '.$v2.'<br>');
            }
        }

        if($key == 'paid'){
            echo'Etat paiement : '.$val.'<br>';
        }

        if ($key == 'payment_method_details'){
            foreach($val as $k3=>$v3){
                if($k3 == 'card'){
                    foreach($v3 as $k4=>$v4){
                        if($k4 == 'country'){
                            echo'inf card contry: '.$v4.'<br>';
                        }
                        if($k4 == 'exp_month'){
                            echo'inf card exp_month: '.$v4.'<br>';
                        }
                        if($k4 == 'exp_year'){
                            echo'inf card exp_year: '.$v4.'<br>';
                        }
                        
                        if($k4 == 'fingerprint'){
                            echo'inf card fingerprint: '.$v4.'<br>';
                        }
                        if($k4 == 'funding'){
                            echo'inf card funding: '.$v4.'<br>';
                        }
                        if($k4 == 'last4'){
                            echo'inf card last4: '.$v4.'<br>';
                        }
                        if($k4 == 'network'){
                            echo'inf card network: '.$v4.'<br>';
                        }
                    }
                }
                
            }
        }
    }
    die('Bravo le paiement a bien été enregistré');
}