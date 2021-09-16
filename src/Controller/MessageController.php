<?php

namespace App\Controller;

use App\Entity\User;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route as BaseRoute;
use App\Entity\Message;
use App\Form\MessageType;

/**
 * Message controller.
 * @BaseRoute("/api", name="api_")
 */
class MessageController extends AbstractFOSRestController
{
    /**
     * Lists all Messages.
     * @Rest\Get("/messages")
     *
     * @return Response
     */
    public function getMessageAction()
    {
        /** @var User $user */
        $user = $this->getUser();
        $idUser = $user->getId();
        $messageRepository = $this->getDoctrine()->getRepository(Message::class);
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $users = $userRepository->findAll();
        $messages = $messageRepository->findBySenderOrReceiver($user);
        $threads = [];
        foreach ($messages as $message) {
            $idSender = $message->getSender()->getId();
            $idReceiver = $message->getReceiver()->getId();
            $idThread = $idSender === $idUser ? $idReceiver : $idSender;
            $threads[$idThread][] = $message;
        }
        foreach ($users as $u) {
            if (empty($threads[$u->getId()])){
                $threads[$u->getId()] = [];
            }
        }
        return $this->handleView($this->view($threads));
    }

    /**
     * Create Message.
     * @Rest\Post("/message")
     *
     * @return Response
     */
    public function postMessageAction(Request $request)
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }
}