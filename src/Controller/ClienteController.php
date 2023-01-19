<?php

namespace App\Controller;

use App\Entity\Operacao;
use App\Entity\User;
use App\Repository\ContaRepository;
use App\Repository\OperacaoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClienteController extends AbstractController
{
    #[Route('/cliente/{id}', name: 'app_cliente')]
    public function index(User $user, ContaRepository $contaRepository): Response
    {
        $usuario = $this->getUser();

        if ($usuario->getUserIdentifier() != $user->getEmail()) {
            $this->addFlash('Falha', 'Você não tem permissão de acesso!');
            return $this->redirectToRoute('app_index');
        }
        $contas = $contaRepository->findBy(['usuario' => $user->getId(), 'active' => true]);

        return $this->render('cliente/index.html.twig', [
            'controller_name' => 'ClienteController',
            'contas' => $contas,
        ]);
    }

    #[Route('/cliente/{id}/conta/{conta}', name: 'app_cliente_conta')]
    public function conta(User $user, ContaRepository $contaRepository, OperacaoRepository $operacaoRepository, $conta): Response
    {
        $conta = $contaRepository->findOneBy(['usuario' => $user->getId(), 'active' => true, 'id' => $conta]);

        $operacoes_recebidas = $operacaoRepository->findBy(['destino' => $conta->getId()]);
        $operacoes_enviadas = $operacaoRepository->findBy(['envio' => $conta->getId()]);
        $operacoes = array_merge($operacoes_recebidas, $operacoes_enviadas);
        return $this->render('cliente/conta.html.twig', [
            'controller_name' => 'ClienteController',
            'conta' => $conta,
            'transacoes' => $operacoes,
        ]);
    }

    #[Route('/cliente/{id}/conta/{conta}/depositar', name: 'app_cliente_conta_depositar')]
    public function depositar(Request $request, User $user, ContaRepository $contaRepository, $conta, EntityManagerInterface $entityManager): Response
    {
        $conta = $contaRepository->findOneBy(['usuario' => $user->getId(), 'active' => true, 'id' => $conta]);

        if (!$conta) {
            $this->addFlash('error', 'Conta não encontrada!');
            return $this->redirectToRoute('app_index');
        }
        #post
        if ($request->isMethod('POST')) {
            $valor = $request->request->get('valor');
            if ($valor <= 0) {
                $this->addFlash('error', 'Valor inválido!');
            } else {
                $conta->creditar($valor);
            }
            $entityManager->persist($conta);
            $transacao = new Operacao();
            $transacao->setDescricao('Depósito');
            $transacao->setValor($valor);
            $transacao->setDestino($conta);
            $entityManager->persist($transacao);
            $entityManager->flush();
            $this->addFlash('OK', 'Deposito realizado com sucesso!');
            return $this->redirectToRoute('app_cliente_conta', ['id' => $user->getId(), 'conta' => $conta->getId()]);
        }

        return $this->redirect($request->headers->get('referer'));
    }



    #[Route('/cliente/{id}/conta/{conta}/saque', name: 'app_cliente_conta_saque')]
    public function saque(Request $request, $conta, User $user, ContaRepository $contaRepository, EntityManagerInterface $entityManager): Response
    {
        $minhaconta = $contaRepository->findOneBy(['usuario' => $user->getId(), 'active' => true, 'id' => $conta]);

        if ($request->isMethod('POST')) {
            $valor = $request->request->get('valor');

            if ($valor <= 0) {
                $this->addFlash('error', 'Valor inválido!');
            } elseif ($minhaconta->getSaldo() < $valor) {
                $this->addFlash('error', 'Saldo insuficiente!');
            } else {
                $minhaconta->debitar($valor);

                $entityManager->persist($minhaconta);

                $operacao = new Operacao();
                $operacao->setDescricao('Saque');
                $operacao->setValor($valor);
                $operacao->setDestino($minhaconta);
                $entityManager->persist($operacao);
                $entityManager->flush();
                $this->addFlash('Ok', 'Saque realizado com sucesso!');
                return $this->redirectToRoute('app_cliente_conta', ['id' => $user->getId(), 'conta' => $minhaconta->getId()]);
            }
            return $this->redirect($request->headers->get('referer'));
           }
        }
    }
    