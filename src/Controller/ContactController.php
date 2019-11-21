<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index()
    {
        return $this->render('contact/index.html.twig');
    }

    /**
     * @param Request $request
     * @param \Swift_Mailer $mailer
     *
     * @Route("/send", name="send")
     *
     * @return RedirectResponse
     */
    public function send(Request $request, \Swift_Mailer $mailer)
    {
        $name = $request->get('name');
        $from = $request->get('email');
        $subject = $request->get('subject');
        $message = $request->get('message');

        $message = (new \Swift_Message($subject))
            ->setFrom([$from => $name])
            ->setTo('kravets.photographer@gmail.com')
            ->setBody(
                $message,
                'text/html'
            );

        $result = $mailer->send($message);

        if ($result) {
            $this->addFlash('success', 'Your mail successfully sent!');
        } else {
            $this->addFlash('danger', 'Oops, something went wrong:( You can contact me at the contacts listed below');
        }

        return $this->redirectToRoute('contact');
    }
}
