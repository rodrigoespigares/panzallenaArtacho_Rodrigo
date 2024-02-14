<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Entity\Pedidos;
use App\Entity\Producto;
use App\Entity\Restaurante;
use App\Form\Admin_editFormType;
use App\Form\Admin_RegistrationFormType;
use App\Form\CategoriaType;
use App\Form\CategoriaTypeEdit;
use App\Form\EditaPeiddosType;
use App\Form\ProductoType;
use App\Form\ProductoTypeEdit;
use App\Repository\CategoriaRepository;
use App\Repository\PedidosRepository;
use App\Repository\ProductoRepository;
use App\Repository\RestauranteRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

/** Controlador para gestionar los permisos de un administrador */
#[Route('/admin')]
class AdminController extends AbstractController
{
    // Variables necesarias en el controlador
    private EmailVerifier $emailVerifier;

    // Constructor del controlador
    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }
    // Comienzo de la gestión de la parte de categorias 

    /**
     * Función principal para la carga de categorias en la parte del servidor
     */
    #[Route('/categoria', name: 'app_categoria_index_admin', methods: ['GET', 'POST'])]
    public function indexCategoria(Request $request, CategoriaRepository $categoriaRepository, EntityManagerInterface $entityManager): Response
    {
        $categorium = new Categoria();
        $form = $this->createForm(CategoriaType::class, $categorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorium);
            $entityManager->flush();

            return $this->redirectToRoute('app_categoria_index_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/categoria.html.twig', [
            'categorias' => $categoriaRepository->findAll(),
            'form' => $form,
            'editar'=>false,
        ]);
    }
    /** Función para ver el detalle de una categoria desde la parte del administrador */
    #[Route('/categoria/{codCat}', name: 'app_categoria_show', methods: ['GET'])]
    public function show(Categoria $categorium, ProductoRepository $productoRepository): Response
    {
        return $this->render('categoria/show.html.twig', [
            'categorium' => $categorium,
            'productos' => $productoRepository->findAll()
        ]);
    }
    /** Fundión para editar una categoria */
    #[Route('/categoria/{codCat}/edit', name: 'app_categoria_edit', methods: ['GET', 'POST'])]
    public function catEdit(Request $request, Categoria $categorium, EntityManagerInterface $entityManager, CategoriaRepository $categoriaRepository): Response
    {
        $form = $this->createForm(CategoriaTypeEdit::class, $categorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categoria_index_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/categoria.html.twig', [
            'categorias' => $categoriaRepository->findAll(),
            'categorium' => $categorium,
            'form' => $form,
            'editar'=>true,
        ]);
    }
    // Comienzo de la gestión de la parte de pedidos
    
    /** Carga de todos los pedidos en la parte del administrador con la capacidad de ver todos los pedidos disponibles */
    #[Route('/pedidos', name: 'app_pedidos_index_admin', methods: ['GET', 'POST'])]
    public function pedidosIndex(PedidosRepository $pedidosRepository): Response
    {
        return $this->render('admin/pedidos.html.twig', [
            'pedidos' => $pedidosRepository->findAll(),
            'editar'=>false,
        ]);
    }

    /** Función para editar un pedido SOLO ESTARA DISPONIBLE EL CAMPO ENVIADO */
    #[Route('/pedidos/{codPed}/edit', name: 'app_pedidos_edit', methods: ['GET', 'POST'])]
    public function pedEdit(Request $request, Pedidos $pedido, EntityManagerInterface $entityManager,PedidosRepository $pedidosRepository): Response
    {
        $form = $this->createForm(EditaPeiddosType::class, $pedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_pedidos_index_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/pedidos.html.twig', [
            'pedidos' => $pedidosRepository->findAll(),
            'pedido' => $pedido,
            'form' => $form,
            'editar'=> true,
        ]);
    }

    #[Route('/producto/new', name: 'app_producto_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $producto = new Producto();
        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Manejar la carga de la imagen
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('foto')->getData();

            // Comprobar si se ha subido una imagen
            if ($imageFile) {
                // Generar un nombre único para el archivo
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                // Mover el archivo al directorio donde se guardará
                try {
                    $imageFile->move(
                        $this->getParameter('your_directory'), // Directorio donde se guarda la imagen
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Manejar una excepción si ocurre algún error al mover el archivo
                    // Por ejemplo, podrías mostrar un mensaje de error al usuario
                }

                // Actualizar la entidad Producto con el nombre de la imagen
                $producto->setFoto($newFilename);
            }

            // Persistir el producto en la base de datos
            $entityManager->persist($producto);
            $entityManager->flush();

            // Redirigir al usuario a la página de índice de productos después de agregar el producto
            return $this->redirectToRoute('app_producto_index', [], Response::HTTP_SEE_OTHER);
        }

        // Renderizar el formulario para agregar un nuevo producto
        return $this->render('producto/new.html.twig', [
            'producto' => $producto,
            'form' => $form->createView(),
        ]);
    }
    /** PRODUCTOS */
    #[Route('/producto', name: 'app_producto_index_admin', methods: ['GET', 'POST'])]
    public function productoNew(Request $request, ProductoRepository $productoRepository, EntityManagerInterface $entityManager): Response
    {
        $producto = new Producto();
        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Manejar la carga de la imagen
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('foto')->getData();

            // Comprobar si se ha subido una imagen
            if ($imageFile) {
                // Generar un nombre único para el archivo
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                // Mover el archivo al directorio donde se guardará
                try {
                    $imageFile->move(
                        $this->getParameter('your_directory'), // Directorio donde se guarda la imagen
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Manejar una excepción si ocurre algún error al mover el archivo
                    // Por ejemplo, podrías mostrar un mensaje de error al usuario
                }

                // Actualizar la entidad Producto con el nombre de la imagen
                $producto->setFoto($newFilename);
            }

            // Persistir el producto en la base de datos
            $entityManager->persist($producto);
            $entityManager->flush();

            // Redirigir al usuario a la página de índice de productos después de agregar el producto
            return $this->redirectToRoute('app_producto_index_admin', [], Response::HTTP_SEE_OTHER);
        }

        // Renderizar el formulario para agregar un nuevo producto
        return $this->render('admin/producto.html.twig', [
            'productos' => $productoRepository->findAll(),
            'editar'=>false,
            'producto' => $producto,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/producto/{codProd}/edit', name: 'app_producto_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Producto $producto, EntityManagerInterface $entityManager, ProductoRepository $productoRepository): Response
    {
        $form = $this->createForm(ProductoTypeEdit::class, $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Manejar la carga de la imagen
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('foto')->getData();

            // Comprobar si se ha subido una nueva imagen
            if ($imageFile) {
                // Generar un nombre único para el archivo
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                // Mover el archivo al directorio donde se guardará
                try {
                    $imageFile->move(
                        $this->getParameter('your_directory'), // Directorio donde se guarda la imagen
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Manejar una excepción si ocurre algún error al mover el archivo
                    // Por ejemplo, podrías mostrar un mensaje de error al usuario
                }

                // Actualizar la entidad Producto con el nombre de la nueva imagen
                $producto->setFoto($newFilename);
            }

            // Persistir los cambios en el producto en la base de datos
            $entityManager->flush();

            // Redirigir al usuario a la página de índice de productos después de editar el producto
            return $this->redirectToRoute('app_producto_index_admin', [], Response::HTTP_SEE_OTHER);
        }

        // Renderizar el formulario para editar el producto
        return $this->render('admin/producto.html.twig', [
            'producto' => $producto,
            'editar'=>true,
            'productos' => $productoRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/producto/{codProd}', name: 'app_producto_delete', methods: ['POST'])]
    public function delete(Request $request, Producto $producto, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$producto->getCodProd(), $request->request->get('_token'))) {
            $entityManager->remove($producto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_producto_index', [], Response::HTTP_SEE_OTHER);
    }
    


    /** CREAR USERS */
    #[Route('/users', name: 'app_restaurante_index_admin', methods: ['GET', 'POST'])]
    public function newUser(Request $request,UserPasswordHasherInterface $userPasswordHasher , EntityManagerInterface $entityManager, RestauranteRepository $restauranteRepository): Response
    {
        $restaurante = new Restaurante();
        $user = new Restaurante();
        $form = $this->createForm(Admin_RegistrationFormType::class, $restaurante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setEmail($form->get('email')->getData());
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('zoologicoiesfa@gmail.com', 'Departamento de Administracion'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_restaurante_index_admin');
        }

        return $this->render('admin/usuarios.html.twig', [
            'restaurantes' => $restauranteRepository->findAll(),
            'restaurante' => $restaurante,
            'form' => $form,
            'editar' =>false,
        ]);
    }
    #[Route('/user/{cod_res}/edit', name: 'app_restaurante_edit', methods: ['GET', 'POST'])]
    public function useredit(Request $request, Restaurante $restaurante, EntityManagerInterface $entityManager, RestauranteRepository $restauranteRepository): Response
    {
        $form = $this->createForm(Admin_editFormType::class, $restaurante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_restaurante_index_admin', [], Response::HTTP_SEE_OTHER);
        }
        
        $emailUser = $restaurante->getEmail();
        return $this->render('admin/usuarios.html.twig', [
            'restaurantes' => $restauranteRepository->findAll(),
            'restaurante' => $restaurante,
            'email' => $emailUser,
            'form' => $form,
            'editar' =>true,
        ]);
    }

    #[Route('/user/{cod_res}', name: 'app_restaurante_delete', methods: ['POST'])]
    public function userdelete(Request $request, Restaurante $restaurante, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$restaurante->getCod_res(), $request->request->get('_token'))) {
            $entityManager->remove($restaurante);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_restaurante_index_admin', [], Response::HTTP_SEE_OTHER);
    }
}
