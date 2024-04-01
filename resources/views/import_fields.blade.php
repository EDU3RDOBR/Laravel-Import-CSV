<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Selecionar campos') }} <!-- Título da página -->
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-validation-errors class="mb-4" :errors="$errors"/> <!-- Exibe mensagens de erro de validação, se houver -->

                    <!-- Formulário para processar a importação -->
                    <form action="{{ route('import_process') }}" method="POST">
                        @csrf <!-- Proteção CSRF -->

                        <x-input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file->id }}"/> <!-- Campo oculto para armazenar o ID do arquivo CSV -->

                        <table class="min-w-full divide-y divide-gray-200 border">
                            @if (isset($headings))
                                <thead>
                                <tr>
                                    @foreach ($headings[0][0] as $csv_header_field)
                                        <th class="px-6 py-3 bg-gray-50">
                                            <span class="text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ $csv_header_field }}</span> <!-- Cabeçalho da tabela com os campos do arquivo CSV -->
                                        </th>
                                    @endforeach
                                </tr>
                                </thead>
                            @endif

                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                            @foreach($csv_data as $row)
                                <tr class="bg-white">
                                    @foreach ($row as $key => $value)
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            {{ $value }} <!-- Exibe os dados de cada linha do arquivo CSV -->
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach

                            <tr>
                                @foreach ($csv_data[0] as $key => $value)
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        <select name="fields[{{ $key }}]">
                                            @foreach (config('app.db_fields') as $db_field)
                                                <option value="{{ (\Request::has('header')) ? $db_field : $loop->index }}"
                                                        @if ($key === $db_field) selected @endif>{{ $db_field }}</option> <!-- Opções do menu suspenso com os campos do banco de dados -->
                                            @endforeach
                                        </select>
                                    </td>
                                @endforeach
                            </tr>
                            </tbody>
                        </table>

                        <x-button class="mt-4">
                            {{ __('Enviar') }} <!-- Botão de envio -->
                        </x-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
