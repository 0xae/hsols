<?php

namespace Admin\Backend\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class StageProfileType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('moduleStage', 'entity', array(
                'class' => 'BackendBundle:ModuleStage',
                'query_builder' => function (EntityRepository $er) use ($options) {
                    $obj = $options['data'];
                    $q = $er->createQueryBuilder('u')
                            ->orderBy('u.id', 'ASC');

                    if ($obj->getModule()) {
                        $q->where('u.module = ?1')
                        ->setParameter(1, $obj->getModule()->getId());
                    }

                    return $q;
                },
                'choice_label' => 'stage.name',
            ))
            ->add('profile', 'entity', array(
                'class' => 'BackendBundle:Profile',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\Backend\Entity\StageProfile'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'admin_backend_stageprofile';
    }
}
