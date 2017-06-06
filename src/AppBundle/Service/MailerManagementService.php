<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Response;


class MailerManagementService 
{
    public function getMailerService($order, $emailBody)
    {
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
          ->setUsername('wubii.wu')
          ->setPassword('wwemmorgbsphwxuq')
        ;

        $mailer = \Swift_Mailer::newInstance($transport);

        $logger = new \Swift_Plugins_Loggers_EchoLogger();
        $mailer->registerPlugin(new \Swift_Plugins_LoggerPlugin($logger));


        $message = \Swift_Message::newInstance('Louvre')
          ->setFrom(array('wubii.wu@gmail.com' => 'Louvre'))
          ->setSubject('Vos billets pour le Louvre')
          ->setTo(array($order->getEmail()))
          ->setBody(
              $emailBody,
              'text/html'
            );

        // Send the message
        $result = $mailer->send($message);
    }
}