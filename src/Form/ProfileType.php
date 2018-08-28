<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 27/08/2018
 * Time: 14:55
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\Catalogue\OperationInterface;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 	TextType::class, array(
                'label' => 'Nom d\'utilisateur'
            ))
            ->add('email', 		EmailType::class)
            ->add('avatar', 	AvatarType::class, array(
                'required' => false
            ))
        ;
    }

    /**
     * @param OperationInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true
        ]);
    }
}