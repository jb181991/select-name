<template>
    <Select2
        v-model="value"
        :options="options"
        :settings="{ settingOption: value, settingOption: value }"
        @change="changeEvt($event)"
        @select="selectEvt($event)" />
</template>

<script>
    import Select2 from 'v-select2-component';

    export default {
        components: {Select2},

        data () {
            return {
                value: '',
                options: []
            }
        },
        mounted() {
            var vm = this;

            this.getOptions();
        },
        methods: {
            changeEvt(event) {
                // change event
            },
            selectEvt(event) {
                // console.log(event.id);
                if(event.id == 0) {
                    this.$fire({
                        title: 'Enter your name',
                        input: 'text',
                        showCancelButton: true,
                        inputValidator: (value) => {
                            if (!value) {
                                return 'You need to write something!'
                            } else {
                                let error = 0;

                                if(this.hasSpecialCharacters(value) || this.hasNumber(value)) {
                                    return 'Not a valid name'
                                }
                            }
                        },
                        inputAttributes: {
                            maxlength: 50,
                        }
                    }).then((data) => {
                        this.isValid(data.value);
                    });
                }
            },
            isValid(str) {
                this.selected = '';
                fetch('api/add-name', {
                    method: 'post',
                    body: JSON.stringify({'name': str}),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.options = [];
                    this.getOptions();
                });
            },
            hasSpecialCharacters(str){
                var regex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/g;
	            return regex.test(str);
            },
            hasNumber(str) {
                return /\d/.test(str);
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