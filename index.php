<?php

// Sujeto Observable
class Order {
    private $observers = [];
    private $status;

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer) {
        $index = array_search($observer, $this->observers);
        if ($index !== false) {
            unset($this->observers[$index]);
        }
    }

    public function setStatus($status) {
        $this->status = $status;
        $this->notify();
    }

    public function getStatus() {
        return $this->status;
    }

    public function notify() {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}

// Observador
interface Observer {
    public function update(Order $order);
}

// Observador Concreto: Cliente
class Customer implements Observer {
    public function update(Order $order) {
        echo "El estado de su pedido ha cambiado a: " . $order->getStatus() . "\n";
    }
}

// Observador Concreto: Personal de Servicio al Cliente
class CustomerService implements Observer {
    public function update(Order $order) {
        echo "Se ha actualizado el estado del pedido a: " . $order->getStatus() . "\n";
        echo "Por favor, tome las medidas necesarias para atender al cliente.\n";
    }
}

// Uso del patrón Observer
$order = new Order();
$customer = new Customer();
$customerService = new CustomerService();

$order->attach($customer);
$order->attach($customerService);

$order->setStatus("En proceso de envío");
$order->setStatus("Entregado");

$order->detach($customerService);

$order->setStatus("Reembolsado");


?>