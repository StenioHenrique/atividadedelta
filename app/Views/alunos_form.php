<?php echo $this->include("menu_header", array("titulo" => $titulo)); ?>

<strong><?php echo $msg ?></strong>
<div class="card border-secondary mb-3" style="margin: 2% auto;">
    <div style="padding: 2%; background-color: #e6e3e3;">
        <form action="" id="salvar" name="salvar" method="post" enctype="multipart/form-data">
            <h2><?= $titulo; ?></h2>
            <div class="form-group">
                <label>Nome do aluno:</label>
                <input required class="form-control" type="text" name="nome" id="nome" autocomplete="off" value="<?php echo (isset($aluno) ? $aluno->nome : '') ?>">
            </div>
            <div class="form-group">
                <label>Endereço do aluno:</label>
                <input required class="form-control" type="text" name="endereco" id="endereco" autocomplete="off" value="<?php echo (isset($aluno) ? $aluno->endereco : '') ?>"></p>
            </div>
            <div class="form-group">
                <label>Imagem do aluno: </label>
                <input required class="form-control-file" type="file" name="imagem" id="imagem" accept="image/png, image/jpeg" value="<?php echo (isset($aluno) ? $aluno->imgaluno : '') ?>"></p>
                <?php if (isset($aluno)) : ?>
                    <img class="preview-img" width="150" height="150" src="<?php echo base_url($aluno->imgaluno)  ?>">
                <?php endif; ?>
            </div>
            <div class="form-group">
                <button type="submit" value="<?= $acao ?>" class="btn btn-outline-success"><?= $acao ?></button>
            </div>
        </form>
    </div>
</div>

<?php if (isset($aluno)) : ?>
    <script>
        $("#imagem").attr("required", false);
        $("#nome").attr("required", false);
        $("#endereco").attr("required", false);

        $('#salvar').submit(function(e) {
            e.preventDefault();
            salvar();
        });

        function salvar(alunoid) {

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
                confirmButtonText: 'Sim, salve isso!',
                cancelButtonText: 'Não, cancele!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData($("form[name='salvar']")[0]);
                    $.ajax({
                        url: "<?= $aluno->alunoid ?>",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            if (data == 'true') {
                                swalWithBootstrapButtons.fire({
                                    title: 'Atualizado!'
                                }).then((result) => {
                                    window.location = "<?= base_url('/alunos') ?>"
                                })
                            } else {
                                swalWithBootstrapButtons.fire(
                                    'Não cadastrado',
                                    'Erro ao cadastrar aluno.',
                                    'error'
                                )
                            }
                        },
                        error: function(error) {
                            swalWithBootstrapButtons.fire(
                                'Não cadastrado',
                                'Erro ao cadastrar aluno.',
                                'error'
                            )
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        'Cancelado',
                        ':('
                    )
                }
            })
        }
    </script>
<?php else : ?>
    <script>
        $('#salvar').submit(function(e) {
            e.preventDefault();
            salvar();
        });

        function salvar(alunoid) {

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
                confirmButtonText: 'Sim, salve isso!',
                cancelButtonText: 'Não, cancele!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData($("form[name='salvar']")[0]);
                    $.ajax({
                        url: "salvar",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            if (data == 'true') {
                                swalWithBootstrapButtons.fire({
                                    title: 'Cadastrado!'
                                }).then((result) => {
                                    window.location = "<?= base_url('/alunos') ?>"
                                })
                            } else {
                                swalWithBootstrapButtons.fire(
                                    'Não cadastrado',
                                    'Erro ao cadastrar aluno.',
                                    'error'
                                )
                            }
                        },
                        error: function(error) {
                            swalWithBootstrapButtons.fire(
                                'Não cadastrado',
                                'Erro ao cadastrar aluno.',
                                'error'
                            )
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        'Cancelado',
                        ':('
                    )
                }
            })
        }
    </script>
<?php endif; ?>

<?php echo $this->include("menu_footer"); ?>