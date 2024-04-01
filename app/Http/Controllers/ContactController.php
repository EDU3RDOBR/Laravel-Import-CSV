<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Exibe a lista de contatos
    public function index()
    {
        $contacts = Contact::orderBy('id', 'asc')->paginate(10);

        return view('contacts.index', compact('contacts'));
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
    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        
        // Valida os dados de entrada
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);
        
        // Atualiza os dados do contato com os dados fornecidos
        $contact->update($validatedData);

        return redirect()->route('contacts.index')->with('success', 'Contato atualizado com sucesso.');
    }
}