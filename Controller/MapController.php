<?php

namespace AltCloud\Instance3LocationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AltCloud\Instance3LocationBundle\Entity\Map;
use AltCloud\Instance3LocationBundle\Form\MapType;

/**
 * Map controller.
 *
 */
class MapController extends Controller
{
    /**
     *  Render a map partial.
     *
     */
	public function renderPartialAction($id, $displayoptions=false)
	{
			$map = $this->getDoctrine()
				->getRepository('ACInst3LocationBundle:Map')
				->find($id);

			if (!$map) {
				throw $this->createNotFoundException('No Map found for id '.$id);
			}
		
        	return $this->render('ACInst3LocationBundle:Map:renderPartial.html.twig', array(
    							 'map' => $map, 
    							 'displayoptions' => $displayoptions));
    }

    /**
     *  Render a map.
     *
     */
	public function renderAction($id, $node=false, $displayoptions=false)
	{
			$map = $this->getDoctrine()
				->getRepository('ACInst3LocationBundle:Map')
				->find($id);

			if (!$map) {
				throw $this->createNotFoundException('No Map found for id '.$id);
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
		
        	return $this->render('ACInst3LocationBundle:Map:render.html.twig', array(
    							 'map' => $map, 
    							 'tpl' => $tpl, 
    							 'node' => $node,
    							 'displayoptions' => $displayoptions));
    }

    /**
     * Lists all Map entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('ACInst3LocationBundle:Map')->findAll();

        return $this->render('ACInst3LocationBundle:Map:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Map entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ACInst3LocationBundle:Map')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Map entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ACInst3LocationBundle:Map:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Map entity.
     *
     */
    public function newAction()
    {
        $entity = new Map();
        $form   = $this->createForm(new MapType(), $entity);

        return $this->render('ACInst3LocationBundle:Map:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Map entity.
     *
     */
    public function createAction()
    {
        $entity  = new Map();
        $request = $this->getRequest();
        $form    = $this->createForm(new MapType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_map_show', array('id' => $entity->getId())));
            
        }

        return $this->render('ACInst3LocationBundle:Map:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Map entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ACInst3LocationBundle:Map')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Map entity.');
        }

        $editForm = $this->createForm(new MapType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ACInst3LocationBundle:Map:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Map entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ACInst3LocationBundle:Map')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Map entity.');
        }

        $editForm   = $this->createForm(new MapType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_map_edit', array('id' => $id)));
        }

        return $this->render('ACInst3LocationBundle:Map:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Map entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('ACInst3LocationBundle:Map')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Map entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_map'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
