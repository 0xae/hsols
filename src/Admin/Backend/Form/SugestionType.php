<?php

namespace Admin\Backend\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Admin\Backend\Entity\Model;

use Doctrine\ORM\EntityRepository;

class SugestionType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('type', 'choice', array(
                    'choices'  => array(
                        Model::RECLAMATION_EXTERN => 'Reclamação externa',
                        Model::SUGESTION => 'Sugestão'
                    ),
            ))
            ->add('name', 'text', array(
                'required' => true
            ))
            ->add('address')
            ->add('phone')
            ->add('entity')            
            ->add('email', 'email', array(
                'required'=>false
            ))
            ->add('description', 'textarea', array(
                'attr' => array(
                    'class' => 'my-textarea text-editor',
                    'rows' => 6,
                    'value' => '...'
                )
            ))
            ->add('date')
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
            'data_class' => 'Admin\Backend\Entity\Sugestion'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'admin_backend_sugestion';
    }
}
