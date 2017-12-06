<?php

/*
 * This file is part of the Novo SGA project.
 *
 * (c) Rogerio Lino <rogeriolino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Novosga\MonitorBundle\Form;

use Doctrine\ORM\EntityRepository;
use Novosga\Entity\Prioridade;
use Novosga\Entity\Servico;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TransferirType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $servicos = $options['servicos'];
        
        $builder
            ->add('servico', EntityType::class, [
                'class' => Servico::class,
                'choices' => $servicos,
                'placeholder' => '',
                'label' => 'transferir.type.servico',
                'translation_domain' => 'NovosgaMonitorBundle',
            ])
            ->add('prioridade', EntityType::class, [
                'class' => Prioridade::class,
                'query_builder' => function (EntityRepository $repo) {
                        return $repo->createQueryBuilder('e')
                                ->where('e.ativo = TRUE')
                                ->orderBy('e.peso', 'ASC')
                                ->addOrderBy('e.nome', 'ASC');
                },
                'placeholder' => '',
                'label' => 'transferir.type.prioridade',
                'translation_domain' => 'NovosgaMonitorBundle',
            ])
        ;
    }
    
    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setRequired('servicos');
    }

    
    public function getBlockPrefix()
    {
        return null;
    }
}
