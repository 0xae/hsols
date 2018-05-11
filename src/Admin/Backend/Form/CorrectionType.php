<?php

namespace Admin\Backend\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class CorrectionType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('source', 'choice', array(
                'choices'  => array(
                    'audit' => 'Auditoria da qualidade',
                    'recl' => 'Reclamacao',
                    'nci' => 'NC Interna',
                ),
                'expanded' => true
            ))
            ->add('actionType', 'choice', array(
                'choices'  => array(
                    'nc' => 'NC',
                    'om' => 'OM',
                    'pnc' => 'PNC',
                ),
                'expanded' => true
            ))
            ->add('actionDescription', 'textarea', array(
                'attr' => array('rows' => 6)
            ))
            ->add('actionDate')
            ->add('actionAuthor')            
            ->add('causeDescription', 'textarea', array(
                'attr' => array('rows' => 6)
            ))
            ->add('causeDate')
            ->add('causeResp')
            
            ->add('closeFinished', 'choice', array(
                'choices'  => array(
                    '1' => 'Sim',
                    '0' => 'Nao'
                ),
                'expanded' => true                
            ))
            ->add('closeDate2')
            ->add('closeEficacy', 'choice', array(
                'choices'  => array(
                    '1' => 'Sim',
                    '0' => 'Nao'
                ),
                'expanded' => true                
            ))
            ->add('closeAction')
            ->add('closeInDate')
            ->add('closeDate')
            ->add('irecl', 'entity', array(
                'class' => 'BackendBundle:IReclamation',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                      ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'objCode'                
            ))          
            ->add('implResp')
            ->add('measure')
            ->add('dueDate')
            // ->add('implResp')
            ->add('implDate')            
            ->add('closeResp')
            ->add('submit', 'submit', array(
                'label' => 'Enviar formulário',
                'attr' => array(
                    'class' => 'btn btn-success',
                    'ng-click' => 'onSubmitForm()'
                )
            ))
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\Backend\Entity\Correction'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_backend_correction';
    }
}
