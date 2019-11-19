<template>
    <div>
        <b-row class="mt-3">
            <b-col>
                <b-card header-tag="header" header="New Project">
                    <b-row class="mt-3">
                        <b-col>
                            <h6>General</h6>
                            <hr class="mt-4 mb-4">
                        </b-col>
                    </b-row>
                    <Validation-observer ref="observer" v-slot="{ passes, invalid }">
                        <b-form @submit.prevent="passes(onSubmit)" @reset="resetForm">
                            <b-row>
                                <b-col col md="8">
                                    <BTextInputWithValidation
                                        rules="required"
                                        type="text"
                                        label="Title"
                                        name="Title"
                                        v-model="form.title"
                                        placeholder="Enter title"
                                        size="sm"
                                    />
                                </b-col>
                                <b-col col md="4">
                                    <BSelectWithValidation
                                        rules="required"
                                        label="Status"
                                        v-model="form.status"
                                        size="sm"
                                    >
                                        <template v-for="item in statusOptions">
                                            <option
                                                :value="item.value"
                                                :selected="item.value === 1"
                                            >
                                                {{ item.text }}
                                            </option>
                                        </template>
                                    </BSelectWithValidation>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col col md="12">
                                    <b-form-group
                                        id="description"
                                        label="Description"
                                        label-for="description"
                                    >
                                        <b-form-input
                                            type="text"
                                            v-model="form.description"
                                            name="description"
                                            size="sm"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col col md="12">
                                    <ValidationProvider
                                        name="icon"
                                        rules="required|ext:png"
                                        v-slot="{ valid, errors }"
                                    >
                                        <b-form-group
                                            id="icon"
                                            label="Icon"
                                            label-for="icon"
                                        >
                                            <b-form-file
                                                id="icon"
                                                name="icon"
                                                v-model="form.icon"
                                                placeholder="Please pick the icon for the map"
                                                @change="handleFileIcon"
                                                size="sm"
                                            ></b-form-file>
                                            <b-form-invalid-feedback id="inputLiveFeedback">{{ errors[0] }}</b-form-invalid-feedback>
                                        </b-form-group>
                                    </ValidationProvider>
                                </b-col>
                            </b-row>

                            <b-row class="mt-3">
                                <b-col>
                                    <h6>Fields
                                        <b-button type="button" @click="newField" size="sm" class="float-right" variant="success">
                                            <i class="fa fa-plus"></i> Field
                                        </b-button>
                                    </h6>
                                    <hr class="mt-4 mb-4">
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col col sm="12">
                                    <!-- START FIELDS -->
                                    <div v-for="(field,idx) in form.fields">
                                        <b-card class="mt-3 mb-3">
                                            <template v-slot:header>
                                                <p class="p-0 m-0">Field #{{ idx+1 }}</p>
                                            </template>
                                            <b-row>
                                                <b-col col sm="8">
                                                    <b-form-group
                                                        id="label"
                                                        label="Label"
                                                        label-for="name"
                                                    >
                                                        <b-form-input v-model="field.label" size="sm"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col col sm="4">
                                                    <b-form-group
                                                        id="nullable"
                                                        label="Is Nullable ?"
                                                        label-for="nullable"
                                                    >
                                                        <b-form-select
                                                            v-model="field.nullable"
                                                            :options="optionsFieldNullableOptions"
                                                            size="sm"
                                                        >
                                                        </b-form-select>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                            <b-row>
                                                <b-col col sm="8">
                                                    <b-form-group
                                                        id="name"
                                                        label="Name"
                                                        label-for="name"
                                                    >
                                                        <b-form-input v-model="field.name" size="sm"></b-form-input>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col col sm="4">
                                                    <b-form-group
                                                        id="type"
                                                        label="Field Type"
                                                        label-for="type"
                                                    >
                                                        <b-form-select
                                                            v-model="field.type"
                                                            :options="fieldTypeOptions"
                                                            size="sm"
                                                        >
                                                        </b-form-select>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                            <b-row v-if="form.fields.length > 1">
                                                <b-col col sm="12">
                                                    <b-button type="button" class="float-right" @click="removeField(idx)" size="sm" variant="danger">
                                                        <i class="fa fa-trash-o"></i> Field
                                                    </b-button>
                                                </b-col>
                                            </b-row>
                                            <!-- START FIELD OPTIONS -->
                                            <template v-if="field.type === 'single_choice' || field.type === 'multi_choice'">
                                                <b-card class="mt-3 mb-3">
                                                    <template v-slot:header>
                                                        <h6 class="mb-0">Field #{{ idx+1 }} Options
                                                            <b-button type="button" @click="newFieldOption(idx)" size="sm" class="float-right" variant="success">
                                                                <i class="fa fa-plus"></i> Option
                                                            </b-button>
                                                        </h6>
                                                    </template>
                                                    <div v-for="(option,optionIdx) in field.options">
                                                        <b-row>
                                                            <b-col col sm="6">
                                                                <BTextInputWithValidation
                                                                    rules="required"
                                                                    type="text"
                                                                    label="Name"
                                                                    name="Name"
                                                                    v-model="option.name"
                                                                    placeholder="Enter option name"
                                                                    size="sm"
                                                                />
                                                            </b-col>
                                                            <b-col col sm="6">
                                                                <b-form-group
                                                                    id="name"
                                                                    label="Icon"
                                                                    label-for="name"
                                                                >
                                                                    <b-form-input v-model="option.icon" size="sm"></b-form-input>
                                                                </b-form-group>
                                                            </b-col>
                                                        </b-row>
                                                        <b-row v-if="form.fields.length > 1">
                                                            <b-col col sm="12">
                                                                <b-button type="button" class="float-right" @click="removeFieldOption(idx,optionIdx)" size="sm" variant="danger">
                                                                    <i class="fa fa-trash-o"></i> Option
                                                                </b-button>
                                                            </b-col>
                                                        </b-row>
                                                    </div>
                                                </b-card>
                                            </template>
                                            <!-- START FIELDS -->
                                        </b-card>
                                    </div>
                                    <!-- END FIELD OPTIONS -->
                                </b-col>
                            </b-row>


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
    import { mapGetters, mapState } from 'vuex'
    import { ValidationProvider, ValidationObserver, extend } from 'vee-validate';
    import { required, email, oneOf, ext, alpha_spaces } from "vee-validate/dist/rules";
    import BTextInputWithValidation from '../../components/form/BTextInputWithValidation';
    import BSelectWithValidation from '../../components/form/BSelectWithValidation';

    extend("required", required);
    extend("email", email);
    extend("oneOf", oneOf);
    extend("ext", ext);
    extend("alpha_spaces", alpha_spaces);

    export default {
        components: {
            ValidationProvider,
            ValidationObserver,
            BTextInputWithValidation,
            BSelectWithValidation
        },
        data() {
            return {
                form: {
                    title: '',
                    description: '',
                    icon: '',
                    fields: [
                        {
                            label: '',
                            name: '',
                            type: 'string',
                            nullable: 0,
                            options: [
                                {
                                    name: "",
                                    icon: "",
                                }
                            ],
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
                    { value: 'single_choice', text: 'Single Choice' },
                    { value: 'multi_choice', text: 'Multi Choice' },
                ]
            }
        },
        computed: {
            ...mapState({}),
            ...mapGetters('project', {})
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
                this.form.fields = [
                    {
                        label:'',
                        name: '',
                        type: 'string',
                        nullable: 0,
                        options: [
                            {
                                name: "",
                                icon: "",
                            }
                        ]
                    }
                ];
                this.form.status = 1;
                this.fileIcon = null;
            },
            newField() {
                this.form.fields.push({
                    label:'',
                    name: '',
                    type: 'string',
                    nullable: 0,
                    options: [
                        {
                            name: "",
                            icon: "",
                        }
                    ]
                });
            },
            removeField(idx) {
                this.form.fields.splice(idx,1);
            },
            newFieldOption(idx) {
                this.form.fields[idx].options.push(
                    {
                        name: "",
                        icon: "",
                    }
                );
            },
            removeFieldOption(idx,optionIdx) {
                this.form.fields[idx].options.splice(optionIdx,1);
            },
            handleFileIcon(evt){
                this.$refs.provider.validate();
                console.log(evt);
                this.fileIcon = evt.target.files[0]
            }
        }
    }
</script>
