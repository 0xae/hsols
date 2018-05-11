<?php
namespace Admin\Backend\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IReclamationType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name')
            ->add('direction')
            ->add('type')
            ->add('type', 'choice', array(
                'choices'  => array(
                    'c1' => 'Ações de Formação',
                    'c2' => 'Atendimento',
                    'c3' => 'Assistência Médica',
                    'c4' => 'Equipamentos',
                    'c5' => 'Instalações',
                    'c6' => 'Limpeza',
                    'c7' => 'Segurança',
                    'c8' => 'Viaturas e logística de deslocação',
                    'c9' => 'Outros'
                ),
            ))
            ->add('factDate')
            ->add('step')            
            // ->add('annexReference')
            ->add('factDetail', 'textarea', array(
                'attr' => array('rows' => 6)
            ))
            ->add('analysisDetail', 'textarea', array(
                'attr' => array('rows' => 6),
                'required' => false
            ))
            ->add('analysisDate')
            ->add('decisionDetail', 'textarea', array(
                'attr' => array('rows' => 6),
                'required' => false                
            ))
            ->add('decisionDate')
            ->add('actionDetail', 'textarea', array(
                'attr' => array('rows' => 6),
                'required' => false                
            ))
            ->add('actionDate')
            // ->add('createdAt')
            ->add('createdBy')
            ->add('analysisResp')
            ->add('decisionResp')
            ->add('actionResp')
            ->add('typeData', 'textarea', array(
                'attr' => array('rows' => 2)
            ))
            ->add('submit', 'submit', array(
                'label' => 'Guardar',
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
            'data_class' => 'Admin\Backend\Entity\IReclamation'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'admin_backend_ireclamation';
    }
}
