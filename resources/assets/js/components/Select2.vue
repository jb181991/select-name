<template>
    <select class="form-control" v-model="selected" @change="setSelected($event)">
        <option value="0">Create New</option>
        <option v-for="option in options" v-bind:value="option.id">
            {{ option.text }}
        </option>
    </select>
</template>

<script>
    export default {
        data () {
            return {
                options: [],
                selected: '',
            }
        },
        mounted() {
            var vm = this;

            this.getOptions();
        },
        methods: {
            setSelected(event) {
                if(event.target.value == 0) {
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
                    });
            }
        }     
    }
</script>