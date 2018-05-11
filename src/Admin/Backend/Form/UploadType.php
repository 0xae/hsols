<?php

namespace Admin\Backend\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UploadType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('description')
            ->add('reference')
            ->add('context')
            ->add('file', 'file', array(
                    'label' => 'Anexar documento',
                    'required' => true,
                )
            )
            ->add('submit', 'submit', array(
                'label' => 'Enviar formulário',
                'attr' => array(
                    'class' => 'btn btn-success',
                    'ng-click' => 'onSubmitForm()'
                )
            ))
            ->add('annexType')
            // ->add('createdAt')
            // ->add('createdBy')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\Backend\Entity\Upload'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'admin_backend_upload';
    }
}
