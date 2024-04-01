<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Contato') }} <!-- Título da página -->
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-alert.success></x-alert.success> <!-- Exibe uma mensagem de sucesso, se houver -->

                    <x-validation-errors class="mb-4" :errors="$errors"/> <!-- Exibe mensagens de erro de validação, se houver -->

                    <!-- Formulário para atualizar o contato -->
                    <form action="{{ route('contacts.update', $contact->id) }}" method="POST">
                        @csrf <!-- Proteção CSRF -->
                        @method('PUT') <!-- Método HTTP PUT -->

                        <!-- Iterando sobre todas as propriedades do contato -->
                        @foreach ($contact->getAttributes() as $key => $value)
                            @if (!in_array($key, ['created_at', 'updated_at', 'id']))
                                <div class="mt-4">
                                    <x-label for="{{ $key }}" :value="__(ucfirst($key))" /> <!-- Rótulo do campo -->

                                    <x-input id="{{ $key }}" class="block mt-1 w-full" type="text" name="{{ $key }}" :value="$value" required /> <!-- Campo de entrada -->
                                </div>
                            @endif
                        @endforeach

                        <x-button class="mt-4">
                            {{ __('Atualizar') }} <!-- Botão de atualização -->
                        </x-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
