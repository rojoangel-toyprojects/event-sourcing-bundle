<?php


namespace ToyProject\EventSourcingBundle\Command;


use Broadway\CommandHandling\CommandBusInterface;
use Command\Payment\CaptureCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CapturePaymentCommand extends Command
{
    /** @var CommandBusInterface */
    private $commandBus;

    /**
     * @param CommandBusInterface $commandBus
     */
    public function __construct(CommandBusInterface $commandBus)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
    }

    protected function configure()
    {
        $this
            ->setName('capture-payment')
            ->setDescription('Captures a payment')
            ->addArgument(
                'id',
                InputArgument::REQUIRED,
                'Payment Id to capture'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $paymentId = $input->getArgument('id');
        $capturePayment = new CaptureCommand($paymentId);
        $this->commandBus->dispatch($capturePayment);

        $output->writeln(sprintf('%s payment captured', $paymentId));
    }
}
