<?php

function send($i,$p){

include 'Atol.class.php';

    $invoice = (string)$i;
    $value = ((float)$p*100)/100;

    $atol = new Atol();

        if ($atol->getToken()['code'] != 2) {

        //делаем чек
        $p = Array(
            'timestamp' => date('d.m.Y H:i:s'),
            'external_id' => $invoice,
            'service' => Array(
                'inn' => $atol->inn,
                'payment_address' => '-----YOUR_PAYMENT_ADRRSS(WEBSITE)----'
            ),
            'receipt' => Array(
                'client' => Array(
                    'email' => (string)(rand(100000000,999999999).'@'.rand(100000,999999).'.ru')
                ),
                'company' => Array(
                    'email' => '-----YOUR_EMAIL-----',
                    'sno' => 'usn_income',
                    'inn' => '-----YOUR_INN-----',
                    'payment_address' => '-----YOUR_PAYMENT_ADRRSS(WEBSITE)----'
                ),
                'attributes' => Array(
                    'sno' => 'usn_income',
                    'email' => (string)(rand(100000000,999999999).'@'.rand(100000,999999).'.ru')
                ),
                'items' => Array(
                    Array (
                        'name' => (string)'Пополнение баланса',
                        'price' => $value,
                        'quantity' => 1,
                        'sum' => $value,
                        'tax' => 'none',
                        'payment_object' => 'payment',
                        'payment_method' => 'full_payment',
                        'tax_sum' => 0
                    )
                ),
                'total' => $value,
                'payments' => Array(
                    Array(
                        'type' => 1,
                        'sum' => $value
                    )
                )
            )
        );


        $rez = $atol->sendDoc('sell', $p); print_r($rez);

          $rez2 = $atol->checkDoc($rez['uuid']); print_r($rez);
 
          while($rez2['status'] == 'wait'){
            $rez2 = $atol->checkDoc($rez['uuid']);
            sleep(1);
          }
          
    }   
}