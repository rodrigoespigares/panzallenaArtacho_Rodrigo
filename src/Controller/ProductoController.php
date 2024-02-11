<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Form\ProductoType;
use App\Repository\ProductoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Route('/producto')]
class ProductoController extends AbstractController
{
    #[Route('/', name: 'app_producto_index', methods: ['GET'])]
    public function index(ProductoRepository $productoRepository): Response
    {
        return $this->render('producto/index.html.twig', [
            'productos' => $productoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_producto_new', methods: ['GET', 'POST'])]
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

    #[Route('/{codProd}', name: 'app_producto_show', methods: ['GET'])]
    public function show(Producto $producto): Response
    {
        return $this->render('producto/show.html.twig', [
            'producto' => $producto,
        ]);
    }

    #[Route('/{codProd}/edit', name: 'app_producto_edit', methods: ['GET', 'POST'])]
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

    #[Route('/{codProd}', name: 'app_producto_delete', methods: ['POST'])]
    public function delete(Request $request, Producto $producto, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$producto->getCodProd(), $request->request->get('_token'))) {
            $entityManager->remove($producto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_producto_index', [], Response::HTTP_SEE_OTHER);
    }
}
