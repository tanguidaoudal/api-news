<?php


namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Formulaire de création d'un utilisateur
        $builder->add(
            'email', EmailType::class, [
                'label' => 'Email :',
                'attr' => [
                    'placeholder' => "Votre email"
                ]
            ]
        )->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => "Erreur sur le second mot de passe",
            'first_options' => [
                'label' => 'Mot de passe'
            ],
            'second_options' => [
                'label' => "Confirmez le mot de passe"
            ]

        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
