<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form @submit.prevent="formSubmit">
                    <div class="card">
                        <div class="card-header">Create Questions</div>

                            <div class="card-body">

                                <div class="form-group mt-3" v-if="form.success">
                                    <div class="alert alert-success" role="alert">
                                        Question created successfully
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="title" class="mb-2">Title:</label>
                                    <input type="text" required class="form-control" id="title" placeholder="Enter Question Title" name="title" v-model="title">
                                </div>        
                                
                                <div class="form-group mt-3">
                                    <label for="time" class="mb-2">Time (Seconds):</label>
                                    <input type="number" required class="form-control" id="time" placeholder="Enter Time in Seconds" name="time" v-model="time">
                                </div>   
                                
                                <div class="form-group mt-3">
                                    <label for="time" class="mb-2">Options:</label>
                                    <vue-tags-input placeholder="Options" class="tags-input" :allow-edit-tags="true" v-model="tag" :tags="tags" @tags-changed="newTags => tags = newTags"/>
                                </div>

                                <div class="form-group mt-3" v-if="tags.length > 0">
                                    <div class="col-sm-4">
                                        <label for="time" class="mb-2">Choose Correct Answer:</label>
                                        <select class="form-select" v-model="correctanswer">
                                            <option v-for="tag in tags">{{tag.text}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group mt-3" v-if="!form.validation">
                                    <div class="alert alert-danger" role="alert">
                                        Please select the correct answer
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <div class="alert alert-danger" role="alert" v-for="error in errors">
                                        {{error[0]}}
                                    </div>
                                </div>

                            </div>

                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit" v-if="!form.loading">Submit</button>
                            <button class="btn btn-primary" type="submit" v-if="form.loading">Saving.....</button>
                            <button class="btn btn-danger" v-on:click="cancelForm()">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import VueTagsInput from '@johmun/vue-tags-input';

    export default {
        components: {
            VueTagsInput,
        },
        data() {
            return {
                title:"",
                time:"",
                tag: '',
                correctanswer:"",
                tags: [],

                form: {
                    submitted: false,
                    loading:false,
                    validation:true,
                    success:false,
                },

                errors:[],
            };
        },
        methods: {

            async formSubmit() {
                const vm = this;

                if(vm.checkValidation()){                                     
                    vm.form.validation = true;
                    vm.form.loading = true;
                    vm.form.success = false;
                    vm.errors = [];

                    axios.post('/api/question', {
                        'question': vm.title,
                        'time':vm.time,
                        'options':vm.tags.map(({text}) => ({text})),
                        'correctanswer':vm.correctanswer,
                    }).then(function (response) {
                        if(response.data.message === 'success'){
                            vm.form.success = true;
                            vm.form.loading = false;
                            vm.cancelForm();
                        }else{
                            vm.form.loading = false;
                            vm.errors = response.data.error;
                        }
                    }).catch(error => {

                    });

                }else{                    
                   vm.form.validation = false;
                }
            },

            checkValidation(){
                if(this.correctanswer === ""){
                    return false;
                }else{
                    return true;
                }
            },

            cancelForm(){
                this.form.loading = false;
                this.title = "";
                this.time = "";
                this.tag = '';
                this.tags = [];
            }
        }
    }
</script>
