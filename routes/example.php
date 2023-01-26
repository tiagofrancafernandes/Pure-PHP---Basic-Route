<?php

use Utils\RequestHelper;
use Utils\Response;
use Utils\Route;

$router = new Route();

/**
 * -> Rotas a partir daqui
 */

$router->get('/', fn () => Response::view('pages.index'));

// $router->post('login', function () {
//     $login = RequestHelper::input('login');
//     $senha = RequestHelper::input('senha');

//     if ($login && $senha) {
//         $usuario = ControladoraFuncionarioEmPDO::instance()
//             ->login(
//                 htmlspecialchars($login),
//                 htmlspecialchars($senha)
//             );

//         if ($usuario) {
//             return Response::json([
//                 'usuario' => $usuario,
//                 'token' => md5(rand() . time()),
//             ], 200);
//         }
//     }

//     Response::json([
//         'message' => 'Não autorizado',
//     ], 401);
// });

// $router->post('reservas', function () {
//     $cliente = htmlspecialchars($_POST['cliente']);
//     $dia = $_POST['dia'];
//     $horario = $_POST['horario'];
//     $mesa = htmlspecialchars($_POST['mesa']);
//     $idFuncionario = htmlspecialchars($_POST['id']);
//     $situacao = $_POST['situacao'] ?? 'em espera';
//     $reserva = new Reserva($cliente, $dia, $horario, $mesa, $situacao);

//     if (isset($_POST['cliente'], $_POST['dia'], $_POST['horario'], $_POST['mesa'])) {
//         if (
//             ControladoraFuncionarioEmPDO::instance()->criarReserva(
//                 $reserva->getnomeCliente(),
//                 $reserva->getDia(),
//                 $reserva->getHorario(),
//                 $idFuncionario
//             )
//         ) {
//             return Response::json([
//                 'message' => 'Cadastro realizado com sucesso!',
//             ]);
//         }
//     }

//     Response::asType('text', '', 400);
// });

// $router->get('reservas', fn () => Response::json(ControladoraFuncionarioEmPDO::instance()->listarReservas()));

// $router->put('reserva', function () {
//     $data = json_decode(file_get_contents("php://input"), true);

//     // $mesa = $data['mesa'];
//     $dia = $data['dia'] ?? null;
//     $hora = $data['hora'] ?? null;

//     if (!$dia || !$hora) {
//         return Response::json([
//             'message' => 'Error',
//         ], 422);
//     }

//     $reservas = ControladoraFuncionarioEmPDO::instance()->cancelarReserva($dia, $hora);

//     return Response::json([
//         'message' => 'Success',
//     ]);
// });

$router->listen();
