<main>
    <section>
        <a href="index.php">
            <button class="btn btn-outline-success">Voltar</button>
        </a>
    </section>

    <h2 class="my-4"><?= TITLE ?></h2><hr>
    <!-- Sem action sempre envia para a mesma pagina -->
    <form method="post">
        <div>
            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" class="form-control" name="titulo" value="<?= $obVaga->titulo ?? ''?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea class="form-control" name="descricao" rows="3"><?= $obVaga->descricao ?? ''?></textarea>
            </div>
             <!-- ---------STATUS---------- -->
            <div class="form-group">
                <label>Status</label> <br>

                <div class="form-check form-check-inline mt-1">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="ativo" value="s" checked>Ativo
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="ativo" value="n" 
                        <?= $obVaga->ativo === 'n' ? 'checked' : ''; ?>>Inativo
                    </label>
                </div>
            </div>
            <!-- ----------------------- -->

            <hr><div class="form-group">
                <button type="submit" class="btn btn-success mt-2">Enviar</button>
            </div>
        </div>
    </form>


</main>