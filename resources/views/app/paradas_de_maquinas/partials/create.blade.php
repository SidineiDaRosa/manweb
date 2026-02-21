<!-- Modal Criar Subcategoria -->
<div class="modal fade" id="modalCreateSubcategory" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('failure-subcategories.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Nova Subcategoria</h5>
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