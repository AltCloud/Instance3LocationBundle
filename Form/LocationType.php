<?php

namespace AltCloud\Instance3LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', 'text', array(
    							    'required' => false,
									)
				 )
            ->add('address', 'text', array(
    							    'required' => false,
									)
				 )
            ->add('coordinates', 'text', array(
    							    'required' => false,
									)
				 )
			->add('media', 'entity', array(
    								'class' => 'ACInst3MediaBundle:Media',
    							    'required' => false,
    								'property' => 'title'	
									)
				 )
			->add('map', 'entity', array(
    								'class' => 'ACInst3LocationBundle:Map',
    							    'required' => false,
    								'property' => 'title'	
									)
				 )
	        ;
    }

    public function getName()
    {
        return 'altcloud_instance3locationbundle_locationtype';
    }
}
