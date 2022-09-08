<main>
    <section>
        <a href="index.php">
            <button class="btn btn-outline-success">Voltar</button>
        </a>
    </section>

    <h2 class="my-4">Excluir Vaga</h2><hr>
    <!-- Sem action sempre envia para a mesma pagina -->
    <form method="post">
        <div class="form-group">
            <p>Deseja realmente  excluir a vaga <strong><?= $obVaga->titulo?>?</strong></p>
            <!-- ----------------------- -->
            <div class="form-group">
                <a href="index.php">
                    <button type="button" class="btn btn-success">Cancelar</button>
                </a>
                <button type="submit" name="excluir" class="btn btn-danger mt-2">Excluir</button>
            </div>
        </div>
    </form>


</main>