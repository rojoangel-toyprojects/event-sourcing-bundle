<?php

namespace ToyProject\EventSourcingBundle\Controller;

use Entity\PaymentAggregate;
use Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PaymentController extends Controller
{
    /**
     * @param string $paymentId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($paymentId)
    {
        /** @var PaymentRepository $paymentRepository */
        $paymentRepository  = $this->get("event_sourcing.payment_repository");
        
        /** @var PaymentAggregate $payment */
        $payment = $paymentRepository->load($paymentId);
        return $this->render(
            'ToyProjectEventSourcingBundle:Payment:index.html.twig',
            [
                'payment' => $payment
            ]
        );
    }
}
