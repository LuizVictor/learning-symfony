<?php

namespace App\Form;

use App\Dto\SeriesCreateDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeriesCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('seasons', type: IntegerType::class)
            ->add('episodesPerSeason', type: IntegerType::class, options: ['label' => 'Episodes per season'])
            ->add('coverImage', FileType::class, ['mapped' => false])
            ->add('save', SubmitType::class, ['label' => $options['is_update'] ? 'Update' : 'Create'])
            ->setMethod($options['is_update'] ? 'PUT' : 'POST');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SeriesCreateDto::class,
            'is_update' => false
        ]);
    }
}
