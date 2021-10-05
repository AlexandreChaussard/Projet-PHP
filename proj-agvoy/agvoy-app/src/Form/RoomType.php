<?php

namespace App\Form;

use App\Entity\Room;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
            ->add('owner')
            ->add('regions')
            ->add('unavailableperiod')
            ->add('previewimageurl')
            ->add('adimageurl')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }

}