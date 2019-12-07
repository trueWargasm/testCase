<?php 

interface Notification  {
	/**
	 * Notifications send 
	 */
	public function notify() : void;

	/**
	 * Register new notification service
	 */
	public function registerService( NotificationService $service) : void;

	/**
	 * Register message composer
	 */
	public function registerMessage( MesageComposer $composer) : void;

}

interface NotificationService {

	/**
	 * Send notification using service 
	 */
	public function send() : bool;
}

interface MessageComposer {

	/**
	 * Create message
	 */
	public function compose( string $message ) : bool;


	public function getMessage() : string;
}

class NotificationService implements Notification
{
    

    public function notify(User $user, $text)
    {
        $emailNotificator = new EmailNotificator();
        $smsNotificator = new SmsNotificator();
        $emailNotificator->sendEmail($user->email, $text);
        $smsNotificator>sendSms($user->phone, $text);
    }
}

class EmailNotificator
{
    public function sendEmail($email, $text)
    { /* ... */ }
}
 
class SmsNotificator
{
    public function sendSms($phone, $text)
    { /* ... */ }
}

//Этот сервис сконфигурирован и отдан в клиентский код для выполнения рассылки
// Инициализация и конфигурация сервиса
$service = new NotificationService();
// Клиентский код с доступом к готовому к работе объекту сервиса рассылки
$text = 'Какой-то текст';
foreach ($users as $user) {
    $service->notify($user, $text);
}
