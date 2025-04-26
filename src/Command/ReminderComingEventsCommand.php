<?php

namespace App\Command;

use DateTime;
use DateInterval;
use Symfony\Component\Mime\Email;
use App\Repository\EventRepository;
use App\Repository\RegistrationRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'coming:events')]
class ReminderComingEventsCommand extends Command
{
    readonly EventRepository $repoE;
    readonly RegistrationRepository $repoR;
    private MailerInterface $mailer;

    public function __construct(
        EventRepository $repoE, 
        RegistrationRepository $repoR,
        MailerInterface $mailer
        ) 
    {
        parent::__construct();
        $this->repoE = $repoE;
        $this->repoR = $repoR;
        $this->mailer = $mailer;
    }
    // TODO vérifier ce truc
    protected function execute(InputInterface $input, OutputInterface $output): int
    {        
        $today = date("Y-m-d h:i:s");
        $date = new DateTime($today);
        $day = new DateInterval('P1D');        
        $tomorrow = $date->add($day);
        $events = $this->repoE->findComingEventsAtDate($tomorrow->format('Y-m-d'));       
        
        foreach ($events as $event) {

            $regs =  $this->repoR->getRegistrationsByEvent($event);

            foreach ($regs as $reg) {
                
                $email = (new Email())
                ->from('zenith.kings77@gmail.com')
                ->to($reg->getUser()->getEmail())
                ->subject('RAPPEL: évènement '.$event->getTitle())
                ->text('Attention demain commence l\'évènement '.$event->getTitle());        
            
                $this->mailer->send($email);
            }            
        }

        $output->writeln('Whoa!');        
        $output->write('La commande a bien été exécutée, ');
        $output->write('les inscrits recevront un mail!');

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            // the command description shown when running "php bin/console list"
            ->setDescription('Remind 24h before comings events')
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to emmit mail for comings events just 24h before...')
        ;
    }
}