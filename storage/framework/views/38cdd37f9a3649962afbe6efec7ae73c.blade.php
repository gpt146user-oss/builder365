    <x-ui.alert tone="danger" dismissible>Unable to continue.</x-ui.alert>
    <x-ui.dropdown label="Options"><a href="/one" role="menuitem">One</a></x-ui.dropdown>
    <x-ui.modal id="create-record" title="Create record" trigger="Create">Form</x-ui.modal>
    <x-ui.drawer id="record-details" title="Record details" trigger="Details">Details</x-ui.drawer>
    <x-ui.tab-set initial="details">
        <x-ui.tab-list><x-ui.tab name="details">Details</x-ui.tab></x-ui.tab-list>
        <x-ui.tab-panel name="details">Panel</x-ui.tab-panel>
    </x-ui.tab-set>