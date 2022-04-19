<?php

namespace App\Controller;

use App\Entity\Goods;
use App\Forms\Goods\GoodsType;
use App\Repository\GoodsRepository;
use Doctrine\Persistence\ManagerRegistry;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

class GoodsController extends AbstractController
{
    #[Route('/goods', name: 'app_goods')]
    public function index(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $goods = new Goods();
        $form = $this->createForm(GoodsType::class, $goods);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->tryToSaveGoodsAndShowNotification($form,$managerRegistry);
        }

        return $this->renderForm('goods/index.html.twig', [
            'goods' => $goods,
            'form' => $form,
        ]);
    }

    private function tryToSaveGoodsAndShowNotification(FormInterface $form, ManagerRegistry $managerRegistry): void
    {
        /** @var Goods $goods */
        $goods = $form->getData();
        $entityManager = $managerRegistry->getManager();

        /** @var GoodsRepository $goodsRepository */
        $goodsRepository = $entityManager->getRepository(Goods::class);

        if ($goodsRepository->findOneBy(['name' => $goods->getName()])) {
            $this->addFlash('error', 'This goods is already exists!');
            $this->redirectToRoute('app_goods');

            return;
        }
        $entityManager->persist($goods);
        $entityManager->flush();
        $this->addFlash('success', 'Goods created properly');
        $this->redirectToRoute('app_goods');
    }

    #[Route('/goods/delete/{id}', name: 'app_goods_delete')]
    public function delete(int $id, GoodsRepository $goodsRepository)
    {
        $goods = $goodsRepository->find($id);
        if (null === $goods) {
            throw new HttpException(404, 'Page not found');
        }

        if (0 === $goods->getBundles()->count()){
            $goodsRepository->remove($goods);
            $this->addFlash('success', 'Current goods deleted properly');
        } else {
            $this->addFlash('error', 'Current goods included in bundle!');
        }

        return $this->redirectToRoute('app_storage');
    }
}
