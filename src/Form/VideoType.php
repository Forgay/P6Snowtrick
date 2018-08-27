<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', TextType::class,[
                'label' => 'Url de la video'
            ])
            ->add('alt',ChoiceType::class,[
                'label' =>'hebegeur',
                'choices'=> ['YouTube'=> 'youtube','dailymotion' => 'dailymotion']
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
                $video = $event->getData();
                $form = $event->getForm();

                if($video && $video->getId() !== null) {
                    $form->add('url', HiddenType::class);
                    $form->add('alt',HiddenType::class);
                }
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
