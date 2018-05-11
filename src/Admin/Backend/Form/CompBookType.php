<?php

namespace Admin\Backend\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompBookType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('clientName')
            ->add('supplierName')
            ->add('supplierAddress')
            ->add('clientAddress')
            ->add('clientNacionality')
            ->add('clientPhone')
            ->add('clientPassport')
            ->add('clientBi')
            // ->add('annexReference')
            ->add('clientEmail', 'email')
            ->add('complaint', 'textarea', array(
                'attr' => array('rows' => 6)
            ))
            ->add('complaintDate')
            ->add('createdAt')
            ->add('createdBy')
            ->add('submit', 'submit', array(
                'label' => 'Enviar formulário',
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
            'data_class' => 'Admin\Backend\Entity\CompBook'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'admin_backend_compbook';
    }
}
