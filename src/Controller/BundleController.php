<?php

namespace App\Controller;

use App\Entity\Bundle;
use App\Forms\Bundle\BundleType;
use App\Repository\BundleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BundleController extends AbstractController
{
    #[Route('/bundle', name: 'app_bundle')]
    public function index(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $bundle = new Bundle();
        $form = $this->createForm(BundleType::class, $bundle);

        /** @var Bundle $goods */
        $bundle = $form->getData();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->tryToSaveBundleAndShowNotification($form,$managerRegistry);
            return $this->redirectToRoute('app_storage');
        }


        return $this->renderForm('bundle/index.html.twig', [
            'bundle' => $bundle,
            'form' => $form,
        ]);
    }

    private function tryToSaveBundleAndShowNotification(FormInterface $form, ManagerRegistry $managerRegistry): void
    {
        /** @var Bundle $bundle */
        $bundle = $form->getData();
        $bundlePrice = 0;
        foreach ($bundle->getGoods() as $good) {
            $bundlePrice += $good->getPrice();
        }

        $bundle->setPrice($bundlePrice);
        $entityManager = $managerRegistry->getManager();
        /** @var BundleRepository $goodsRepository */
        $goodsRepository = $entityManager->getRepository(Bundle::class);

        if ($goodsRepository->findOneBy(['name' => $bundle->getName()])) {
            $this->addFlash('error', 'This bundle is already exists!');

            return;
        }
        $entityManager->persist($bundle);
        $entityManager->flush();
        $this->addFlash('success', 'Bundle created properly');
    }

    #[Route('/bundle/delete/{id}', name: 'app_bundle_delete')]
    public function delete(int $id, BundleRepository $bundleRepository)
    {
        $bundleRepository->remove($bundleRepository->find($id));
        $this->addFlash('success', 'Bundle deleted properly');
        return $this->redirectToRoute('app_storage');
    }
}
