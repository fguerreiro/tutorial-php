<?php
// session_unset();

session_start(); 

include "banco.php";
include "ajudantes.php";

$exibir_tabela = true;

function is_iterable($var)
{
    return $var !== null 
        && (is_array($var) 
            || $var instanceof Traversable 
            || $var instanceof Iterator 
            || $var instanceof IteratorAggregate
            );
}

$tem_erros = false;
$erros_validacao = array();


	if (tem_post()) {
		$tarefa = array();

		if (isset($_POST['nome']) && strlen($_POST['nome']) > 0) {
			$tarefa['nome'] = $_POST['nome'];
		} else {
			$tem_erros = true;
			$erros_validacao['nome'] = 'O nome da tarefa é obrigatório!';
		}

		if (isset($_POST['descricao'])) {
			$tarefa['descricao'] = $_POST['descricao'];
		} else {
			$tarefa['descricao'] = '';
		}

		if (isset($_POST['prazo'])) {
			$tarefa['prazo'] = traduz_data_para_banco($_POST['prazo']);
		} else {
			$tem_erros = true;
			$erros_validacao['prazo'] = 'O prazo não é uma data válida!';
		}

		$tarefa['prioridade'] = $_POST['prioridade'];

		if (isset($_POST['concluida'])) {
			$tarefa['concluida'] = 1;
		} else {
			$tarefa['concluida'] = 0;
		}

		if (! $tem_erros){
			gravar_tarefa($conexao, $tarefa);
			header('Location: tarefas.php');
			die();
		}
    }
    
    $lista_tarefas = buscar_tarefas($conexao);

$tarefa = array(
	'id'	=> 0,
	'nome' 	=> retorna_campo_preenchido_str('nome'),
	'descricao' => retorna_campo_preenchido_str('descricao'),
	'prazo' =>	'',
	'prioridade' => retorna_campo_preenchido_int('prioridade'),
	'concluida' => retorna_campo_preenchido_str('concluida') 
);


function retorna_campo_preenchido_str($nome_campo){
	return isset($_POST[$nome_campo]) ? $_POST[$nome_campo] : '';
}

function retorna_campo_preenchido_int($nome_campo){
	return isset($_POST[$nome_campo]) ? $_POST[$nome_campo] : 1;
}

$_POST['prazo'] = isset($_POST['prazo']) ? $_POST['prazo'] : '';

if (strlen($_POST['prazo']) > 0){
	if (validar_data($_POST['prazo'])) {
		$tarefa['prazo'] = traduz_data_para_banco($_POST['prazo']);
	} else {
		$tem_erros = true;
		$erros_validacao['prazo'] = 'O prazo não é uma data válida!';
	}
}else{
	$tarefa['prazo'] = '';
}



include "template.php";

?>