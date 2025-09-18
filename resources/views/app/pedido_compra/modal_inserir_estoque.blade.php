<div class="alert alert-success d-none" id="msg-sucesso"></div>
<div class="alert alert-danger d-none" id="msg-erro"></div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#entradaForm').submit(function(e) {
            e.preventDefault();

            let form = $(this);
            let url = "{{ route('pedido.store.ajax') }}";
            let formData = form.serialize();

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                success: function(response) {
                    form.find('.msg-sucesso').text('Entrada registrada com sucesso!').removeClass('d-none');
                    form.find('.msg-erro').addClass('d-none');

                    // Atualiza estoque na tela
                    let estoqueElem = $('#estoque-{{ $produto->id }}');
                    if (estoqueElem.length) {
                        estoqueElem.text(response.novo_estoque);
                    }

                    setTimeout(function() {
                        $('#entradaModal').modal('hide');
                        form[0].reset();
                        form.find('.msg-sucesso').addClass('d-none');
                    }, 1500);
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON?.errors;
                    let msg = 'Ocorreu um erro.';
                    if (errors) {
                        msg = Object.values(errors).flat().join(' ');
                    }
                    form.find('.msg-erro').text(msg).removeClass('d-none');
                    form.find('.msg-sucesso').addClass('d-none');
                }
            });
        });
    });
</script>