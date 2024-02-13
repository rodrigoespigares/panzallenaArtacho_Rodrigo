<?php

namespace App\Form;

use App\Entity\Restaurante;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Debes estar de acuerdo con nuestros términos.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, introduce una contraseña.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Tu contraseña debe tener al menos {{ limit }} caracteres.',
                        'max' => 4096,
                    ]),
                ],
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restaurante::class,
        ]);
    }
}
