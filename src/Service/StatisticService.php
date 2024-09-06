<?php

namespace App\Service;

use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class StatisticService
{
    private EntityManagerInterface $entityManager;
    private MailerInterface $mailer;
    private ContainerBagInterface $params;

    public function __construct(
        EntityManagerInterface $entityManager,
        MailerInterface $mailer,
        ContainerBagInterface $params,
    ) {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
        $this->params = $params;
    }

    public function run(): string
    {
        $top10 = $this->entityManager->getRepository(News::class)->findBy(
            array(),
            array('views' => 'ASC'),
            10
        );

        $response = [];
        foreach ($top10 as $news){
            $response[] = '#'.$news->getId().'- '.$news->getTitle();
        }
        $textResponse = implode("\n",$response);

        return $this->sendmail($textResponse);

    }

    private function sendmail($content): bool
    {
        $email = (new Email())
            ->from('hello@example.com')
            ->to($this->params->get('app.email_receiver'))
            ->subject('Weekly top 10')
            ->text($content)
            ->html('<p>'.$content.'</p>');

        $this->mailer->send($email);

        return true;
    }

}
