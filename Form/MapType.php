<?php

namespace AltCloud\Instance3LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MapType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
        ;
    }

    public function getName()
    {
        return 'altcloud_instance3locationbundle_maptype';
    }
}
