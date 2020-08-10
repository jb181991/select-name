<template>
    <div>
        <Select2
        v-model="value"
        :options="options"
        :settings="{ settingOption: value, settingOption: value }"
        @change="changeEvt($event)"
        @select="selectEvt($event)" />

        <b-modal id="createNewModal" size="lg" hide-footer title="Create New User">
            <b-form @submit.stop.prevent="onSubmit">
                <b-form-group label="First Name" label-for="firstname">
                    <b-form-input
                        id="firstname"
                        name="firstname"
                        v-model="form.firstname"
                        :state="validateState('firstname')"
                    ></b-form-input>

                <b-form-invalid-feedback
                    id="firstname-feedback"
                >This is a required field and must be at least 3 characters.</b-form-invalid-feedback>
                </b-form-group>

                <b-form-group label="Last Name" label-for="lastname">
                    <b-form-input
                        id="lastname"
                        name="lastname"
                        v-model="form.lastname"
                        :state="validateState('lastname')"
                    ></b-form-input>

                <b-form-invalid-feedback
                    id="lastname-feedback"
                >This is a required field and must be at least 3 characters.</b-form-invalid-feedback>
                </b-form-group>

                <b-form-group label="Email" label-for="email">
                    <b-form-input
                        type="email"
                        id="email"
                        name="email"
                        v-model="form.email"
                        :state="validateState('email')"
                    ></b-form-input>

                <b-form-invalid-feedback
                    id="email-feedback"
                >This is a required field and must be a valid email.</b-form-invalid-feedback>
                </b-form-group>

                <b-form-group label="Phone Number" label-for="phonenum">
                    <b-form-input
                        type="text"
                        id="phonenum"
                        name="phonenum"
                        v-model="form.phonenum"
                        :state="validateState('phonenum')"
                        placeholder="9193215555"
                        maxLength="10"
                    ></b-form-input>

                <b-form-invalid-feedback
                    id="phonenum-feedback"
                >This is a required field and only 10 digit number</b-form-invalid-feedback>
                </b-form-group>

                <b-button type="submit" variant="primary">Save</b-button>
                <b-button class="ml-2" @click="resetForm()">Reset</b-button>
            </b-form>
        </b-modal>
    </div>
</template>

<script>
    import Select2 from 'v-select2-component';
    import { validationMixin } from "vuelidate";
    import { required, minLength, email, maxLength, alpha } from "vuelidate/lib/validators";

    export default {
        components: {Select2},
        mixins: [validationMixin],
        data () {
            return {
                value: '',
                options: [],
                form: {
                    firstname: null,
                    lastname: null,
                    phonenum: null,
                    email: null,
                },
            }
        },
        validations: {
            form: {
                firstname: {
                    required,
                    alpha,
                    minLength: minLength(2),
                    maxLength: maxLength(30)
                },
                lastname: {
                    required,
                    alpha,
                    minLength: minLength(2),
                    maxLength: maxLength(30)
                },
                email: { required, email },
                phonenum: {
                    required,
                    minLength: minLength(10),
                    maxLength: maxLength(10)
                }
            }
        },
        mounted() {
            var vm = this;

            this.getOptions();
        },
        methods: {
            validateState(name) {
                const { $dirty, $error } = this.$v.form[name];
                return $dirty ? !$error : null;
            },
            resetForm() {
                this.value = null;
                this.form = {
                    firstname: null,
                    lastname: null,
                    email: null,
                    phonenum: null
                };

                this.$nextTick(() => {
                    this.$v.$reset();
                });
            },
            onSubmit() {
                this.$v.form.$touch();

                if (this.$v.form.$anyError) {
                    return;
                } else {
                    fetch('api/add-user', {
                        method: 'post',
                        body: JSON.stringify(this.form),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.$bvModal.hide('createNewModal');
                        this.options = [];
                        this.resetForm();
                        this.getOptions();
                        this.$alert('New user has been successfully saved.','Good job!','success');
                    });
                }
            },
            changeEvt(event) {
                // change event goes here
            },
            selectEvt(event) {
                if(event.id == 0) {
                    this.$bvModal.show('createNewModal');
                }
            },
            getOptions() {
                fetch('api/get-options')
                    .then(res => res.json())
                    .then(data => {
                        this.options = data.user;
                        this.options.push({id: 0, text: 'Create New'});
                    });
            }
        }     
    }
</script>