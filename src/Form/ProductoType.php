<?php

namespace App\Form;

use App\Entity\Categoria;
use App\Entity\Producto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('codProd', IntegerType::class, [
            'constraints' => [
                new Positive([
                    'message' => 'El valor de codProd debe ser un número positivo.',
                ]),
            ],
        ])
        ->add('nombre', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'El nombre es obligatorio.',
                ]),
                // Puedes agregar restricciones adicionales según tus necesidades
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
                // Puedes agregar restricciones adicionales según tus necesidades
            ],
        ])
        ->add('peso', NumberType::class, [
            'constraints' => [
                new Positive([
                    'message' => 'El peso debe ser un número positivo.',
                ]),
            ],
        ])
        ->add('stock', IntegerType::class, [
            'constraints' => [
                new Positive([
                    'message' => 'El stock debe ser un número positivo.',
                ]),
            ],
        ])
        ->add('foto', FileType::class, [
            'label' => 'Foto',
            'mapped' => false, // No mapea directamente a una propiedad del objeto
            'required' => false, // La foto no es obligatoria
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'maxSizeMessage' => 'El tamaño de la foto no puede ser mayor a 1 MB.',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Por favor, sube una imagen JPEG o PNG válida.',
                ]),
            ],
        ])
        ->add('precio', NumberType::class, [
            'constraints' => [
                new Positive([
                    'message' => 'El precio debe ser un número positivo.',
                ]),
                // Puedes agregar restricciones adicionales según tus necesidades
            ],
        ])
        ->add('categoria', EntityType::class, [
            'class' => Categoria::class,
            'choice_label' => 'cod_cat',
            'constraints' => [
                // Puedes agregar restricciones adicionales según tus necesidades
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
        ]);
    }
}
