<form action="{{ route("admin.companies.asset-types.update", ["company" => $data['company_id'], "asset_type" => $data['id']]) }}" method="post" x-data="submitForm()" @submit.prevent="onSubmitPut" id="assettype-patch-form">
    @isset($data['show'])
    <table class="admin-table mt-4" aria-label="">
        <th></th>
        <tbody>
            <tr class="border-b">
                <td class="gray3">ID</td>
                <td class="text-right">{{ $data['id'] }}</td>
            </tr>
            <tr class="border-b">
                <td class="gray3">Name</td>
                <td class="text-right">{{ $data['name'] }}</td>
            </tr>
        </tbody>
    </table>
    <div class="border-t pt-10">
        <h4 class="uppercase font-semibold">Work Order Titles</h4>
        <div class="apg-bullets block mt-4">
            <ul class="gray1">
                @foreach ($data['work_order_titles'] as $work_orders)
                    <li>{{ $work_orders['title'] }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endisset
   @isset($data['edit'])
    <div class="form-group">
        <x-label for="name" value="Asset Type" required="true" />
        <x-input type="text" class="form-control" id="name" name="name" value="{{ $data['name'] }}"
            x-bind:class="errorMessages.name ? 'invalid' : ''" />
        <span class="invalid" x-text="errorMessages.name"></span>
    </div>
    <div class="form-group work-order-asset" x-data="{fields: {{json_encode($data['work_order_titles'])}}}">
        <div class="flex justify-between items-center mb-2">
            <x-label for="work_order_title" value="Work Order Title" required="true"/>
            <x-nav-link class="cursor-pointer uppercase primary font-medium" @click="addNewField()"><em class="fa-solid fa-plus"></em> Add Field</x-nav-link>
        </div>
        <template x-for="(field, index) in fields" :key="index">
            <div class="flex items-center mb-4">
                <x-input type="text" placeholder="Title" x-model="field.title" ::name="`work_order_titles[${index}][title]`" />
                <x-nav-link class="ml-4 cursor-pointer red" @click="removeField(index)"><em class="fa-solid fa-trash"></em></x-nav-link>
            </div>
            <div class="flex items-center mb-4">
                <x-input type="text" placeholder="Title" x-model="field.title" ::name="`work_order_titles[${index}][title]`" />
                <x-nav-link class="ml-4 cursor-pointer red" @click="removeField(index)"><em class="fa-solid fa-trash"></em></x-nav-link>
            </div>
        </template>
    </div>
    <x-button type="submit" class="btn-primary">
        <em class="fa-solid fa-check"></em> EDIT Asset Type
    </x-button>
   @endisset
</form>
