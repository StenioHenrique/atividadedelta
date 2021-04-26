<?php echo $this->include("menu_header", array("titulo" => $titulo)); ?>
<p><?php echo $msg ?></p>

<div class="col-sm-12">
    <div style="padding: 2%;">
        <h2><?= $titulo ?></h2>
        <table class="table table-hover table-bordered ">
            <thead>
                <tr>
                    <td>Imagem</td>
                    <td>Nome </td>
                    <td>Endereco </td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php if (count($alunos) == 0) : ?>
                    <td colspan="5">Nenhum aluno encontrado.</td>
                <?php endif; ?>
                <?php foreach ($alunos as $aluno) : ?>
                    <tr>
                        <td><img width="70" height="70" src="<?= base_url($aluno->imgaluno) ?>" alt=""></td>
                        <td><?= $aluno->nome ?></td>
                        <td><?= $aluno->endereco ?></td>
                        <td><a href="<?= base_url('alunos/editar/' . $aluno->alunoid) ?>" class="btn btn-outline-primary" role="button" aria-pressed="true">Editar</a></td>
                        <td><button onclick="excluir(this.value)" value="<?= $aluno->alunoid ?>" class="btn btn-outline-danger" role="button">Excluir</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function excluir(alunoid) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: 'Tem certeza?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, apague isso!',
            cancelButtonText: 'Não, cancele!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("alunos/excluir/" + alunoid, function(data) {
                    if (data == 'true') {
                        swalWithBootstrapButtons.fire({
                            title: 'Apagado!'
                        }).then((result) => {
                            window.location = "<?= base_url('/alunos') ?>"
                        })

                    } else {
                        swalWithBootstrapButtons.fire({
                            title: 'Cancelado',
                            text: 'Erro ao excluir aluno.'
                        }).then((result) => {
                            window.location = "<?= base_url('/alunos') ?>"
                        })
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'Seu arquivo está seguro :)',
                    'error'
                )
            }
        })
    }
</script>

<?php echo $this->include("menu_footer"); ?>