<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contatos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-alert.success></x-alert.success>

                    <x-validation-errors class="mb-4" :errors="$errors"/>

                    <form action="{{ route('import_parse') }}" method="POST" class="mb-4" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <x-label for="csv_file" :value="__('Arquivo CSV para importar')"/>

                            <x-input id="csv_file" class="block mt-1 w-full" type="file" name="csv_file" required/>
                        </div>

                        <div class="mt-4 flex items-center">
                            <x-label for="header" :value="__('O arquivo contém linha de cabeçalho?')"/>

                            <x-input id="header" class="ml-1" type="checkbox" name="header" checked/>
                        </div>

                        <x-button class="mt-4">
                            {{ __('Enviar') }}
                        </x-button>
                    </form>

                    <div class="overflow-hidden overflow-x-auto min-w-full align-middle sm:rounded-md">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50">
                                        <input type="checkbox" id="select-all-checkbox">
                                    </th>
                                    @if($contacts->isNotEmpty() && $contacts->first())
                                        @foreach ($contacts->first()->getAttributes() as $key => $value)
                                            <th class="px-6 py-3 bg-gray-50">
                                                <span class="text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ ucfirst($key) }}</span>
                                            </th>
                                        @endforeach
                                    @endif
                                    <th class="px-6 py-3 bg-gray-50">
                                        <span class="text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Actions</span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                            @foreach($contacts as $contact)
                                <tr class="bg-white">
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        <input type="checkbox" name="selected_contacts[]" value="{{ $contact->id }}">
                                    </td>
                                    @foreach ($contact->getAttributes() as $value)
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            {{ $value }}
                                        </td>
                                    @endforeach
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        <a href="{{ route('contacts.edit', $contact->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                        <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <form id="delete-all-form" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="button" id="delete-all-btn" class="text-red-600 hover:text-red-900 mt-4">Excluir todos selecionados</button>
                    </form>

                    {{ $contacts->links() }}

                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('delete-all-btn').addEventListener('click', function() {
            var selectedContacts = document.querySelectorAll('input[name="selected_contacts[]"]:checked');
            var selectedIds = Array.from(selectedContacts).map(function(element) {
                return element.value;
            });

            if (selectedIds.length > 0) {
                var form = document.getElementById('delete-all-form');
                form.action = "{{ route('contacts.destroy.all') }}";
                var idsInput = document.createElement('input');
                idsInput.type = 'hidden';
                idsInput.name = 'ids';
                idsInput.value = JSON.stringify(selectedIds);
                form.appendChild(idsInput);
                form.submit();
            } else {
                alert('Por favor, selecione pelo menos um contato para excluir.');
            }
        });

        document.getElementById('select-all-checkbox').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('input[name="selected_contacts[]"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = this.checked;
            }, this);
        });
    </script>

</x-app-layout>
