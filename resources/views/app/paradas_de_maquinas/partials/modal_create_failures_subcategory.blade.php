<!-- Modal Criar Subcategoria -->
<div class="modal fade" id="modalCreateSubcategory" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formCreateSubcategory" action="{{route('failure-subcategories.store')}}" method="POST">
                @csrf

                <!-- ID da categoria -->
                <input type="hidden" name="failure_id" id="create_failure_id">

                <div class="modal-header">
                    <div>
                        <h5 class="modal-title">Nova Subcategoria</h5>
                        <small class="text-muted" id="create_category_name"></small>
                    </div>
                  
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- Nome -->
                    <div class="mb-3">
                        <label class="form-label">Nome da Subcategoria</label>
                        <input type="text"
                            name="name"
                            class="form-control"
                            required>
                    </div>

                    <!-- Descrição -->
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="description"
                            class="form-control"
                            rows="3"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button"
                        class="btn-inf btn-inf-md btn-inf-red"
                        data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="submit"
                        class="btn-inf btn-inf-md btn-inf-blue-dark">
                        Salvar
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('.btn-create-subcategory').forEach(button => {

            button.addEventListener('click', function() {

                const id = this.dataset.id;
                const name = this.dataset.name;

                // Coloca o nome da categoria no header
                document.getElementById('create_category_name').innerText = name;

                // Define o ID no input hidden
                document.getElementById('create_failure_id').value = id;

            });

        });

    });
</script>