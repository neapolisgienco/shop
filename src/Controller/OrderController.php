<?php

namespace App\Controller;

use App\Entity\Goods;
use App\Entity\Orders;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class OrderController extends AbstractController
{


    #[Route('/api/orders', methods: ['POST'])]
    public function createOrders(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        // Валидация входных данных
        if (!isset($data['userId'], $data['goods'])) {
            return $this->json(['error' => 'Валидация входных данных (Invalid data)'], Response::HTTP_BAD_REQUEST);
        }

        $user = $entityManager->getRepository(Users::class)->find($data['userId']);
        if (!$user) {
            return $this->json(['error' => 'Пользователь не найден (User not found)'], Response::HTTP_NOT_FOUND);
        }
        // Создание заказа
        $order = new Orders();
        $order->setUserId($user);

        foreach ($data['goods'] as $item) {
            $goods = $entityManager->getRepository(Goods::class)->find($item['id']);

            if (!$goods || $goods->getCount() < $item['count']) {
                return $this->json(['error' => 'Товаров не хватает на складе, заказ не будет оформлен'], Response::HTTP_BAD_REQUEST);
            }
            // Уменьшение количества товара на складе
            $goods->setCount($goods->getCount() - $item['count']);
            $entityManager->persist($goods);
            //$order->addGoods($goods); // TODO метод addGoods в Order
        }

        // Сохранение заказа
        $entityManager->persist($order);
        $entityManager->flush();

        return $this->json(['message' => 'заказ добавлен успешно (Order created successfully)'], Response::HTTP_CREATED);
    }
}