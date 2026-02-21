<!-- Modal Editar Subcategoria -->
<div class="modal fade" id="modalEditSubcategory" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formEditSubcategory"  method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Editar Subcategoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- Nome -->
                    <div class="mb-3">
                        <label class="form-label">Nome da Subcategoria</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <!-- Descrição -->
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="description"
                            id="edit_description"
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
                        Salvar Alterações
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const form = document.getElementById('formEditSubcategory');

        document.querySelectorAll('.btn-edit-subcategory').forEach(button => {

            button.addEventListener('click', function() {

                const id = this.dataset.id;
                const name = this.dataset.name;
                const description = this.dataset.description;

                document.getElementById('edit_name').value = name;
                document.getElementById('edit_description').value = description ?? '';

                form.action = '/failure-subcategories-update/' + id;
            });

        });

    });
</script>