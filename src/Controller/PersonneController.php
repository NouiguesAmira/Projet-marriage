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
use App\Entity\Personne;
use App\Form\PersonneType;

class PersonneController extends AbstractController
{
     /**
     * @Rest\View()
     * @Rest\Get("/personnes")
     */
    public function getPersonnesAction(Request $request)
    {
        $personnes = $this->getDoctrine()->getManager()
                ->getRepository(Personne::class)
                ->findAll(); 
        return $personnes;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/personnes/{id}")
     */
    public function getPesonneAction($id, Request $request)
    {
        $personne = $this->getDoctrine()->getManager()
        ->getRepository(Personne::class)
        ->find($id);

        if (empty($personne)) {
            return new JsonResponse(['message' => 'Personne not found'], Response::HTTP_NOT_FOUND);
        } 
        return $personne;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/personnes")
     */
    public function postPersonnesAction(Request $request)
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($personne);
            $em->flush();
            return $personne;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/personnes/{id}")
     */
    public function removePersonneAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $personne = $em->getRepository(Personne::class)
                    ->find($request->get('id'));
        $em->remove($personne);
        $em->flush();
    }

    /**
     * @Rest\View()
     * @Rest\Put("/personnes/{id}")
     */
    public function updatePersonneAction(Request $request)
    {
        return $this->updatePersonne($request, true);
    }

    /**
     * @Rest\View()
     * @Rest\Patch("/personnes/{id}")
     */
    public function patchPersonneAction(Request $request)
    {
        return $this->updatePersonne($request, false);
    }

    private function updatePersonne(Request $request, $clearMissing)
    {
        $personne = $this->getDoctrine()->getManager()
                ->getRepository(Personne::class)
                ->find($request->get('id')); 

        if (empty($personne)) {
            return new JsonResponse(['message' => 'Personne not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(PersonneType::class, $personne);

        // Le paramètre false dit à Symfony de garder les valeurs dans notre
        // entité si l'utilisateur n'en fournit pas une dans sa requête
        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($personne);
            $em->flush();
            return $personne;
        } else {
            return $form;
        }
    }


}
