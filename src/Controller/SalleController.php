<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\View\View; 
use FOS\RestBundle\View\ViewHandler;
use App\Entity\Salle;
use App\Form\SalleType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SalleController extends AbstractController
{
    /**
     * @Rest\View()
     * @Rest\Get("/salles")
     */
    public function getSallesAction(Request $request)
    {
        $salles = $this->getDoctrine()->getManager()
                ->getRepository(Salle::class)
                ->findAll(); 
        return $salles;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/salles/{id}")
     */
    public function getSalleAction($id, Request $request)
    {
        $salle = $this->getDoctrine()->getManager()
        ->getRepository(Salle::class)
        ->find($id);

        if (empty($salle)) {
            return new JsonResponse(['message' => 'Salle not found'], Response::HTTP_NOT_FOUND);
        } 
        return $salle;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/salles")
     */
    public function postPersonnesAction(Request $request)
    {
        $salle = new Salle();
        $form = $this->createForm(SalleType::class, $salle);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($salle);
            $em->flush();
            return $salle;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/salles/{id}")
     */
    public function removeSalleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $salle = $em->getRepository(Salle::class)
                    ->find($request->get('id'));
        $em->remove($salle);
        $em->flush();
    }

    /**
     * @Rest\View()
     * @Rest\Put("/salles/{id}")
     */
    public function updateSalleAction(Request $request)
    {
        return $this->updateSalle($request, true);
    }

    /**
     * @Rest\View()
     * @Rest\Patch("/salles/{id}")
     */
    public function patchSalleAction(Request $request)
    {
        return $this->updateSalle($request, false);
    }

    private function updateSalle(Request $request, $clearMissing)
    {
        $salle = $this->getDoctrine()->getManager()
                ->getRepository(Salle::class)
                ->find($request->get('id')); 

        if (empty($salle)) {
            return new JsonResponse(['message' => 'Salle not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(SalleType::class, $salle);

        // Le paramètre false dit à Symfony de garder les valeurs dans notre
        // entité si l'utilisateur n'en fournit pas une dans sa requête
        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($salle);
            $em->flush();
            return $salle;
        } else {
            return $form;
        }
    }
}
