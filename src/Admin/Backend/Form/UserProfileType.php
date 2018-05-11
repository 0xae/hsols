<?php

namespace Admin\Backend\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class UserProfileType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('user', 'entity', array(
                'class' => 'BackendBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                              ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name'                
            ))
            ->add('profile', 'entity', array(
                'class' => 'BackendBundle:Profile',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                              ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name'                
            ))
            ->add('submit', 'submit', array(
                'label' => 'Adicionar',
                'attr' => array(
                    'class' => 'btn btn-success'
                )
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\Backend\Entity\UserProfile'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'admin_backend_userprofile';
    }
}
