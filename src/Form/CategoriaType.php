<?php

namespace App\Form;

use App\Entity\Categoria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Regex;

class CategoriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('codCat', IntegerType::class, [
            'constraints' => [
                new Positive([
                    'message' => 'El valor de codCat debe ser un número positivo.',
                ]),
            ],
        ])
        ->add('nombre', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'El nombre es obligatorio.',
                ]),
                new Regex([
                    'pattern' => '/^[a-zA-Z0-9\s]+$/',
                    'message' => 'El nombre solo puede contener letras, números y espacios.',
                ]),
            ],
        ])
        ->add('descripcion', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'La descripción es obligatoria.',
                ]),
                new Length([
                    'max' => 20,
                    'maxMessage' => 'La descripción no puede tener más de 20 caracteres.',
                ]),
                new Regex([
                    'pattern' => '/^[a-zA-Z0-9\s]+$/',
                    'message' => 'La descripción solo puede contener letras, números y espacios.',
                ]),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categoria::class,
        ]);
    }
}
