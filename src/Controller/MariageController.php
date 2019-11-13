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
use App\Entity\Mariage;
use App\Entity\Personne;
use App\Entity\Salle;

use App\Form\MariageType;

class MariageController extends AbstractController
{

    /**
     * @Rest\View()
     * @Rest\Get("/personnes/{id}/salles/{ids}/mariage")
     */
    public function getMariagesAction(Request $request)
    {
        $personne = $this->getDoctrine()->getManager()
                ->getRepository(Personne::class)
                ->find($request->get('id')); 
        $salle = $this->getDoctrine()->getManager()
                ->getRepository(Salle::class)
                ->find($request->get('ids')); 
        
                
        if (empty($salle)) {
            return $this->salleNotFound();
        }
        elseif (empty($personne)) {
            return $this->personneNotFound();
        }
        else
        
        return  $personne->getMariage();
       
        
    }

    private function salleNotFound()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Salle not found'], Response::HTTP_NOT_FOUND);
    }
    private function personneNotFound()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'personne not found'], Response::HTTP_NOT_FOUND);
    }
}