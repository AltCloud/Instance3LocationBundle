<?php

namespace AltCloud\Instance3LocationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use AltCloud\Instance3LocationBundle\Entity\Location;
use AltCloud\Instance3LocationBundle\Form\LocationType;

/**
 * Location controller.
 *
 */
class LocationController extends Controller
{
    public function listAction($node=false,$map=false,$_format=false, $displayoptions=false)
    {
        $em = $this->getDoctrine()->getEntityManager();

		if(is_string($map)){
        	$locations = $em->getRepository('ACInst3LocationBundle:Location')->findBy( array( 'map' => $map ) );
        }else{
		  	$locations = $em->getRepository('ACInst3LocationBundle:Location')->findAll();
		}
		
		if (is_object($node)){
			$nodetpl = $node->getSite()->getDeftemp();
			if(is_string($nodetpl))
				$tpl=$nodetpl;
		}
		
		if(!isset($tpl)){
			// Determine tpl based on request uri, if possible
		}
		
		if(!isset($tpl)){
			// Use default tpl
			// FIXME: Move to setting somewhere
			$tpl="JMCOMFLFTBundle::layout.html.twig";
		}
		
		if($_format && $_format == 'json' ){
		
			$locations_array=array();
			foreach($locations as $location){
				$location_array['title']=$location->getTitle();	
				$location_array['description']=$location->getDescription();
				$location_array['address']=$location->getAddress();
				$location_array['coordinates']=$location->getCoordinates();
				$locations_array[]=$location_array;
			}
			$response = new Response(json_encode($locations_array));
//			$response = $this->render("ACInst3LocationBundle:Location:list.json.twig", array('locations' => $locations));
			$response->headers->set('Content-Type', 'application/json');
		
	        return $response;
		}else
	        return $this->render("ACInst3LocationBundle:Location:list.html.twig", array('locations' => $locations, 'tpl' => $tpl, 'node' => $node, 'displayoptions' => $displayoptions));

    }
    
    public function listPartialAction($map=false, $displayoptions=false)
    {
        $em = $this->getDoctrine()->getEntityManager();

		if(is_int($map)){
        	$locations = $em->getRepository('ACInst3LocationBundle:Location')->findBy( array( 'map' => $map ) );
        }else{
		  	$locations = $em->getRepository('ACInst3LocationBundle:Location')->findAll();
		}
		
        return $this->render('ACInst3LocationBundle:Location:listPartial.html.twig', array('locations' => $locations, 'displayoptions' => $displayoptions));

    }
 
    /**
     *  Render an location partial.
     *
     */
	public function renderPartialAction($id, $displayoptions=false)
	{
			$location = $this->getDoctrine()
				->getRepository('ACInst3LocationBundle:Location')
				->find($id);

			if (!$location) {
				throw $this->createNotFoundException('No Location found for id '.$id);
			}
		
        	return $this->render('ACInst3LocationBundle:Location:renderPartial.html.twig', array(
    							 'location' => $location, 
    							 'displayoptions' => $displayoptions));
    	}
    /**
     *  Render an location.
     *
     */
	public function renderAction($id, $node=false, $displayoptions=false)
	{
			$location = $this->getDoctrine()
				->getRepository('ACInst3LocationBundle:Location')
				->find($id);

			if (!$location) {
				throw $this->createNotFoundException('No Location found for id '.$id);
			}
	
			if (is_object($node)){
				$nodetpl = $node->getSite()->getDeftemp();
				if(is_string($nodetpl))
					$tpl=$nodetpl;
			}
			
			if(!isset($tpl)){
				// Determine tpl based on request uri, if possible
			}
			
			if(!isset($tpl)){
				// Use default tpl
				// FIXME: Move to setting somewhere
				$tpl="JMCOMFLFTBundle::layout.html.twig";
			}
		
        	return $this->render('ACInst3LocationBundle:Location:render.html.twig', array(
    							 'location' => $location, 
    							 'tpl' => $tpl, 
    							 'node' => $node,
    							 'displayoptions' => $displayoptions));
    }
    /**
     * Lists all Location entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('ACInst3LocationBundle:Location')->findAll();

        return $this->render('ACInst3LocationBundle:Location:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Location entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ACInst3LocationBundle:Location')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Location entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ACInst3LocationBundle:Location:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Location entity.
     *
     */
    public function newAction()
    {
        $entity = new Location();
        $form   = $this->createForm(new LocationType(), $entity);

        return $this->render('ACInst3LocationBundle:Location:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Location entity.
     *
     */
    public function createAction()
    {
        $entity  = new Location();
        $request = $this->getRequest();
        $form    = $this->createForm(new LocationType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_location_show', array('id' => $entity->getId())));
            
        }

        return $this->render('ACInst3LocationBundle:Location:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Location entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ACInst3LocationBundle:Location')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Location entity.');
        }

        $editForm = $this->createForm(new LocationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ACInst3LocationBundle:Location:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Location entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ACInst3LocationBundle:Location')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Location entity.');
        }

        $editForm   = $this->createForm(new LocationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_location_edit', array('id' => $id)));
        }

        return $this->render('ACInst3LocationBundle:Location:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Location entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('ACInst3LocationBundle:Location')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Location entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_location'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
