<?php
/*
5. Интернет магазин =-

a. Опишите классы
■ Order - Заказ, должен содержать корзину
■ Basket - Корзина, должен массив товаров с указанием количества каждого
■ Product - Товар, у каждого товара есть название и цена, которые должны быть
проинициализированы в конструкторе

b. Класс Order должен содержать два метода
■ getBasket() - возвращает корзину заказа
■ getPrice() - возвращает общую стоимость заказа

c. Класс Basket должен следующие методы
■ addProduct(Product $product, $quantity) - добавляет товар в корзину
■ getPrice() - возвращает стоимость товаров в корзине
■ describe() - выводит или возвращает информацию о корзине, в виде строки:
"<Наименование товара> - <Цена одной позиции> - <Количество>"

e. Реализуйте все методы =-

g. Выведите информацию о корзине этого заказа и выведите общую стоимость заказа

h. Создайте нового клиента "Николай Николаича" - из предыдущего задания (не копируя описание
его класса в этот файл) и отправьте ему уведомление с текстом:
"для вас создан заказ, на сумму: <сумма заказа> Состав: <информация о корзине>"

*/

namespace Ecommerce;

include 'notification.php';
use Notifications\User as User;

class Order 
{
	public $basket;

	public function __construct(Basket $basket)
	{
		$this->basket = $basket;
	}

	public function getBasket()
	{
		return $this->basket;
	}

	public function getPrice()
	{
		return $this->getBacket()->getPrice();
	}
}

class Basket
{
	public $products = [];

	public function addProduct(Product $product, int $quantity)
	{
		$this->products[] = [
			'product' => $product,
			'quantity' => $quantity,
		];
	}

	public function getPrice()
	{
		$total = 0;
		foreach ($this->products as $product) {
			$total += $product['product']->getPrice() * $product['quantity'];
		}
		return $total;
	}

	public function describe()
	{
		$describe = null;
		foreach ($this->products as $id => $product) {
			$describe .= $product['product']->getName().' - '.$product['product']->getPrice().' - '.$product['quantity'].' шт.</br>';
		}
		return $describe;
	}
}

class Product
{
	public $name;
	public $price;

	public function __construct(string $name, int $price)
	{
		$this->name = $name;
		$this->price = $price;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getPrice()
	{
		return $this->price;
	}
}

$product1 = new Product ('MacBook 2020', 80000);
$product2 = new Product ('iPhone 11', 30000);
$product3 = new Product ('Mi Band 5', 2500);

$basket = new Basket();
$basket->addProduct($product1, 3);
$basket->addProduct($product2, 4);
$basket->addProduct($product3, 10);

$order = new Order($basket);

echo '<hr>';

$user = new User('Николай Николаича', 'kolya@email.ru');
$user->notify('для вас создан заказ, на сумму: '.$basket->getPrice().' Состав: <BR>'.$basket->describe());
