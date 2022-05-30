<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use App\Rules\UniqueEmailById;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contact = new Contacts();
        if ($request->isMethod('post') && 'new' === $request->input('form_action')) {
            $validated = $request->validate([
                'name' => 'required|max:255|min:2',
                'email' => 'required|email|unique:contacts|max:255',
                'phone_number' => 'required|max:15|min:5',
            ]);
            $contact->name = $validated['name'];
            $contact->email = $validated['email'];
            $contact->phone_number = $validated['phone_number'];
            if ($contact->save()) {
                return redirect('contact')->with('message', 'Contact created successfully!');
            }
        }

        return view('contact', [
            'form_action' => 'new',
            'contact_list' => $contact->orderBy('id', 'desc')->limit(100)->get()->toArray(),
        ]);
    }
    public function edit(Request $request, $id = null)
    {
        $contact = new Contacts();

        $editContact = ($id) ? $contact->find($id) : null;

        if (!$editContact) return redirect()->route('contact')->with('error', 'Invalid contact id ' . $id . '.');


        if (null !== $request->session()->get('_old_input')) {
            $editContact->name = $request->session()->get('_old_input.name');
            $editContact->email = $request->session()->get('_old_input.email');
            $editContact->phone_number = $request->session()->get('_old_input.phone_number');
        }


        if ($request->isMethod('post') && 'save_changes' === $request->input('form_action') &&  $editContact) {

            $validated = $request->validate([
                'name' => 'required|max:255|min:2',
                'email' => ['required', 'email', 'max:255', new UniqueEmailById],
                'phone_number' => 'required|max:15|min:5',
            ]);

            $contact = Contacts::find($id);
            $contact->name = $validated['name'];
            $contact->email = $validated['email'];
            $contact->phone_number = $validated['phone_number'];
            if ($contact->save()) {
                return redirect('contact')->with('message', 'Contact updated successfully!');
            }
        }

        return view('contact', [
            'form_action' => 'edit',
            'edit_contact' => $editContact,
            'contact_list' => $contact->orderBy('id', 'desc')->limit(100)->get()->toArray(),
        ]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'delete_id' => 'required|integer',
            'phone_number' => 'required|string:delete'
        ]);

        if ($validator->fails())
            return redirect()->route('contact')->with('error', 'Invalid delete action performed.');

        $contact =  Contacts::find($request->input('delete_id'));

        if (!$contact)
            return redirect()->route('contact')->with('error',  'Contact #' . $request->input('delete_id') . ' not exists.');

        $contact->delete();
        return redirect('contact')->with('message', 'Contact deleted successfully!');
    }
}
