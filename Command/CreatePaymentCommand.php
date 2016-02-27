<?php

namespace ToyProject\EventSourcingBundle\Command;

use Broadway\CommandHandling\CommandBusInterface;
use Broadway\UuidGenerator\UuidGeneratorInterface;
use Command\Payment\CreateCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreatePaymentCommand extends Command
{

    /** @var UuidGeneratorInterface */
    private $uuidGenerator;

    /** @var CommandBusInterface */
    private $commandBus;

    /**
     * CreatePaymentCommand constructor.
     * @param UuidGeneratorInterface $uuidGenerator
     * @param CommandBusInterface $commandBus
     */
    public function __construct(
        UuidGeneratorInterface $uuidGenerator,
        CommandBusInterface $commandBus
    )
    {
        parent::__construct();
        $this->uuidGenerator = $uuidGenerator;
        $this->commandBus = $commandBus;
    }

    protected function configure()
    {
        $this
            ->setName('create-payment')
            ->setDescription('Creates a payment');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $paymentId = $this->uuidGenerator->generate();
        $createPayment = new CreateCommand($paymentId);
        $this->commandBus->dispatch($createPayment);

        $output->writeln(sprintf('%s payment created', $paymentId));
    }
}
