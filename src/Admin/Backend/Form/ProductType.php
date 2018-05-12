<?php

namespace Admin\Backend\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name')
            ->add('description')
            ->add('picture')
            ->add('price')
            ->add('inStock')
            ->add('obs')
            ->add('createdAt')
            ->add('createdBy')
            ->add('category')
            ->add('annexReference')
            ->add('submit', 'submit', array(
                'label' => 'Enviar',
                'attr' => array(
                    'class' => 'btn btn-success',
                    'ng-click' => 'onSubmitForm()',
                    'id' => 'save-product'
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\Backend\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'admin_backend_product';
    }
}