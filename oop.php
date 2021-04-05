<?php
class User
{
    protected $name;
    protected $age;

    public function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }
}

class Customer extends User
{
    private $balance;

    public function __construct($name, $age, $balance)
    {
        parent::__construct($name, $age);
        $this->balance = $balance;
    }

    public function pay($amount)
    {
        $this->balance -= $amount;
        return $this->name . " payed $amount$ " . 'balance = ' . $this->balance;
    }
    public function __get($proparety)
    {
        if (property_exists($this, $proparety))
            return $this->$proparety;
    }
}

$customer1 = new Customer('basil', 28, 1000);
echo $customer1->pay(100);
echo '<br>';
echo $customer1->__get('balance');
// echo $customer1->hh;
