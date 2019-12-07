<?php 

interface Notification  {
	/**
	 * Notifications send 
	 */
	public function notify(User $user ) : void;

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
	/**
	 * Get composed message
	 */
	public function getMessage() : string;
}


class NotificationService implements Notification
{
    private $serviceList = [];
    private $messageComposer;

    public function notify(User $user)
    {
	foreach($this->serviceList as $service){
	    $service->send($user, $this->messageComposer);
	}
    }

    public function registerService(NotificationService $service){
	if(!array_serach( $service, $this->serviceList )){
	    $this->serviceList[] = $service;
	} else { throw new NotificationServiceException("This service already registered");}
    }
    
    public function registerMessage(MessageComposer $message){
    	$this->messageComposer = $message;
    }
}

class EmailNotificator implements NotificationService
{
    public function send(User $user, MessageComposer $message) {
    	$this->send($user->email, $message->getMessage());
    }
	
    public function sendEmail($email, $text)
    { /* ... */ }
}
 
class SmsNotificator implements NotificationService
{

    public function send(User $user, MessageComposer $message) {
    	$this->sendSms($user->phone, $message->getMessage());
    }

    public function sendSms($phone, $text)
    { /* ... */ }
}

//Этот сервис сконфигурирован и отдан в клиентский код для выполнения рассылки
// Инициализация и конфигурация сервиса
$service = new NotificationService();
$service->registerService( new EmailNotificator() );
$service->registerService( new SmsNotificator() );

// Клиентский код с доступом к готовому к работе объекту сервиса рассылки
$composer = new PlainTextComposer();
$composer->compose('Какой-то текст');

$service->registerMessage( $composer );

foreach ($users as $user) {
    $service->notify($user);
}
