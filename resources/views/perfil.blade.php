<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    @vite('resources/css/app.css')
</head>

<body>
    <x-header />

    <main class="mx-auto max-w-4xl px-4 py-10">
        <h1 class="text-3xl font-extrabold text-rose-600 mb-6">Perfil do Usuário</h1>

        <section class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Informações Pessoais</h2>

            <form method="POST" action="{{ route('perfil.update') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                    <input id="name" name="name" type="text" required
                           value="{{ old('name', Auth::user()->name) }}" />
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" readonly
                           class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 bg-gray-50 text-gray-600"
                           value="{{ old('email', Auth::user()->email) }}" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Senha <span class="text-sm text-gray-400">(deixe em branco para manter)</span></label>
                    <input id="password" name="password" type="password"
                           class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-rose-200" />
                </div>

                <div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-rose-600 text-white rounded-md shadow hover:bg-rose-700">Salvar Alterações</button>
                </div>
            </form>
        </section>

        <section class="mt-6">
            <h2 class="text-lg font-semibold mb-3">Ações</h2>
            <div class="flex items-center gap-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-rose-600 text-rose-600 rounded-md hover:bg-rose-50">Logout</button>
                </form>

                <form method="POST" id="delete-account-form" action="{{ route('perfil.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <button id="delete-account-button" type="button" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Excluir Conta</button>
                </form>
            </div>
        </section>
    </main>

    <!-- Confirmation modal (hidden) -->
    <div id="confirm-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);align-items:center;justify-content:center">
        <div style="background:#fff;padding:1.5rem;border-radius:.5rem;max-width:420px;margin:auto;">
            <h3 id="confirm-modal-title">Confirmar ação</h3>
            <p id="confirm-modal-message">Por favor, confirme sua senha para continuar.</p>

            <div style="margin-top:.5rem">
                <label for="confirm_password">Senha</label>
                <input id="confirm_password" type="password" class="w-full p-2 border rounded" />
                <div id="confirm_password_error" style="color:#ef4444;margin-top:.5rem;display:none"></div>
            </div>

            <div style="margin-top:1rem;display:flex;gap:.5rem;justify-content:flex-end">
                <button id="confirm-cancel" type="button" style="padding:.5rem 1rem">Cancelar</button>
                <button id="confirm-ok" type="button" style="background:#0ea5a4;color:#fff;padding:.5rem 1rem;border-radius:4px;border:0">Confirmar</button>
            </div>
        </div>
    </div>

    <script>
        (function(){
            const updateForm = document.querySelector('form[action="{{ route('perfil.update') }}"]');
            const deleteForm = document.getElementById('delete-account-form');
            const deleteButton = document.getElementById('delete-account-button');
            const modal = document.getElementById('confirm-modal');
            const modalTitle = document.getElementById('confirm-modal-title');
            const modalMessage = document.getElementById('confirm-modal-message');
            const confirmInput = document.getElementById('confirm_password');
            const confirmError = document.getElementById('confirm_password_error');
            const cancelBtn = document.getElementById('confirm-cancel');
            const okBtn = document.getElementById('confirm-ok');

            let targetForm = null;

            function showModal(title, message, form){
                modalTitle.textContent = title;
                modalMessage.textContent = message;
                confirmInput.value = '';
                confirmError.style.display = 'none';
                targetForm = form;
                modal.style.display = 'flex';
                confirmInput.focus();
            }

            function hideModal(){ modal.style.display = 'none'; targetForm = null; }

            // Intercept update submit
            if (updateForm){
                updateForm.addEventListener('submit', function(e){
                    e.preventDefault();
                    showModal('Confirmar alteração', 'Digite sua senha para confirmar as alterações no perfil.', updateForm);
                });
            }

            // Delete button opens modal
            if (deleteButton){
                deleteButton.addEventListener('click', function(){
                    showModal('Confirmar exclusão', 'Digite sua senha para confirmar a exclusão da conta.', deleteForm);
                });
            }

            cancelBtn.addEventListener('click', function(){ hideModal(); });

            okBtn.addEventListener('click', function(){
                const pw = confirmInput.value.trim();
                if (!pw){
                    confirmError.textContent = 'Senha é obrigatória.';
                    confirmError.style.display = 'block';
                    return;
                }

                // append hidden input to target form and submit
                let existing = targetForm.querySelector('input[name="current_password"]');
                if (existing) existing.value = pw; else {
                    const input = document.createElement('input');
                    input.type = 'password';
                    input.name = 'current_password';
                    input.value = pw;
                    targetForm.appendChild(input);
                }

                targetForm.submit();
            });
        })();
    </script>
</body>

</html>