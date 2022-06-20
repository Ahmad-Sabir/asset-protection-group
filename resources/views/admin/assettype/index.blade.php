<x-app-layout>
    <!-- Content -->
    <div class="main-wrap">
        <div class="main-fixed-wrap">
            <div class="heading">
                <h1>MANAGE ASSET TYPES</h1>
            </div>
            <div class="filters-section">
                <x-button type="submit" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#add-assettype">
                    <em class="fa-solid fa-circle-plus"></em> ADD ASSET TYPE
                </x-button>
            </div>
        </div>
        <div class="main-content">
                <livewire:table
                    :model="App\Models\Admin\Asset\AssetType::class"
                    :relations="['workOrderTitles']"
                    :where="[['type', '=', config('apg.type.master')]]"
                    view-file="admin.assettype.table"
                    />
                <livewire:sweet-alert component="table" entityTitle="Asset Type"/>
        </div>
    </div>
    <div x-data="addCustomFields()">
        <x-right-modal id="edit-assettype" heading="Edit Asset Type"></x-right-modal>
    </div>
    <div x-data="addCustomFields()">
    <x-right-modal id="add-assettype" heading="Add Asset Type">
        <form action="{{ route('admin.asset-types.store') }}" method="post" x-data="submitForm()" @submit.prevent="onSubmitPost" id="assettype-post-form">
            <div class="form-group">
                <x-label for="name" value="Name" required="true"/>
                <x-input type="text" class="form-control" x-model="formData.name" id="name" name="name" x-bind:class="errorMessages.name ? 'invalid' : ''"/>
                <span class="invalid" x-text="errorMessages.name"></span>
            </div>
            <div class="form-group work-order-asset">
                <div class="flex justify-between items-center mb-2">
                    <x-label for="work_order_title" value="Work Order Title" required="true"/>
                    <x-nav-link class="cursor-pointer uppercase primary font-medium" @click="addNewField()"><em class="fa-solid fa-plus"></em> Add Field</x-nav-link>
                </div>
                <template x-for="(field, index) in fields" :key="index">
                    <div class="flex items-center mb-4">
                        <x-input type="text" placeholder="Title" x-model="field.title" ::name="`work_order_titles[${index}][title]`" />
                        <x-nav-link class="ml-4 cursor-pointer red" @click="removeField(index)"><em class="fa-solid fa-trash"></em></x-nav-link>
                    </div>
                </template>
            </div>
            <x-button type="submit" class="btn-primary">
                <em class="fa-solid fa-check"></em> ADD Asset Type
            </x-button>
        </form>
    </x-right-modal>
    </div>
 @push('script')
    <script>
        function addCustomFields() {
            return {
                fields: [{
                    title : ''
                }],
                addNewField() {
                    this.fields.push({
                        title: '',
                    });
                },
                removeField(index) {
                    this.fields.splice(index, 1);
                }
            }
        }
    </script>
 @endpush
</x-app-layout>
