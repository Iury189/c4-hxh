<?= $this->extend('template/template') ?>

<?= $this->section('title') ?>
    Editar <?php echo $hunters['nome_hunter']; ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card-body">
    
    <div class="d-flex justify-content-end">
        <a href="<?php echo site_url('/') ?>" class="btn btn-secondary float-end"><i class="fa fa-arrow-left"></i>&nbsp; Voltar</a>
    </div>

    <form method="POST" action="<?= site_url('hunter/update/'.$hunters['id']) ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PATCH">
        <div class="form-group">
            <label for="nome_hunter">Nome:</label>
            <input type="text" class="form-control" name="nome_hunter" placeholder="Digite o nome do Hunter" maxlength="50" value="<?php echo $hunters['nome_hunter']; ?>">
            <?php echo session()->getFlashdata('errors')["nome_hunter"] ?? "";?>
        </div>
        <br>
        <div class="form-group">
            <label for="idade_hunter">Idade:</label>
            <input type="text" class="form-control" name="idade_hunter" placeholder="Digite a idade do Hunter" value="<?php echo $hunters['idade_hunter']; ?>">
            <?php echo session()->getFlashdata('errors')["idade_hunter"] ?? "";?>
        </div>
        <br>
        <div class="form-group">
            <label for="altura_hunter">Altura:</label>
            <input type="text" class="form-control" name="altura_hunter" placeholder="Digite a altura do Hunter" value="<?php echo $hunters['altura_hunter']; ?>">
            <?php echo session()->getFlashdata('errors')["altura_hunter"] ?? "";?>
        </div>
        <br>
        <div class="form-group">
            <label for="peso_hunter">Peso:</label>
            <input type="text" class="form-control" name="peso_hunter" placeholder="Digite o peso do Hunter" value="<?php echo $hunters['peso_hunter']; ?>">
            <?php echo session()->getFlashdata('errors')["peso_hunter"] ?? "";?>
        </div>
        <br>
        <div class="form-group">
            <label for="tipo_hunter_id">Tipo de Hunter:</label>
            <select class="form-control" name="tipo_hunter_id">
                <?php if (empty($tipos_hunters)): ?>
                    <option><?= 'Sem registros de tipos de Hunter' ?></option>
                <?php else: ?>
                    <option <?= (empty($hunters['tipo_hunter_id'])) ? 'selected' : '' ?> value=""><?= 'Escolha o tipo de Hunter' ?></option>
                    <?php foreach ($tipos_hunters as $id => $th): ?>
                        <option <?= ($hunters['tipo_hunter_id'] == $id) ? 'selected' : '' ?> value="<?= $id ?>"><?= $th['descricao'] ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <?php echo session()->getFlashdata('errors')["tipo_hunter_id"] ?? "";?>
        </div>
        <br>
        <div class="form-group">
            <label for="tipo_nen_id">Tipo de Nen:</label>
            <select class="form-control" name="tipo_nen_id">
                <?php if (empty($tipos_nens)): ?>
                    <option><?= 'Sem registros de tipos de Nen' ?></option>
                <?php else: ?>
                    <option <?= (empty($hunters['tipo_nen_id'])) ? 'selected' : '' ?> value=""><?= 'Escolha o tipo de Nen' ?></option>
                    <?php foreach ($tipos_nens as $id => $tn): ?>
                        <option <?= ($hunters['tipo_nen_id'] == $id) ? 'selected' : '' ?> value="<?= $id ?>"><?= $tn['descricao'] ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <?php echo session()->getFlashdata('errors')["tipo_nen_id"] ?? "";?>
        </div>
        <br>
        <div class="form-group">
            <label for="tipo_sangue_id">Tipo sanguíneo:</label>
            <select class="form-control" name="tipo_sangue_id">
                <?php if (empty($tipos_sanguineos)): ?>
                    <option><?= 'Sem registros de tipos sanguíneos' ?></option>
                <?php else: ?>
                    <option <?= (empty($hunters['tipo_sangue_id'])) ? 'selected' : '' ?> value=""><?= 'Escolha o tipo sanguíneo' ?></option>
                    <?php foreach ($tipos_sanguineos as $id => $ts): ?>
                        <option <?= ($hunters['tipo_sangue_id'] == $id) ? 'selected' : '' ?> value="<?= $id ?>"><?= $ts['descricao'] ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <?php echo session()->getFlashdata('errors')['tipo_sangue_id'] ?? ""; ?>
        </div>
        <br>
        <div class="form-group">
            <label for="inicio">Início:</label>
            <input id="inicio" class="form-control" name="inicio" type="date" min="<?= date('Y-m-d') ?>" value="<?php echo $hunters['inicio']; ?>" />
            <?php echo session()->getFlashdata('errors')["inicio"] ?? "";?>
        </div>
        <br>
        <div class="form-group">
            <label for="termino">Término:</label>
            <input class="form-control" name="termino" type="date" min="<?= date('Y-m-d') ?>" value="<?php echo $hunters['termino']; ?>" />
            <?php echo session()->getFlashdata('errors')["termino"] ?? "";?>
        </div>
        <br>
        <button type="submit" class="btn btn-primary"><i class="fa fa-arrows-rotate"></i>&nbsp;Atualizar</button>
    </form>
</div>

<?= $this->endSection() ?>