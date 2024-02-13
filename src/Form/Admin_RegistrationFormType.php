<?php

namespace App\Form;

use App\Entity\Restaurante;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Regex;

class Admin_RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('plainPassword', PasswordType::class, [
                                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrator' => 'ROLE_ADMIN',
                    'Pedidos' => 'ROLE_PEDIDOS',
                ],
                'multiple' => true, 
                'expanded' => true, 
                'label' => 'Roles',
            ])
            ->add('pais', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Este campo no puede estar en blanco.']),
                    new Regex([
                        'pattern' => '/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s]+$/',
                        'message' => 'El país no puede contener caracteres especiales ni números.',
                    ]),
                ],
            ])
            ->add('cp', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Este campo no puede estar en blanco.']),
                    new Positive(['message' => 'El código postal debe ser un número positivo.']),
                ],
            ])
            ->add('ciudad', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Este campo no puede estar en blanco.']),
                    new Regex([
                        'pattern' => '/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s]+$/',
                        'message' => 'La ciudad no puede contener caracteres especiales ni números.',
                    ]),
                ],
            ])
            ->add('direccion', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Este campo no puede estar en blanco.']),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9áéíóúüñÁÉÍÓÚÜÑ\s,.-]+$/',
                        'message' => 'La dirección no puede contener caracteres especiales excepto ,.-',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restaurante::class,
        ]);
    }
}
