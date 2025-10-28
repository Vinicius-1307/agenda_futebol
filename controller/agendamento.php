<?php
include_once '../model/Reservas.php';
include_once '../model/Campos.php';
include_once '../model/Clientes.php';
include_once('../utils/alert.php');

session_start();

date_default_timezone_set('America/Sao_Paulo');

$campoModel = new Campos();
$reservaModel = new Reservas();

// Recebe os dados do formulário
$id_campo = $_POST['id_campo'];
$diaPartida = $_POST['diaPartida'];
$horarioInicio = $_POST['horarioInicioPartida'];
$horarioFim = $_POST['horarioFinalPartida'];

// ⚠️ Verifica se todos os campos foram preenchidos
if (empty($id_campo) || empty($diaPartida) || empty($horarioInicio) || empty($horarioFim)) {
    sweetAlert('Erro', 'Por favor, preencha todos os campos.', 'error', '../view/home.php');
    exit;
}

// 🔒 Valida se os horários terminam em :00 ou :30
list($horaInicio, $minutoInicio) = explode(':', $horarioInicio);
list($horaFim, $minutoFim) = explode(':', $horarioFim);

if (!in_array((int)$minutoInicio, [0, 30]) || !in_array((int)$minutoFim, [0, 30])) {
    sweetAlert('Erro', 'Somente horários cheios ou de meia hora são permitidos (:00 ou :30).', 'error', '../view/home.php');
    exit;
}

// 🕒 Verifica se horário final é depois do início
if (strtotime($horarioFim) <= strtotime($horarioInicio)) {
    sweetAlert('Erro', 'O horário final deve ser maior que o horário inicial.', 'error', '../view/home.php');
    exit;
}

// 📅 Verifica se a data escolhida já passou
$dataHoje = new DateTime('today');
$dataSelecionada = new DateTime($diaPartida);

if ($dataSelecionada < $dataHoje) {
    sweetAlert('Erro', 'A data selecionada já passou. Escolha uma data válida.', 'error', '../view/home.php');
    exit;
}

// ⛔ Verifica se a data/hora de início já passou
$dataHoraInicio = new DateTime("$diaPartida $horarioInicio");
$agora = new DateTime();

if ($dataHoraInicio < $agora) {
    sweetAlert('Erro', 'O horário selecionado já passou. Escolha um horário futuro.', 'error', '../view/home.php');
    exit;
}

// Busca informações do campo
$campo = $campoModel->getById($id_campo);
if (!$campo) {
    sweetAlert('Erro', 'Campo não encontrado!', 'error', '../view/home.php');
    exit;
}

// Pegando dados do campo
$inicio_operacao = $campo->getInicio_atendimento();
$fim_operacao = $campo->getFim_atendimento();
$preco_slot = $campo->getPreco_slot();

// Valida se o horário está dentro do horário de funcionamento
if ($horarioInicio < $inicio_operacao || $horarioFim > $fim_operacao) {
    sweetAlert('Erro', 'O horário selecionado está fora do horário de operação do campo.', 'error', '../view/home.php');
    exit;
}

// Verifica se já existe uma reserva nesse horário
$existeReserva = $reservaModel->verificarConflito(
    $id_campo,
    $diaPartida,
    $horarioInicio,
    $horarioFim
);

if ($existeReserva) {
    sweetAlert('Erro', 'Já existe uma reserva nesse horário!', 'error', '../view/home.php');
    exit;
}

// Obtém o ID do cliente da sessão
$id_cliente = $_SESSION['id_cliente'] ?? null;
if (!$id_cliente) {
    sweetAlert('Erro', 'Você precisa estar logado para agendar.', 'error', '../view/login.html');
    exit;
}

// 🧮 Calcula o valor total com base na diferença entre início e fim
$inicioCalc = new DateTime($horarioInicio);
$fimCalc = new DateTime($horarioFim);
$intervalo = $inicioCalc->diff($fimCalc);
$horas = $intervalo->h + ($intervalo->i / 60);
$valor_total = $preco_slot * $horas;

// Cria a reserva
$reservaModel->setIdCampo($id_campo);
$reservaModel->setIdCliente($id_cliente);
$reservaModel->setDataReserva($diaPartida);
$reservaModel->setHoraInicio($horarioInicio);
$reservaModel->setHoraFim($horarioFim);
$reservaModel->setValorTotal($valor_total);
$reservaModel->setStatus('confirmado');

// Tenta salvar
if ($reservaModel->create()) {
    sweetAlert(
        'Sucesso',
        'Agendamento realizado com sucesso! Horário: ' . $horarioInicio . ' às ' . $horarioFim . 'Valor total: R$ ' . number_format($valor_total, 2, ',', '.'),
        'success',
        '../view/home.php',
    );
} else {
    sweetAlert('Erro', 'Erro ao realizar agendamento!', 'error', '../view/home.php');
}
