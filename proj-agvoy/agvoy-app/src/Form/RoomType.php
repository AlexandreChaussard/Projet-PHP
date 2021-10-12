<?php

namespace App\Form;

use App\Entity\Room;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RoomType extends AbstractType

{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('summary', null, ['label' => 'Nom'])
            ->add('description', null, ['label' => 'Description'])
            ->add('capacity',null, ['label' => 'Capacité'])
            ->add('superficy')
            ->add('price')
            ->add('address')
            ;

        if($options['chose_owner'])
        {
            $builder->add('owner');
        }

        $builder
            ->add('regions')
            ->add('unavailableperiod')
            ->add('adImageFile', VichImageType::class, ['required' => false])
            ->add('previewImageFile', VichImageType::class, ['required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
            'chose_owner' => false,
        ]);
        $resolver->setAllowedTypes('chose_owner', 'bool');
    }

}