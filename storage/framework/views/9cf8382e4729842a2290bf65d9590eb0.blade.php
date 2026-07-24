    <x-forms.field name="email" label="Email" hint="Business email" required>
        <x-forms.input name="email" type="email" required />
    </x-forms.field>
    <x-forms.field name="status" label="Status">
        <x-forms.select name="status"><option value="active">Active</option></x-forms.select>
    </x-forms.field>
    <x-forms.field name="note" label="Note">
        <x-forms.textarea name="note">Context</x-forms.textarea>
    </x-forms.field>