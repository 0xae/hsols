<?php

namespace Admin\Backend\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ModuleType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', 'text', array(
                'label' => 'Nome'
            ))
            // ->add('createdBy')
            ->add('submit', 'submit', array(
                'label' => 'Enviar formulário',
                'attr' => array(
                    'class' => 'btn btn-success'
                )
            ));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\Backend\Entity\Module'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_backend_module';
    }
}
