<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 28/08/2018
 * Time: 11:47
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Password', 	PasswordType::class, array(
                'label' => 'Mot de passe actuel'
            ))
            ->add('plainPassword', 	RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe doit être identique.',
                'required' => true,
                'first_options'  => array('label' => 'Nouveau mot de passe'),
                'second_options' => array('label' => 'Confirmation du nouveau mot de passe'),
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}