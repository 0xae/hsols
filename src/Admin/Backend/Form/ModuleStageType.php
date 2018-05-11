<?php

namespace Admin\Backend\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ModuleStageType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
        ->add('module', 'entity', array(
            'class' => 'BackendBundle:Module',
            'query_builder' => function (EntityRepository $er) use ($options) {
                $qb=$er->createQueryBuilder('u');
                return $qb->orderBy('u.name', 'ASC');
            },
            'choice_label' => 'name',
        ))
        ->add('stage', 'entity', array(
            'class' => 'BackendBundle:Stage',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                ->orderBy('u.name', 'ASC');
            },
            'choice_label' => 'name',
        ))
        ->add('createdBy', 'entity', array(
            'class' => 'BackendBundle:User',
            'query_builder' => function (EntityRepository $er) use ($options) {
                $qb=$er->createQueryBuilder('u');
                if ($options['data'] && $options['data']->getCreatedBy()) {
                    $qb->where('u.id = ' . $options['data']->getCreatedBy()->getId());
                }

                return $qb->orderBy('u.name', 'ASC');                
            },
            'choice_label' => 'name',
        ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\Backend\Entity\ModuleStage'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_backend_modulestage';
    }
}
