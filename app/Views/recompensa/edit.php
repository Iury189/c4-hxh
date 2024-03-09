<?= $this->extend('template/template') ?>

<?= $this->section('title') ?>
    Editar <?php echo $recompensas['descricao_recompensa']; ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card-body">
    
    <div class="d-flex justify-content-end">
        <a href="<?php echo site_url('recompensa/index') ?>" class="btn btn-secondary float-end"><i class="fa fa-arrow-left"></i>&nbsp; Voltar</a>
    </div>

    <form method="POST" action="<?= site_url('recompensa/update/'.$recompensas['id']) ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PATCH">
        <div class="form-group">
            <label for="descricao_recompensa">Descrição:</label>
            <input type="text" class="form-control" name="descricao_recompensa" placeholder="Digite a descrição da recompensa" value="<?php echo $recompensas['descricao_recompensa']; ?>">
            <?php echo session()->getFlashdata('errors')["descricao_recompensa"] ?? "";?>
        </div>
        <br>
        <div class="form-group">
            <label for="valor_recompensa">Valor:</label>
            <input type="text" class="form-control" name="valor_recompensa" placeholder="Digite o valor da recompensa" value="<?php echo $recompensas['valor_recompensa']; ?>">
            <?php echo session()->getFlashdata('errors')["valor_recompensa"] ?? "";?>
        </div>
        <br>
        <button type="submit" class="btn btn-primary"><i class="fa fa-arrows-rotate"></i>&nbsp;Atualizar</button>
    </form>
</div>

<?= $this->endSection() ?>