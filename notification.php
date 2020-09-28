<?php
/*
Уведомления для клиента

a. Опишите классы User - пользователь, у пользователя обязательно должно быть указано ФИО и
email, а также могут быть указаны, а могут и нет пол, возраст и телефон, которые должны быть
проинициализированы в конструкторе

b. Опишите класс Notification - уведомление. У него должно быть три свойства, все являются
обязательными и должны быть установлены в конструкторе

■ receiver - имя получателя,
■ via - канал уведомления,
■ to - адрес получателя (номер телефона или значение email)

c. Создайте и реализуйте метод send класса Notification:
■ send(....) - выводит строку "Уведомление клиенту: <ФИО> на <канал уведомления> (<email
или телефон клиента>): <message>", подумайте какие параметры должен принимать этот
метод. Например: "Уведомление клиенту: Владимир Николаевич на email
(user1@email.com): goodbye"

d. создайте и реализуйте методы класса пользователя User
■ notifyOnEmail($message) - Создает объект класса Notification и вызывает его метод send()
■ notifyOnPhone($message) - Создает объект класса Notification и вызывает его метод send()
■ notify($message) - отправляет сообщение на все каналы, доступные пользователю, описание
ниже.
■ censor($message) - производит цензуру сообщения

PS Не забывайте указывать уровни доступа к вашим методам, у каждого метода должен быть указан
свой уровень доступа (инкапсуляция), о ней мы подробнее расскажем в следующем уроке.

e. Описание метода notify($message): в случае если мы не уверены, что клиенту есть 18 лет - этот
метод должен произвести цензуру сообщения (придумайте любую реализацию метода censor()),
затем должен отправить уведомление клиенту на email и на телефон, если телефон указан.

f. Создайте Разных пользователей и отправьте им уведомления (вызвав только метод notify).
Пользователи должны быть созданы так, чтобы был случай, когда не был указан телефон и когда
бы был, а были случаи когда клиенту есть 18 и нет.

*/

namespace Notifications;

class User
{
	public $name;
	public $email;
	public $gender;
	public $age;
	public $phone;

	function __construct($name, $email, $gender = null, $age = null, $phone = null)
	{
		$this->name = $name;
		$this->email = $email;
		
		$this->gender = $gender;
		$this->age = $age;
		$this->phone = $phone;
	}

	private function notifyOnEmail($msg)
    {
        $notify = new Notification($this->name, 'email', $this->email);
		$notify->send($msg);
    }

    private function notifyOnPhone($msg)
    {
    	$notify = new Notification($this->name, 'phone', $this->phone);
    	$notify->send($msg);
    }

	public function notify($msg)
	{
		if ($this->age < 18 || !isset($this->age)) {
			$msg = $this->censor($msg);
		}

		$this->notifyOnEmail($msg);
		
		if ($this->phone) {
			$this->notifyOnPhone($msg);
		}
	}

	private function censor($msg)
	{
		$censor_list = [ 'fuck', 'bullshit', 'sucks' ];

		foreach ($censor_list as $item) {
		$msg = str_replace ($item, '***', $msg);
		}
		return $msg;
	}
}

class Notification
{
	public $receiver;
	public $via;
	public $to;

	function __construct($receiver, $via, $to)
	{
		$this->receiver = $receiver;
		$this->via = $via;
		$this->to = $to;
	}

	public function send($msg)
	{
		echo "Уведомление клиенту: $this->receiver на $this->via ($this->to): $msg </br>";
	}
}