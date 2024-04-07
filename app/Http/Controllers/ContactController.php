<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Exibe a lista de contatos
    public function index(Request $request)
    {
        $perPageOptions = [10, 50, 100, 200, 500];
        $perPage = $request->query('perPage', 10);
        $contacts = Contact::orderBy('id', 'asc')->paginate($perPage);

        return view('contacts.index', compact('contacts', 'perPageOptions', 'perPage'));
    }

    // Exibe o formulário de edição de um contato específico
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);

        return view('contacts.edit', compact('contact'));
    }

    // Exclui um contato específico do banco de dados
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contato excluído com sucesso.');
    }

    // Exclui todos os contatos selecionados
    public function destroyAll(Request $request)
    {
        $ids = $request->input('ids');
        if ($ids) {
            Contact::whereIn('id', json_decode($ids))->delete();

            return redirect()->route('contacts.index')->with('success', 'Contatos selecionados excluídos com sucesso.');
        } else {
            return redirect()->route('contacts.index')->with('error', 'Nenhum contato selecionado para exclusão.');
        }
    }

    // Atualiza os dados de um contato específico
// Atualiza os dados de um contato específico
    public function update(Request $request, $id)
    {   
    $contact = Contact::findOrFail($id);

    // Atualiza os dados do contato com os dados fornecidos
    $contact->update($request->all());

    return redirect()->route('contacts.index')->with('success', 'Contato atualizado com sucesso.');
}

}
