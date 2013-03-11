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

}
