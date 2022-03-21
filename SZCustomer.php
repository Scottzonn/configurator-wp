<?php 

class SZCustomer {

    private string $firstName;
    private string $surname;
    private string $phone;
    private string $email;
    private string $address;
    private boolean $newsletter;
    private string $deliveryMethod;
    private string $postcode;
    private string $dealerId;

    function __construct(array $jsonData) {
        foreach($jsonData['customer'] as $key => $val) {
            if(property_exists(__CLASS__, $key)) {
                $this->$key = $val;
            }
        }
    }
}
