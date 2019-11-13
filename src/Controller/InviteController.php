<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\View\View; 
use FOS\RestBundle\View\ViewHandler;
use App\Entity\Invite;
use App\Form\InviteType;

class InviteController extends AbstractController
{
     /**
     * @Rest\View()
     * @Rest\Get("/invites")
     */
    public function getInvitesAction(Request $request)
    {
        $invites = $this->getDoctrine()->getManager()
                ->getRepository(Invite::class)
                ->findAll(); 
        return $invites;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/invites/{id}")
     */
    public function getInviteAction( Request $request)
    {
        $invite = $this->getDoctrine()->getManager()
                ->getRepository(Invite::class)
                ->find($request->get('id'));

        if (empty($invite)) {
            return new JsonResponse(['message' => 'Invite not found'], Response::HTTP_NOT_FOUND);
        } 
        return $invite;
    }
}