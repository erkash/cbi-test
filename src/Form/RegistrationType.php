<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'required' => false
            ])
            ->add('username', TextType::class, [
                'required' => false
            ])
            ->add('password', PasswordType::class, [
                'required' => false
            ])
            ->add('confirm_password', PasswordType::class, [
                'required' => false
            ])
            ->add('name', TextType::class, [
                'required' => false
            ])
            ->add('lastName',TextType::class, [
                'required' => false
            ])
            ->add('patronymic', TextType::class, [
                'required' => false
            ])
            ->add('gender', ChoiceType::class,  [
                 'choices' => [
                     'M' => 'male',
                     'F' => 'female'
                 ],
                 'expanded' => true,
                 'multiple' => false
             ])
            ->add('country', CountryType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
