<form method="POST">
    <input type="hidden" name="id" value="<?php echo $tarefa['id']; ?>" />
    <fieldset>
        <legend>Nova tarefa</legend>
        <label>
            Tarefa:
            <?php 
	            $tem_erros = isset($tem_erros) ? $tem_erros : false;
	            $erros_validacao['nome'] = isset($erros_validacao['nome']) ? $erros_validacao['nome'] : array();
	            display_tarefa($tarefa, $tem_erros, $erros_validacao) 
            ?>
        </label>
        <label>
            Descrição (Opcional):
            <textarea name="descricao"><?php echo $tarefa['descricao']; ?></textarea>
        </label>
         <label>
            Prazo (Opcional):
            <?php if ($tem_erros && isset($erros_validacao['prazo'])) : ?>
                <span class="erro"><?php echo $erros_validacao['prazo']; ?></span>
            <?php endif; ?>
            <input type="text" name="prazo" value="<?php echo traduz_data_para_exibir($tarefa['prazo']); ?>" />
        </label>
        <fieldset>
            <legend>Prioridade:</legend>
            <input type="radio" name="prioridade" value="1" <?php echo ($tarefa['prioridade'] == 1) ? 'checked' : ''; ?> /> Baixa
            <input type="radio" name="prioridade" value="2" <?php echo ($tarefa['prioridade'] == 2) ? 'checked' : ''; ?> /> Média
            <input type="radio" name="prioridade" value="3" <?php echo ($tarefa['prioridade'] == 3) ? 'checked' : ''; ?> /> Alta
        </fieldset>
        <label>
            Tarefa concluída:
            <input type="checkbox" name="concluida" value="1" <?php echo ($tarefa['concluida'] == 1) ? 'checked' : ''; ?> />
        </label>
        <input type="submit" value="<?php echo ($tarefa['id'] > 0) ? 'Atualizar' : 'Cadastrar'; ?>" />
    </fieldset>
</form>

<?php
	
	function display_tarefa($tarefa, $tem_erros, $erros_validacao){
		if ($tem_erros && isset($erros_validacao['nome'])) {
			echo "<span class='erro'>" . $erros_validacao['nome'] . "</span>";
		}
		echo "<input type='text' name='nome' value='" . $tarefa['nome'] . "' />";
	}


?>