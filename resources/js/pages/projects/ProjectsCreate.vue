<template>
    <div>
        <b-row class="mt-3">
            <b-col>
                <b-card header-tag="header" header="New Project">
                    <Validation-observer ref="observer" v-slot="{ passes, invalid }">
                        <b-form @submit.prevent="passes(onSubmit)" @reset="resetForm">
                            <b-row>
                                <b-col col md="8">
                                    <Validation-provider rules="required" v-slot="{ valid, errors }">
                                        <b-form-group
                                            id="title"
                                            label="Title"
                                            label-for="title"
                                        >
                                            <b-form-input
                                                id="title"
                                                v-model="form.title"
                                                type="text"
                                                placeholder="Title"
                                                name="title"
                                                :state="errors[0] ? false : (valid ? true : null)"
                                            ></b-form-input>
                                            <b-form-invalid-feedback id="input_title_feedback" :state="false">{{ errors[0] }}</b-form-invalid-feedback>
                                        </b-form-group>
                                    </Validation-provider>
                                </b-col>
                                <b-col col md="4">
                                    <b-form-group
                                        id="status"
                                        label="Status"
                                        label-for="status"
                                    >
                                        <b-form-select v-model="form.status" :options="statusOptions"></b-form-select>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-form-group
                                id="description"
                                label="Description"
                                label-for="description"
                            >
                                <b-form-input
                                    id="description"
                                    v-model="form.description"
                                    type="text"
                                    placeholder="Description"
                                ></b-form-input>
                            </b-form-group>
                            <b-form-group
                                id="icon"
                                label="Icon"
                                label-for="icon"
                            >
                                <b-form-file
                                    id="icon"
                                    v-model="form.icon"
                                    placeholder="Please pick the icon for the map"
                                    @change="handleFileIcon"
                                ></b-form-file>
                            </b-form-group>
                            <b-card>
                                <template v-slot:header>
                                    <h6 class="mb-0">Fields
                                        <b-button type="button" @click="newOption" size="sm" class="float-right" variant="success">
                                            <i class="fa fa-plus"></i>
                                        </b-button>
                                    </h6>
                                </template>
                                <!-- START OPTIONS -->
                                <div v-for="(option,idx) in form.options">
                                    <b-row>
                                        <b-col col sm="4">
                                            <b-form-group
                                                id="field_label"
                                                label="Label"
                                                label-for="field_name"
                                            >
                                                <b-form-input v-model="option.field_label"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col col sm="3">
                                            <b-form-group
                                                id="field_name"
                                                label="Name"
                                                label-for="field_name"
                                            >
                                                <b-form-input v-model="option.field_name"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col col sm="2">
                                            <b-form-group
                                                id="field_type"
                                                label="Field Type"
                                                label-for="field_type"
                                            >
                                                <b-form-select v-model="option.field_type" :options="fieldTypeOptions"></b-form-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col col sm="2">
                                            <b-form-group
                                                id="field_nullable"
                                                label="Is Nullable ?"
                                                label-for="field_nullable"
                                            >
                                                <b-form-select v-model="option.field_nullable" :options="optionsFieldNullableOptions"></b-form-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col col sm="1">
                                            <b-button type="button" style="margin-top: 35px;" @click="removeOption(idx)" size="sm" variant="danger">
                                                <i class="fa fa-trash-o"></i>
                                            </b-button>
                                        </b-col>
                                    </b-row>
                                </div>
                                <!-- END OPTIONS -->
                            </b-card>

                            <hr>
                            <b-button type="submit" variant="outline-danger" :disabled="invalid">Submit</b-button>
                            <b-button type="button" variant="outline-success">Back to list</b-button>
                        </b-form>
                    </Validation-observer>
                </b-card>
                <b-card class="mt-3" header="Form Data Result">
                    <pre class="m-0">{{ form }}</pre>
                </b-card>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import { ValidationProvider, ValidationObserver, extend } from 'vee-validate';
    import { required } from 'vee-validate/dist/rules';

    extend('required', required);

    export default {
        components: {
            ValidationProvider,
            ValidationObserver
        },
        data() {
            return {
                form: {
                    title: '',
                    description: '',
                    icon: '',
                    options: [
                        {
                            field_name: '',
                            field_type: 'string',
                            field_nullable: 0,
                        }
                    ],
                    status: 1,
                },
                showErrorMessage: false,
                validationErrors : [],
                statusOptions: [
                    { value: 0, text: 'Inactive' },
                    { value: 1, text: 'Active' },
                ],
                optionsFieldNullableOptions: [
                    { value: 0, text: 'No' },
                    { value: 1, text: 'Yes' },
                ],
                fieldTypeOptions: [
                    { value: 'boolean', text: 'Boolean' },
                    { value: 'string', text: 'String' },
                    { value: 'integer', text: 'Integer' },
                    { value: 'decimal', text: 'Decimal' },
                ]
            }
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();


                let formData = new FormData();
                formData.append('icon', this.fileIcon);

                this.axios.post('projects',this.form)
                    .then((response) => {

                        let url = `projects/${response.data.data.id}/icons`;


                        this.axios.post(url, formData , { headers: {
                                'Content-Type': 'multipart/form-data'
                            }})
                            .then(response => {
                                console.log(response);

                            })
                            .catch(error => {
                                if (error.response.status === 422){
                                    this.validationErrors = error.response.data.errors;
                                }else{
                                    this.showErrorMessage = true;
                                }
                            });

                        //console.log(response.data);
                        //this.resetForm();
                    })
                    .catch((err) => {
                        if (error.response.status === 422){
                            this.validationErrors = error.response.data.errors;
                        }else{
                            this.showErrorMessage = true;
                        }
                    });

            },
            resetForm(evt) {
                // Reset our form values
                this.form.title = '';
                this.form.description = '';
                this.form.options = [
                    {
                        field_name: '',
                        field_type: 'string',
                        field_nullable: 0,
                    }
                ];
                this.form.status = 1;
                this.fileIcon = null;
            },
            newOption() {
                this.form.options.push({
                    field_name: '',
                    field_type: 'string',
                    field_nullable: 0,
                });
            },
            removeOption(idx) {
                this.form.options.splice(idx,1);
            },
            handleFileIcon(evt){
                console.log(evt);
                this.fileIcon = evt.target.files[0]
            }
        }
    }
</script>
