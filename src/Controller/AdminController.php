<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Entity\Pedidos;
use App\Entity\Producto;
use App\Form\CategoriaType;
use App\Form\PedidosType;
use App\Form\ProductoType;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /** Categorias */
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



    #[Route('/categoria/new', name: 'app_categoria_new', methods: ['GET', 'POST'])]
    public function catNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorium = new Categoria();
        $form = $this->createForm(CategoriaType::class, $categorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorium);
            $entityManager->flush();

            return $this->redirectToRoute('app_categoria_index_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categoria/new.html.twig', [
            'categorium' => $categorium,
            'form' => $form,
        ]);
    }

    #[Route('/categoria/{codCat}', name: 'app_categoria_show', methods: ['GET'])]
    public function show(Categoria $categorium): Response
    {
        return $this->render('categoria/show.html.twig', [
            'categorium' => $categorium,
        ]);
    }

    #[Route('/categoria/{codCat}/edit', name: 'app_categoria_edit', methods: ['GET', 'POST'])]
    public function catEdit(Request $request, Categoria $categorium, EntityManagerInterface $entityManager, CategoriaRepository $categoriaRepository): Response
    {
        $form = $this->createForm(CategoriaType::class, $categorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categoria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/categoria.html.twig', [
            'categorias' => $categoriaRepository->findAll(),
            'categorium' => $categorium,
            'form' => $form,
            'editar'=>true,
        ]);
    }

    #[Route('/categoria/{codCat}', name: 'app_categoria_delete', methods: ['POST'])]
    public function catDelete(Request $request, Categoria $categorium, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorium->getCodCat(), $request->request->get('_token'))) {
            $entityManager->remove($categorium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categoria_index', [], Response::HTTP_SEE_OTHER);
    }
    /** PEDIDOS */
    #[Route('/pedidos/{codPed}/edit', name: 'app_pedidos_edit', methods: ['GET', 'POST'])]
    public function pedEdit(Request $request, Pedidos $pedido, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PedidosType::class, $pedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_pedidos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pedidos/edit.html.twig', [
            'pedido' => $pedido,
            'form' => $form,
        ]);
    }

    #[Route('/pedidos/{codPed}', name: 'app_pedidos_delete', methods: ['POST'])]
    public function pedDelete(Request $request, Pedidos $pedido, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pedido->getCodPed(), $request->request->get('_token'))) {
            $entityManager->remove($pedido);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_pedidos_index', [], Response::HTTP_SEE_OTHER);
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
    #[Route('/producto/{codProd}/edit', name: 'app_producto_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Producto $producto, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductoType::class, $producto);
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
            return $this->redirectToRoute('app_producto_index', [], Response::HTTP_SEE_OTHER);
        }

        // Renderizar el formulario para editar el producto
        return $this->render('producto/edit.html.twig', [
            'producto' => $producto,
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
    
}
